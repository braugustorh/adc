<?php

namespace App\Filament\Pages;

use App\Models\User;
use Filament\Forms\Components\FileUpload;
use Filament\Pages\Page;
use Filament\Forms\Form;
use Filament\Forms\Components\Actions;
use Filament\Forms\Components\Actions\Action;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\IndicatorProgressTemplateExport;
use App\Imports\IndicatorProgressImport;
use Illuminate\Support\Facades\Validator;
use Filament\Notifications\Notification;

class BulkImportIndicator extends Page
{
    protected static ?string $navigationIcon = 'heroicon-m-arrow-up-on-square';
    protected static ?string $navigationLabel = 'Importación de Indicadores';
    protected static ?string $navigationGroup = 'Tablero de Control';
    protected ?string $heading = 'Tablero de Control';
    protected ?string $subheading = 'Importación masiva de indicadores';
    protected static ?int $navigationSort = 3;
    protected static string $view = 'filament.pages.bulk-import-indicator';

    public ?array $bulkImport = [
    ];

    public static function canView(): bool
    {
        //Este Panel solo lo debe de ver los Jefes de Área y el Administrador
        //Se debe de agregar la comprobación de que estpo se cumpla para que solo sea visible para los Jefes de Área
        if (\auth()->user()->hasRole('RH Corp')||\auth()->user()->hasRole('RH') || \auth()->user()->hasRole('Supervisor') || \auth()->user()->hasRole('Administrador')) {
            return true;
        }else{
            return false;
        }

    }
    public static function shouldRegisterNavigation(): bool
    {
        // Esto controla la visibilidad en la navegación.
        return static::canView();
    }

    protected function getForms(): array
    {
        return ['bulkImportForm'];
    }

    public function bulkImportForm(Form $form): Form
    {
        return $form
            ->schema([
                FileUpload::make('file')
                    ->label('Archivo de Carga Masiva')
                    ->acceptedFileTypes([
                        'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet', // .xlsx
                        'text/csv',
                    ])
                    ->disk('sedyco_disk')
                    ->rules([
                        'required',
                        'file',
                        'mimes:xlsx,csv',
                    ])
                    ->key('file')
                    ->helperText('Selecciona el archivo de Plantilla con los indicadores a importar')
                    ->statePath('bulkImport.file'),
                Actions::make([
                    Action::make('import')
                        ->label('Importar')
                        ->action('import')
                        ->color('primary')
                        ->icon('heroicon-s-cloud-arrow-up'),
                    Action::make('downloadTemplate')
                        ->label('Descargar Plantilla')
                        ->action('downloadTemplate')
                        ->color('info')
                        ->icon('heroicon-s-document-arrow-down'),
                ]),
            ]);
    }

    public function downloadTemplate()
    {
        // Obtener los usuarios e indicadores basados en la consulta del supervisor
        $supervisorId = auth()->user()->position_id;

        $users = User::where('status', true)
            ->whereNotNull('department_id')
            ->whereNotNull('position_id')
            ->whereNotNull('sede_id')
            ->whereHas('position', function ($query) use ($supervisorId) {
                $query->where('supervisor_id', $supervisorId);
            })
            ->with('indicators') // Cargar los indicadores de cada usuario
            ->get();

        // Generar y descargar la plantilla
        return Excel::download(new IndicatorProgressTemplateExport($users), 'indicator_progress_template.xlsx');
    }

    public function import()
    {
        // Validar que el archivo exista
        if (!isset($this->bulkImport['file'])) {
            Notification::make()
                ->danger()
                ->title('Error en la importación')
                ->body('No se ha seleccionado ningún archivo.')
                ->duration(5000)
                ->send();
            return;
        }

        $key=array_keys($this->bulkImport['file']);
        $name=$this->bulkImport['file'][$key[0]]->getFilename();
        $filePath = storage_path('app/livewire-tmp/' . $name);
        // Verifica que el archivo exista
        if (!file_exists($filePath)) {
            Notification::make()
                ->danger()
                ->title('Error en la importación')
                ->body('El archivo no existe en la ruta especificada.')
                ->duration(5000)
                ->send();
            return;
        }

        // Obtener los usuarios válidos basados en la consulta del supervisor
        $supervisorId = auth()->user()->position_id;
        $validUserIds = User::where('status', true)
            ->whereNotNull('department_id')
            ->whereNotNull('position_id')
            ->whereNotNull('sede_id')
            ->whereHas('position', function ($query) use ($supervisorId) {
                $query->where('supervisor_id', $supervisorId);
            })
            ->pluck('id')->toArray();

        // Procesar el archivo

        $import = new IndicatorProgressImport($validUserIds);

        try {
            Excel::import($import, $filePath);

            // Mostrar resultados
            Notification::make()
                ->success()
                ->title('Importación Realizada')
                ->body('Se importaron ' . $import->getRowCount() . ' registros correctamente.')
                ->duration(5000)
                ->send();

            // Limpiar formulario
            $this->reset('bulkImport');
            $this->dispatch('reset-file');

            // Eliminar el archivo temporal
            if (file_exists($filePath)) {
                unlink($filePath);
            }

        } catch (\Maatwebsite\Excel\Validators\ValidationException $e)  {
            // Captura los errores de validación y muestra los mensajes personalizados
            $errors = $e->validator->errors()->all();

            Notification::make()
                ->danger()
                ->title('Error en la importación')
                ->body('Errores encontrados: <br>' . implode(', ', $errors))
                ->duration(10000)
                ->send();
            // Limpiar formulario
            $this->reset('bulkImport');
            // Eliminar el archivo temporal
            if (file_exists($filePath)) {
                unlink($filePath);
            }

        } catch (\Exception $e) {
            // Captura cualquier otro error

            Notification::make()
                ->danger()
                ->title('Error en la importación')
                ->body('Ocurrió un error durante la importación: ' . $e->getMessage())
                ->duration(10000)
                ->send();
            // Limpiar formulario
            $this->reset('bulkImport');
            // Eliminar el archivo temporal
            if (file_exists($filePath)) {
                unlink($filePath);
            }
        }



    }
}
