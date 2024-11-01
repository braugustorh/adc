<?php

namespace App\Filament\Pages;

use App\Models\Campaign;
use App\Models\User;
use Filament\Forms\Components\DatePicker;
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

class ControlPanel extends Page implements HasForms
{
    use InteractsWithForms;
    public ?array $data = [];

    protected static ?string $navigationIcon = 'heroicon-o-document-text';
    protected static ?string $navigationLabel = 'Panel';
    protected static ?string $navigationGroup = 'Panel de control';
    protected ?string $heading = 'Panel de Control';
    protected ?string $subheading = '';
    protected static ?int $navigationSort = 1;
    protected static string $view = 'filament.pages.control-panel';

    public $user;
    public $users;
    public $userToEvaluated;
    public $campaignId;
    public $show = false;
    public $month, $avance, $indicador_mes;



    protected function getForms(): array
    {
        return [
            'formIndicador',
            'formProgresses',
        ];
    }
    public function mount()
    {

        $this->campaignId = Campaign::whereStatus('Activa')->first()->id;
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
                    '2' => 'Cualitativo',
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
                Select::make('type_excellent')->label('Rango para excelente')->options([
                    '1' => 'Mayor que',
                    '2' => 'Menor que',
                    '3' => 'Igual a',
                    '4' => 'Mayor o igual que',
                    '5' => 'Menor o igual que',
                ])->required(),
                TextInput::make('excellent_value')->type('number')->label('Valor')->required(),
                Select::make('type_satisfactory')->label('Rango para Satisfactorio')->options([
                    '1' => 'Mayor que',
                    '2' => 'Menor que',
                    '3' => 'Igual a',
                    '4' => 'Mayor o igual que',
                    '5' => 'Menor o igual que',
                ])->required(),
                TextInput::make('satisfactory_value')->type('number')->label('Valor')->required(),
                Select::make('type_unsatisfactory')->label('Rango para Insatisfactorio')->options([
                    '1' => 'Mayor que',
                    '2' => 'Menor que',
                    '3' => 'Igual a',
                    '4' => 'Mayor o igual que',
                    '5' => 'Menor o igual que',
                ])->required(),
                TextInput::make('unsatisfactory_value')->type('number')->label('Valor')->required(),
                ])->columns(2)
            ])->columns(2)
                ->collapsed()
            ->itemLabel(fn($state):?String=> ($state['name'])??null)
        ])->statePath('data');
    }
    public function formProgresses(Form $form):Form
    {
        return $form->
        schema([
            Repeater::make('indicadores')
                ->schema([
                    Select::make('indicador_id')->label('Indicador')->options([
                        '1' => 'Indicador 1',
                        '2' => 'Indicador 2',
                        '3' => 'Indicador 3',
                        '4' => 'Indicador 4',
                    ])->searchable()->required()->placeholder('selecciona un indicador'),
                    DatePicker::make('month')->label('Mes')->format('m')->required(),
                    TextInput::make('progresse_value')->type('number')->label('Avance')->required(),

                ])->columns(3)
                ->collapsed()
                ->itemLabel(fn($state):?String=> ($state['name'])??null)
        ])->statePath('data');
    }

    public function updatedUser($value): void
    {
        // dd($this->user);
        $this->userToEvaluated = User::find($value);
        if ($this->userToEvaluated) {

            $this->show = true;

        } else {
            //Añadir error bags para mostrar mensaje de error
            $this->show = false;
        }


    }
    public function addValue()
    {
        $this->dispatch('open-modal', id: 'add-value');
    }

    public function save()
    {
        Notification::make()
            ->success()
            ->title('Haz registrado el avance del colaborador del mes de ' . $this->month)
            ->send();
    }
    public function closeModal()
    {
        $this->month = null;
        $this->avance = null;

        $this->dispatch('close-modal', id: 'add-value');

    }




}
