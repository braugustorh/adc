<?php

namespace App\Filament\Pages;

use App\Models\Campaign;
use App\Models\User;
use App\Models\Indicator;
use App\Models\IndicatorRange;
use App\Models\IndicatorProgress;
use Filament\Forms\Components\Builder;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Form;
use Filament\Forms\Contracts\HasForms;
use Filament\Pages\Page;
use Filament\Notifications\Notification;
use Filament\Support\Exceptions\Halt;
use Filament\Forms\Components\Actions\Action;
use Filament\Forms\Components\Component;


class ControlPanel extends Page implements HasForms
{
    use InteractsWithForms;
    public ?array $data = [];
    public ?array $progresses = [
        'indicator_id' => null,
        'month' => null,
        'progresse_value' => null,
    ];
    private array $months = [
        1 => 'Enero',
        2 => 'Febrero',
        3 => 'Marzo',
        4 => 'Abril',
        5 => 'Mayo',
        6 => 'Junio',
        7 => 'Julio',
        8 => 'Agosto',
        9 => 'Septiembre',
        10 => 'Octubre',
        11 => 'Noviembre',
        12 => 'Diciembre',
    ];

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-group';
    protected static ?string $navigationLabel = 'Registro de Indicadores';
    protected static ?string $navigationGroup = 'Tablero de Control';
    protected ?string $heading = 'Tablero de Control';
    protected ?string $subheading = 'Registro de Indicadores';
    protected static ?int $navigationSort = 1;
    protected static string $view = 'filament.pages.control-panel';

    public $user;
    public $users;
    public $userToEvaluated;
    public $campaignId;
    public $show = false;
   // public $month, $avance, $indicador_mes;
    public $indicatorProgresses;

    public static function canView(): bool
    {
        //Este Panel solo lo debe de ver los Jefes de Área y el Administrador
        //Se debe de agregar la comprobación de que estpo se cumpla para que solo sea visible para los Jefes de Área

        return \auth()->user()?->hasAnyRole('RH','Administrador','Super Administrador','RH Corp','Supervisor');

    }
    public static function shouldRegisterNavigation(): bool
    {
        // Esto controla la visibilidad en la navegación.

            return static::canView();


    }

    protected function getForms(): array
    {
        return [
            'formIndicador'
        ];
    }
    public function mount()
    {

        $this->campaignId = Campaign::whereStatus('Activa')->first()->id ?? null;
        $supervisorId = auth()->user()->position_id;

        $this->users = User::where('status', true)
            ->whereNotNull('department_id')
            ->whereNotNull('position_id')
            ->whereNotNull('sede_id')
            ->whereHas('position', function ($query) use ($supervisorId) {
                $query->where('supervisor_id', $supervisorId);
            })
            ->get();

    }

