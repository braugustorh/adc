<?php

namespace App\Filament\Pages;

use Filament\Forms;
use Filament\Forms\Components\Actions\Action;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Select;

use Filament\Forms\Components\Section;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Filament\Pages\Page;
use Filament\Support\Exceptions\Halt;
use App\Models\Campaign;
use App\Models\Evaluation360Response;
use App\Models\Psychometry;
use App\Models\User;

use Illuminate\Support\Facades\DB;


class OneToOne extends Page implements HasForms
{
    use InteractsWithForms;
    public ?array $data = [];
    protected static ?string $navigationIcon = 'heroicon-o-document-text';
    protected static ?string $navigationLabel = 'One to One';
    protected static ?string $navigationGroup = 'Evaluaciones';
    protected ?string $heading = 'Ficha de evaluación One to One';
    protected ?string $subheading = '';
    protected static ?int $navigationSort = 4;
    protected static string $view = 'filament.pages.one-to-one';

    public $user;
    public $users;
    public $show = false;
    public $userToEvaluated;
    public $evaluation360;
    public $campaignId;
    public $evaluationPotential;
    public $showEvaluation=false;
    public $themes;
    public $theme;
    public $date_ended;
    public $comments;
    public $quadrant;
    public $titles = [
        9 => 'Futuro Líder',
        8 => 'Estrella Emergente',
        7 => 'Líder Emergente',
        6 => 'Profesional Experimentado',
        5 => 'Futuro Prometedor',
        4 => 'Enigma',
        3 => 'Desempeño Solido',
        2 => 'Dilema',
        1 => 'Bajo Perfil',
    ];

