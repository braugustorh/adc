<?php

namespace App\Filament\Resources\EvaluationAssignResource\Pages;

use App\Filament\Resources\EvaluationAssignResource;
use App\Imports\EvaluatedNetworkImport;
use Illuminate\Support\Facades\Cache;
use EightyNine\ExcelImport\ExcelImportAction;
use Filament\Actions;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\ListRecords;

class ListEvaluationAssigns extends ListRecords
{
    protected static string $resource = EvaluationAssignResource::class;

    protected function getHeaderActions(): array
    {
        return [
            \Filament\Actions\Action::make('downloadTemplate')
                ->label('Descargar Plantilla')
                ->icon('heroicon-m-cloud-arrow-down')
                ->action(fn () => EvaluationAssignResource::downloadTemplate())
                ->color('success'),
            ExcelImportAction::make()
                ->color("info")
                ->use(EvaluatedNetworkImport::class)
                ->afterImport(function ($data) {
                    $importId = EvaluatedNetworkImport::getLastImportId();

                    if (is_null($importId)) {
                        Notification::make()
                            ->title('Error en la importación')
                            ->body('No se pudo obtener el ID de importación. Por favor, intenta de nuevo.')
                            ->danger()
                            ->send();
                        return;
                    }

                    \Log::info('afterImport ejecutado', ['importId' => $importId, 'data' => $data]);

                    $results = EvaluatedNetworkImport::getImportResults($importId);
                    $rowCount = $results['rowCount'];
                    $failures = $results['failures'];
                    $error = $results['error'];

                    if ($error) {
                        Notification::make()
                            ->title('Error en la importación')
                            ->body("Ocurrió un error durante el procesamiento: $error")
                            ->danger()
                            ->send();
                    } elseif (count($failures) > 0) {
                        $errorMessage = 'Se encontraron errores en ' . count($failures) . ' filas: ';
                        foreach ($failures as $failure) {
                            $errorMessage .= 'Fila ' . $failure->row() . ': ' . implode(', ', $failure->errors()) . '. ';
                        }

                        Notification::make()
                            ->title('Importación con errores')
                            ->body("Se importaron $rowCount registros correctamente. $errorMessage")
                            ->warning()
                            ->send();
                    } else {
                        Notification::make()
                            ->title('Importación completada')
                            ->body("Se han importado $rowCount registros correctamente.")
                            ->success()
                            ->send();
                    }

                    Cache::forget("import_{$importId}");
                }),
            Actions\CreateAction::make(),
        ];
    }
}