    public function formIndicador(Form $form):Form
    {
        return $form->
        schema([
            Repeater::make('indicadores')
            ->schema([
                TextInput::make('name')->label('Nombre del Indicador')->required(),
                Textarea::make('objective_description')->label('Descripción del Indicador')->required(),
                TextInput::make('evaluation_formula')->label('Fórmula')->required(),
                Select::make('indicator_type')->label('Tipo de Indicador')->options([
                    '1' => 'Cuantitativo',
                ])->required(),
                TextInput::make('target_value')->type('number')->label('Objetivo')->required(),
                Select::make('indicator_category_id')->label('Categoría')->options([
                    '1' => 'Estratégico',
                    '2' => 'Operativo',
                    '3' => 'Táctico',
                ])->required(),
                Select::make('indicator_unit_id')->label('Unidad de Medida')->options([
                    '1' => 'Porcentaje',
                    '2' => 'Número',
                    '3' => 'Moneda',
                    '4' => 'Otro',
                ])->required(),
                Select::make('periodicity')->label('Periodicidad')->required()->options([
                    '1' => 'Mensual',
                    '2' => 'Bimestral',
                    '3' => 'Trimestral',
                    '4' => 'Semestral',
                    '5' => 'Anual',
                ]),
                DatePicker::make('target_period_start')->label('Fecha de Inicio')->required(),
                DatePicker::make('target_period_end')->label('Fecha de Cumplimiento')->required(),
                Section::make('Rangos de Evaluación')
            ->Schema([
                Grid::make(12)
                    ->schema([
                        Select::make('type_excellent')
                            ->label('Rango para excelente')
                            ->options([
                                '1' => 'Mayor que',
                                '2' => 'Menor que',
                                '3' => 'Igual a',
                                '4' => 'Mayor o igual que',
                                '5' => 'Menor o igual que',
                                '6' => 'Entre',
                            ])
                            ->reactive()
                            ->required()
                            ->columnSpan(fn ($get) => $get('type_excellent') === '6' ? 4 : 6),

                        TextInput::make('excellent_value')
                            ->type('number')
                            ->label(fn ($get) => $get('type_excellent') === '6' ? 'Valor Menor' : 'Valor')
                            ->required()
                            ->columnSpan(fn ($get) => $get('type_excellent') === '6' ? 4 : 6),

                        TextInput::make('maximum_value')
                            ->type('number')
                            ->reactive()
                            ->label('Valor Mayor')
                            ->visible(fn ($get): bool => $get('type_excellent') === '6')
                            ->required(fn ($get): bool => $get('type_excellent') === '6')
                            ->columnSpan(4),

                        Select::make('type_satisfactory')
                            ->label('Rango para Satisfactorio')
                            ->options([
                                '1' => 'Mayor que',
                                '2' => 'Menor que',
                                '3' => 'Igual a',
                                '4' => 'Mayor o igual que',
                                '5' => 'Menor o igual que',
                                '6' => 'Entre',
                            ])
                            ->required()
                            ->reactive()
                            ->columnSpan(fn ($get) => $get('type_satisfactory') === '6' ? 4 : 6),

                        TextInput::make('satisfactory_value')
                            ->type('number')
                            ->label(fn ($get) => $get('type_satisfactory') === '6' ? 'Valor Menor' : 'Valor')
                            ->required()
                            ->columnSpan(fn ($get) => $get('type_satisfactory') === '6' ? 4 : 6),
                        TextInput::make('satisfactory_maximum_value')
                            ->type('number')
                            ->reactive()
                            ->label('Valor Mayor')
                            ->visible(fn ($get): bool => $get('type_satisfactory') === '6')
                            ->required(fn ($get): bool => $get('type_satisfactory') === '6')
                            ->columnSpan(4),

                        Select::make('type_unsatisfactory')
                            ->label('Rango para Insatisfactorio')
                            ->options([
                                '1' => 'Mayor que',
                                '2' => 'Menor que',
                                '3' => 'Igual a',
                                '4' => 'Mayor o igual que',
                                '5' => 'Menor o igual que',
                                '6' => 'Entre',
                            ])
                            ->required()
                            ->reactive()
                            ->columnSpan(fn ($get) => $get('type_unsatisfactory') === '6' ? 4 : 6),

                        TextInput::make('unsatisfactory_value')
                            ->type('number')
                            ->label(fn ($get) => $get('type_excellent') === '6' ? 'Valor Menor' : 'Valor')
                            ->required()
                            ->columnSpan(fn ($get) => $get('type_unsatisfactory') === '6' ? 4 : 6),
                        TextInput::make('unsatisfactory_maximum_value')
                            ->type('number')
                            ->reactive()
                            ->label('Valor Mayor')
                            ->visible(fn ($get): bool => $get('type_unsatisfactory') === '6')
                            ->required(fn ($get): bool => $get('type_unsatisfactory') === '6')
                            ->columnSpan(4),

                    ]),
                ])->columns(2)
            ])->columns(2)
                ->collapsed()
            ->itemLabel(fn($state):?String=> ($state['name'])??null)
                ->deleteAction(
                    function (Action $action): void {

                        $action->requiresConfirmation();
                       //$this->deleteIndicator(($state['id'])); // Accedes directamente al ID
                    }
                )
        ])->statePath('data');
    }
//    public function formProgresses(Form $form):Form
//    {
//        return $form->
//        schema([
//            Select::make('indicator_id')
//                ->label('Indicador')
//                ->options(function () {
//                   return Indicator::where('user_id', $this->user)->pluck('name', 'id')->toArray();
//                   })
//                ->preload()
//                ->searchable()
//                ->required()
//                ->placeholder('Indicadores')
//                ->statePath('progresses.indicator_id'),
//            Select::make('month')
//            ->label('Mes')
//                ->options([
//                    '1' => 'Enero',
//                    '2' => 'Febrero',
//                    '3' => 'Marzo',
//                    '4' => 'Abril',
//                    '5' => 'Mayo',
//                    '6' => 'Junio',
//                    '7' => 'Julio',
//                    '8' => 'Agosto',
//                    '9' => 'Septiembre',
//                    '10' => 'Octubre',
//                    '11' => 'Noviembre',
//                    '12' => 'Diciembre',
//                ])
//                ->statePath('progresses.month')
//                ->required(),
//            TextInput::make('progresse_value')->type('number')->label('Avance')->required()
//                ->statePath('progresses.progresse_value'),
//        ])->columns(3);
//    }