    protected function getForms(): array
    {
        return [
            'formCultura',
            'formDesempeno',
            'formDesarrollo',
            'formAsuntos',
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
    public function formCultura(Form $form): Form
    {

        return $form
            ->schema([
                Repeater::make('Tema')
                    ->schema([
                        TextInput::make('theme')
                            ->label('Tema')
                            ->required(),
                        Textarea::make('comments')
                            ->label('Comentarios')
                            ->rows(3)
                            ->placeholder('Escribe los comentarios aquí...'),
                        DatePicker::make('date_ended')
                            ->label('Fecha programada')
                            ->required(),
                        TextInput::make('progress')
                            ->label('Avance')
                            ->type('number')
                            ->required(),
                    ])
                    ->label('Temas a tratar')
                    ->itemLabel(fn($state):?string => ($state['theme'])??null)
                    ->collapsed()
                    ->columns(2),
            ])->statePath('data');
    }
    public function formDesempeno(Form $form): Form
    {

        return $form
            ->schema([
                Repeater::make('evaluaciones')
                    ->schema([
                        Select::make('evaluation_type_id')
                            ->label('Evaluación')
                            ->options([
                                '1' => '360',
                                '2' => '9 box',
                                '3' => 'Psicometría',
                            ])
                            ->required(),
                        TextInput::make('qualify')
                            ->label('Ponderación')
                            ->type('number')
                            ->required(),
                        TextInput::make('qualify_translate')
                            ->label('Calificación')
                            ->required(),
                        Textarea::make('comments')
                            ->label('Comentarios')
                            ->placeholder('Ingresa los Commentarios - Acuerdos y Compromisos')
                            ->required(),
                        DatePicker::make('date_ended')
                            ->label('Fecha programada')
                            ->required(),
                        TextInput::make('progress')
                            ->label('Avance')
                            ->type('number')
                            ->required(),
                    ])
                    ->label('Evaluaciones')
                    ->itemLabel(fn($state): ?string => match($state['evaluation_type_id']) {
                        '1' => 'Evaluación 360',
                        '2' => '9 box',
                        '3' => 'Psicometría',
                        default => '',
                    })
                    ->columns(2)
                    ->collapsed(),
                Repeater::make('indicadores')
                    ->schema([
                       Select::make('indicator')
                            ->label('Indicador')
                            ->options([
                                '1' => 'Indicador 1',
                                '2' => 'Indicador 2',
                                '3' => 'Indicador 3',
                                '4' => 'Indicador 4',
                                '5' => 'Indicador 5',
                            ])
                            ->required(),
                        TextInput::make('qualify')
                            ->label('Ponderación')
                            ->type('number')
                            ->required(),
                        TextInput::make('qualify_translate')
                            ->label('Calificación')
                            ->required(),
                        Textarea::make('comments')
                            ->label('Comentarios')
                            ->placeholder('Describa los Commentarios - Acuerdos y Compromisos')
                            ->required(),
                        DatePicker::make('date_ended')
                            ->label('Fecha programada')
                            ->required(),
                        TextInput::make('progress')
                            ->label('Avance')
                            ->type('number')
                            ->required(),
                    ])
                    ->itemLabel(fn($state): ?string => match($state['indicator']) {
                        '1' => 'Indicador 1',
                        '2' => 'Indicador 2',
                        '3' => 'Indicador 3',
                        '4' => 'Indicador 4',
                        '5' => 'Indicador 5',
                        default => '',
                    })
                    ->columns(2)
                    ->collapsed()
            ])->statePath('data');
              // Guarda los datos en dataDos

    }
    public function formDesarrollo(Form $form): Form
    {

        return $form
            ->schema([
                Repeater::make('fortalezas_detectadas')
                    ->schema([
                        Textarea::make('fortaleza')
                            ->label('Fortalezas Autodetectadas')
                            ->required(),
                    ])->maxItems(1)
                ->itemLabel('Fortalezas Autodetectadas')
                ->collapsed(),
                Repeater::make('áreas_de_oportunidad')
                ->schema([
                    Textarea::make('oportunidad')
                        ->label('Áreas de Oportunidad Autodetctadas')
                        ->required(),
                ])->maxItems(1)
                    ->itemLabel('Áreas de Oportunidad Autodetectadas')
                    ->collapsed(),
                Repeater::make('plan')
                ->schema([
                    TextInput::make('area')
                    ->required()
                        ->label('Área de Desarrollo')
                        ->placeholder('Escribe el área de desarrollo'),
                    TextInput::make('avance')
                    ->required()
                        ->label('Avance')
                        ->type('number'),
                    DatePicker::make('date_ended')
                    ->required()
                        ->label('Fecha programada'),
                ])->itemLabel('Área de Desarrollo')
                    ->columns(2)
                    ->collapsed()
            ])->statePath('data');


     }
    public function formAsuntos(Form $form): Form
    {

        return $form
            ->schema([
                Repeater::make('other_topics')
                    ->schema([
                        Select::make('who_says')
                            ->label('Por parte de:')
                            ->options([
                                '1' => 'Colaborador',
                                '2' => 'Supervisor',
                                '3' => 'Ambos',
                            ])
                            ->required(),
                        TextInput::make('topic')
                            ->label('Asunto')
                            ->required(),
                        Textarea::make('comments')
                            ->label('Comentarios')
                            ->placeholder('Describa los Commentarios - Acuerdo y Compromiso')
                            ->required(),
                        DatePicker::make('date_ended')
                            ->label('Fecha programada')
                            ->required(),
                        TextInput::make('progress')
                            ->label('Avance')
                            ->type('number')
                            ->required(),
                    ])->label('Asuntos Varios')
                    ->columns(2)
                    ->collapsed()
            ])->statePath('data');

     }



    public function updatedUser($value): void
    {
        // dd($this->user);
        $this->userToEvaluated = User::find($value);
        $this->evaluation360 = round($this->getAverage360($this->userToEvaluated->id, $this->campaignId),2);
        $this->evaluationPotential = round($this->getAveragePotential($this->userToEvaluated->id),2);
        // Mapear los puntajes a niveles (1: Bajo, 2: Medio, 3: Alto)
        $performanceLevel = $this->mapScoreToLevel($this->evaluation360);
        $potentialLevel = $this->mapScoreToLevel($this->evaluationPotential);

        // Calcular el cuadrante (1 a 9)
        $this->quadrant = ($performanceLevel - 1) * 3 + $potentialLevel;
        $this->themes=collect();
        $this->show = true;

    }
    public function getAverage360($user_id, $campaign_id)
    {
        return Evaluation360Response::where('campaign_id', $campaign_id)
            ->where('evaluated_user_id', $user_id)
            ->avg('response');
    }
    public function getAveragePotential($user_id)
    {
        return Psychometry::select('user_id',DB::raw('
            (SUM(leadership) +
            SUM(communication) +
            SUM(conflict_management) +
            SUM(negotiation) +
            SUM(organization) +
            SUM(problem_analysis) +
            SUM(decision_making) +
            SUM(strategic_thinking) +
            SUM(resilience) +
            SUM(focus_on_results) +
            SUM(teamwork) +
            SUM(willingness_service)) /
            (COUNT(leadership) +
            COUNT(communication) +
            COUNT(conflict_management) +
            COUNT(negotiation) +
            COUNT(organization) +
            COUNT(problem_analysis) +
            COUNT(decision_making) +
            COUNT(strategic_thinking) +
            COUNT(resilience) +
            COUNT(focus_on_results) +
            COUNT(teamwork) +
            COUNT(willingness_service))
            as total_average
        '))
            ->where('user_id', $user_id)
            ->groupBy('user_id')
            ->pluck('total_average','user_id')
            ->first();
    }

    public function addTheme()
    {
        $this->dispatch('open-modal', id: 'add-theme-modal');

    }
    public function saveTheme()
    {
        $this->themes->push($this->theme);
        $this->theme = '';
        $this->dispatch('close-modal','add-theme-modal');
    }
    public function createOneToOneEvaluation()
    {
        //Rutina para crear la evaluación si es primera evalaución
        //Rutina para actualizar la evaluación si ya existe
        Notification::make()
            ->success()
            ->title('Se ha creado la Evaluación One to One')
            ->send();
        $this->show=false;
        $this->showEvaluation=true;

    }
    private function mapScoreToLevel($score)
    {
        if ($score >= 4.0 && $score <= 5.0) {
            return 3; // Alto
        } elseif ($score >= 3.0 && $score <= 3.9) {
            return 2; // Medio
        } else {
            return 1; // Bajo
        }
    }

}
