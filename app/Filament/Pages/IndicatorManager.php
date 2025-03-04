<?php

namespace App\Filament\Pages;

use App\Models\Campaign;
use App\Models\Indicator;
use App\Models\IndicatorProgress;
use App\Models\User;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Filament\Pages\Page;
use Filament\Support\Exceptions\Halt;

class IndicatorManager extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-document-text';
    protected static string $view = 'filament.pages.indicator-manager';
    protected static ?string $navigationLabel = 'Registro de Avance';
    protected static ?int $navigationSort = 2;
    protected static ?string $navigationGroup = 'Panel de Control';
    protected ?string $heading = 'Panel de Control';
    protected ?string $subheading = 'Captura de avance de indicadores';
    public $user;
    public $users;
    public $userToEvaluated;
    public $indicatorProgresses;
    public $data=[];
    //public $formIndicador;
    public $campaignId;
    public $show = false;
    public ?array $progresses = [
        'indicator_id' => null,
        'month' => null,
        'progresse_value' => null,
    ];

    protected function getForms(): array
    {
        return ['formProgresses'];
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
    public function updatedUser($value): void
    {
        // dd($this->user);
        $this->userToEvaluated = User::find($value);
        if ($this->userToEvaluated) {

            $this->show = true;

            $this->getIndicatorProgressesForUser($this->user);

        } else {
            //Añadir error bags para mostrar mensaje de error
            $this->show = false;
        }
    }
    public function getIndicatorProgressesForUser($userId)
    {

        $this->indicatorProgresses = Indicator::where('user_id', $userId)
            ->with('progresses')// Cargar progresos relacionados
            ->get(); // Devuelve los indicadores con progresos

        return $this->indicatorProgresses;
    }
    public function addValue()
    {
        $this->dispatch('open-modal', id: 'add-value');
    }
    public function closeModal()
    {
        //Agregar limpiar el modal
        $this->progresses = [
            'indicator_id' => null,
            'month' => null,
            'progresse_value' => null,
        ];
        $this->dispatch('close-modal', id: 'add-value');
    }
    public function formProgresses(Form $form):Form
    {
        $currentMonth = (int) date('n'); // 'n' devuelve el mes sin ceros iniciales (1-12)
        $previousMonth = $currentMonth - 1;

        // Si el mes anterior es 0 (enero), lo ajustamos a diciembre (12)
        if ($previousMonth < 1) {
            $previousMonth = 12;
        }

        // Crear un array con los meses permitidos
        $allowedMonths = [
            $previousMonth => $this->getMonthName($previousMonth),
            $currentMonth => $this->getMonthName($currentMonth),
        ];
        return $form->
        schema([
            Select::make('indicator_id')
                ->label('Indicador')
                ->options(function () {
                    return Indicator::where('user_id', $this->user)->pluck('name', 'id')->toArray();
                })
                ->preload()
                ->searchable()
                ->required()
                ->placeholder('Indicadores')
                ->statePath('progresses.indicator_id'),
            Select::make('month')
                ->label('Mes')
                ->options($allowedMonths)
                ->statePath('progresses.month')
                ->required(),
            TextInput::make('progresse_value')->type('number')->label('Avance')->required()
                ->statePath('progresses.progresse_value'),
        ])->columns(3);
    }
    protected function getMonthName(int $monthNumber): string
    {
        $months = [
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

        return $months[$monthNumber] ?? 'Mes inválido';
    }
    public function save()
    {
        // dd(now()->year);
        try{
            $newProgress = IndicatorProgress::create([
                'indicator_id' => $this->progresses['indicator_id'],
                'month' => $this->progresses['month'],
                'year' => now()->year,
                'progress_value' =>$this->progresses['progresse_value'],
            ]);
        }catch (Halt $e){
            return;
        }
        $monthName = $this->getMonthName($this->progresses['month']);

        $this->getIndicatorProgressesForUser($this->user);

        Notification::make()
            ->success()
            ->title('Haz registrado el avance del colaborador del mes de ' . $monthName)
            ->send();

        $this->closeModal();
    }




}