    public function updatedUser($value): void
    {
        // dd($this->user);
        $this->userToEvaluated = User::find($value);
        if ($this->userToEvaluated) {

            $this->show = true;

            $this->getIndicatorProgressesForUser($this->user);

            $this->data = [
                'indicadores' => Indicator::where('user_id', $this->user)
                ->with('indicatorRanges')->get()->map(function ($indicador) {
                    return [
                        'id'=>$indicador->id,
                        'name' => $indicador->name,
                        'objective_description' => $indicador->objective_description,
                        'evaluation_formula' => $indicador->evaluation_formula,
                        'indicator_type' => $indicador->indicator_type,
                        'target_value' => $indicador->target_value,
                        'indicator_category_id' => $indicador->type_of_target,
                        'indicator_unit_id' => $indicador->indicator_unit_id,
                        'periodicity' => $indicador->periodicity,
                        'target_period_start' => $indicador->target_period_start,
                        'target_period_end' => $indicador->target_period_end,
                        'type_excellent' => $indicador->indicatorRanges->expression_excellent ?? null,
                        'excellent_value' => $indicador->indicatorRanges->excellent_threshold ?? null,
                        'type_satisfactory' => $indicador->indicatorRanges->expression_satisfactory ?? null,
                        'satisfactory_value' => $indicador->indicatorRanges->satisfactory_threshold ?? null,
                        'type_unsatisfactory' => $indicador->indicatorRanges->expression_unsatisfactory ?? null,
                        'unsatisfactory_value' => $indicador->indicatorRanges->unsatisfactory_threshold ?? null,
                    ];
                })->toArray()
            ];
            $this->formIndicador->fill($this->data);

        } else {
            //Añadir error bags para mostrar mensaje de error
            $this->show = false;
        }


    }
//    public function addValue()
//    {
//        $this->dispatch('open-modal', id: 'add-value');
//    }

//    public function save()
//    {
//       // dd(now()->year);
//        try{
//            $newProgress = IndicatorProgress::create([
//                'indicator_id' => $this->progresses['indicator_id'],
//                'month' => $this->progresses['month'],
//                'year' => now()->year,
//                'progress_value' =>$this->progresses['progresse_value'],
//            ]);
//        }catch (Halt $e){
//            return;
//        }
//        $monthName = $this->months[$this->progresses['month']] ?? 'Mes desconocido';
//
//        $this->getIndicatorProgressesForUser($this->user);
//        Notification::make()
//            ->success()
//            ->title('Haz registrado el avance del colaborador del mes de ' . $monthName)
//            ->send();
//    }
//    public function closeModal()
//    {
//       //Agregar limpiar el modal
//        $this->dispatch('close-modal', id: 'add-value');
//    }
    public function saveIndicador()
    {

        foreach ($this->data['indicadores'] as $indicador) {
            // Crea el indicador
            $newIndicator = Indicator::updateOrCreate([
                'user_id' => $this->user,
                'evaluated_by' => auth()->id(), // O el ID que corresponda
                'name' => $indicador['name'],
                'objective_description' => $indicador['objective_description'],
                'evaluation_formula' => $indicador['evaluation_formula'],
                'indicator_type' => $indicador['indicator_type'],
                'target_value' => $indicador['target_value'],
                'type_of_target' => $indicador['indicator_category_id'],
                'indicator_unit_id' => $indicador['indicator_unit_id'],
                'periodicity' => $indicador['periodicity'],
                'target_period_start' => $indicador['target_period_start'],
                'target_period_end' => $indicador['target_period_end'],
            ]);
            IndicatorRange::create([
                'indicator_id' => $newIndicator->id,
                'expression_excellent' => $indicador['type_excellent'],
                'excellent_threshold' => $indicador['excellent_value'],
                'expression_satisfactory' => $indicador['type_satisfactory'],
                'satisfactory_threshold' => $indicador['satisfactory_value'],
                'expression_unsatisfactory' => $indicador['type_unsatisfactory'],
                'unsatisfactory_threshold' => $indicador['unsatisfactory_value'],
            ]);
        }
        $recipient=User::find($this->user);

        Notification::make()
            ->success()
            ->title('Tienes Indicadores registrados')
            ->body('Te han registrado nuevos indicadores. Puedes revisarlos en tu panel')
            ->sendToDatabase($recipient);

        Notification::make()
            ->success()
            ->title('Haz registrado un nuevo indicador')
            ->send();
    }
    public function deleteIndicator(int $id)
    {

        \Log::info('Contenido del array recibido:', $id);
        if (isset($id['id'])) {

            try {
                // Elimina el indicador de la base de datos, si existe

                    Indicator::find($id['id'])->delete();
                    IndicatorRange::where('indicator_id', $id['id'])->delete();

                // Elimina el indicador del estado del formulario
            } catch (\Exception $e) {
                Notification::make()
                    ->danger()
                    ->title('Error al eliminar el indicador')
                    ->body($e->getMessage())
                    ->send();
            }
            Notification::make()
                ->success()
                ->title('Indicador eliminado con éxito')
                ->send();
        }else{
            Notification::make()
                ->danger()
                ->title('No se encontró ID')
                ->send();
        }
    }

    public function getIndicatorProgressesForUser($userId)
    {

        $this->indicatorProgresses = Indicator::where('user_id', $userId)
        ->with('progresses')// Cargar progresos relacionados
        ->get(); // Devuelve los indicadores con progresos

        return $this->indicatorProgresses;
    }



}
