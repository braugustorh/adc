<?php

namespace App\Filament\Pages;

use App\Models\Campaign;
use App\Models\ClimateOrganizationalResponses;
use App\Models\Competence;
use App\Models\EvaluationsTypes;
use App\Models\Sede;
use App\Models\User;
use App\Models\Question;
use Filament\Actions\Exports\Models\Export;
use Filament\Pages\Page;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Tables\Contracts\HasTable;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Log;
use pxlrbt\FilamentExcel\Actions\Concerns\ExportableAction;
use pxlrbt\FilamentExcel\Actions\Tables\ExportBulkAction;

class OrganizationalClimateStatics extends Page implements HasTable
{
    use InteractsWithTable;
    protected static ?string $navigationIcon = 'heroicon-m-chart-pie';
    protected static ?string $navigationLabel = 'Análisis de Clima Organizacional';
    protected static ?string $navigationGroup = 'Clima Organizacional';
    protected ?string $heading = 'Análisis de Clima Organizacional';
    protected static ?int $navigationSort = 2;

    protected static string $view = 'filament.pages.organizational-climate-statics';

    public $sedes;
    public $sede_id;
    public $campaigns;
    public $campaign_id; // Corregido: era campaign_id en algunos lugares y campaign_id en otros
    public $chartData = [];
    public $users;
    public $respondentCount = 0;
    public $globalScore = 0;
    public $globalScorePercentage = 0;
    public $evaluation_id= null;
    public $campaignScores = [];
    public $sexChartData = [];

    public function mount(): void
    {
        $this->campaigns = Campaign::all();
        $this->evaluation_id = EvaluationsTypes::where('name', 'Clima Organizacional')->first()->id;

        if (auth()->user()->hasAnyRole(['RH Corp', 'Administrador','Visor'])) {
            $this->sedes = Sede::all();
        } elseif (auth()->user()->hasRole('Supervisor')) {
            $this->sedes = Sede::where('id', auth()->user()->sede_id)->get();
            $this->sede_id = auth()->user()->sede_id;
        }

        $this->loadChartData();
        $this->campaignScores = $this->getCampaignScores($this->sede_id);
        //$this->dispatch('line-chart-data-updated', chartData: $this->campaignScores);
        $this->sexChartData= $this->getScoresBySex();
        //$this->dispatch('sex-chart-data-updated', chartData: $this->getScoresBySex());

    }

    // Cambiado a updatedSedeId para que coincida con la propiedad
    public function updatedSedeId():void
    {

        $this->loadChartData();
        $this->resetTable();
        $this->campaignScores = $this->getCampaignScores($this->sede_id);
        $this->dispatch('line-chart-data-updated', chartData: $this->campaignScores);
       $this->dispatch('sex-chart-data-updated', chartData: $this->getScoresBySex());

    }

    // Cambiado a updatedCampaignId para que coincida con la propiedad
    public function updatedCampaignId():void    {

        // dd('Campaña actualizada:', $this->campaign_id); // Para depuración
        $this->loadChartData();
        $this->resetTable();
        $this->dispatch('sex-chart-data-updated', chartData: $this->getScoresBySex());

    }

    protected function loadChartData()
    {
        $query = ClimateOrganizationalResponses::query();


        $userQuery = User::where('status', true)
            ->whereNotNull('department_id')
            ->whereNotNull('position_id')
            ->whereNotNull('sede_id')
            ->whereDoesntHave('roles', function($q) {
                $q->where('name', 'Super Administrador');
            });

        if ($this->sede_id) {
            $query->whereHas('user', function($q) {
                $q->where('sede_id', $this->sede_id);
            });
            $userQuery->where('sede_id', $this->sede_id);
        }
        Log::info('entro a loadChartData');
        Log::info('Sede ID: ' . $this->sede_id); // Para depuración
        Log::info('Campaña ID: ' . $this->campaign_id); // Para depuración

        if ($this->campaign_id) {
            $query->where('campaign_id', $this->campaign_id);
            $campaign = Campaign::find($this->campaign_id);
            if ($campaign) {
                $userQuery->where('entry_date', '<', $campaign->end_date);
            }
        }

        // Ejecutar la consulta actualizada
        $this->users = $userQuery->get();
        $this->respondentCount = ClimateOrganizationalResponses::query()
            ->when($this->campaign_id, function($q) {
                $q->where('campaign_id', $this->campaign_id);
            })
            ->when($this->sede_id, function($q) {
                $q->whereHas('user', function($subq) {
                    $subq->where('sede_id', $this->sede_id);
                });
            })
            ->distinct('user_id')
            ->count('user_id');

        $climateModel = new ClimateOrganizationalResponses();
        $this->chartData = $climateModel->getCompetenceAverages($query->get(),$this->evaluation_id);
        // Calcular el score global basado en los mismos filtros
        $this->globalScore = ClimateOrganizationalResponses::getGlobalScore($query->get());
        // Calcular el porcentaje (asumiendo que la escala máxima es 5)
        $this->globalScorePercentage = round(($this->globalScore / 5) * 100, 1);
        // Emitir el evento para actualizar el gráfico
        $this->dispatch('chart-data-updated', chartData: $this->chartData);



    }
    public function table(Table $table): Table
    {
        return $table
            ->query(
                Question::query()
                    ->selectRaw('questions.id, questions.question, questions.competence_id, COALESCE(AVG(climate_organizational_responses.response), 0) as average')
                    ->leftJoin('climate_organizational_responses', 'questions.id', '=', 'climate_organizational_responses.question_id')
                    ->where('questions.status', 1)
                    ->where('questions.evaluations_type_id', $this->evaluation_id)
                    ->when($this->campaign_id, function (Builder $query) {
                        $query->where('climate_organizational_responses.campaign_id', $this->campaign_id);
                    })
                    ->when($this->sede_id, function (Builder $query) {
                        $query->leftJoin('users', 'climate_organizational_responses.user_id', '=', 'users.id')
                            ->where('users.sede_id', $this->sede_id);
                    })
                    ->groupBy('questions.id', 'questions.question', 'questions.competence_id')
                    ->orderBy('competence_id')
                    ->orderBy('id')
            )
            ->columns([
                TextColumn::make('id')
                    ->label('ID')
                    ->hidden()
                    ->sortable(),
                TextColumn::make('competence.name')
                    ->label('Competencia')
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->wrap()
                    ->sortable(),
                TextColumn::make('question')
                    ->label('Pregunta')
                    ->wrap()
                    ->searchable(),
                TextColumn::make('average')
                    ->label('Promedio')
                    ->formatStateUsing(fn ($state) => number_format($state, 2))
                    ->sortable(),
                TextColumn::make('average_percentage')
                    ->label('Porcentaje')
                    ->getStateUsing(fn ($record) => number_format(($record->average / 5) * 100, 1) . '%')
                    ->sortable(query: fn (Builder $query, string $direction) => $query->orderBy('average', $direction)),
            ])
            ->bulkActions([
              ExportBulkAction::make()
            ])
            ->filters([])
            ->searchable()
            ->striped();
    }
    protected function getCampaignScores($sede_id = null)
    {
        $campaigns = Campaign::orderBy('start_date')->get();
        $campaignScores = [];

        foreach ($campaigns as $campaign) {
            $query = ClimateOrganizationalResponses::query()
                ->where('campaign_id', $campaign->id);

            if ($sede_id) {
                $query->whereHas('user', function($q) use ($sede_id) {
                    $q->where('sede_id', $sede_id);
                });
            }

            $responses = $query->get();
            if ($responses->isNotEmpty()) {
                $score = ClimateOrganizationalResponses::getGlobalScore($responses);
                $campaignScores[] = [
                    'campaign' => $campaign->name,
                    'score' => $score,
                    'percentage' => round(($score / 5) * 100, 1)
                ];
            }
        }

        return $campaignScores;
    }

    protected function getScoresBySex()
    {
        $competencias = Competence::where('status', true)
            ->where('evaluations_type_id', $this->evaluation_id)
            ->get();

        $labels = $competencias->pluck('name')->toArray();
        $maleScores = [];
        $femaleScores = [];

        foreach ($competencias as $competencia) {
            // Promedio para hombres
            $maleAvg = ClimateOrganizationalResponses::query()
                ->join('users', 'climate_organizational_responses.user_id', '=', 'users.id')
                ->join('questions', 'climate_organizational_responses.question_id', '=', 'questions.id')
                ->where('questions.competence_id', $competencia->id)
                ->where('users.sex', 'Masculino')
                ->when($this->campaign_id, function ($query) {
                    $query->where('climate_organizational_responses.campaign_id', $this->campaign_id);
                })
                ->when($this->sede_id, function ($query) {
                    $query->where('users.sede_id', $this->sede_id);
                })
                ->avg('climate_organizational_responses.response') ?: 0;

            // Promedio para mujeres
            $femaleAvg = ClimateOrganizationalResponses::query()
                ->join('users', 'climate_organizational_responses.user_id', '=', 'users.id')
                ->join('questions', 'climate_organizational_responses.question_id', '=', 'questions.id')
                ->where('questions.competence_id', $competencia->id)
                ->where('users.sex', 'Femenino')
                ->when($this->campaign_id, function ($query) {
                    $query->where('climate_organizational_responses.campaign_id', $this->campaign_id);
                })
                ->when($this->sede_id, function ($query) {
                    $query->where('users.sede_id', $this->sede_id);
                })
                ->avg('climate_organizational_responses.response') ?: 0;

            $maleScores[] = round($maleAvg, 2);
            $femaleScores[] = round($femaleAvg, 2);
        }
        return [
            'labels' => $labels,
            'datasets' => [
                [
                    'label' => 'Hombres',
                    'data' => $maleScores,
                    'fill' => true,
                    'backgroundColor' => 'rgba(54, 162, 235, 0.2)',
                    'borderColor' => 'rgba(54, 162, 235, 1)',
                    'pointBackgroundColor' => 'rgba(54, 162, 235, 1)',
                    'pointBorderColor' => '#fff',
                    'pointBorderWidth' => 3,
                    'pointRadius' => 6,
                    'pointHoverBackgroundColor' => '#fff',
                    'pointHoverBorderColor' => 'rgba(54, 162, 235, 1)'
                ],
                [
                    'label' => 'Mujeres',
                    'data' => $femaleScores,
                    'fill' => true,
                    'backgroundColor' => 'rgba(255, 99, 132, 0.2)',
                    'borderColor' => 'rgba(255, 99, 132, 1)',
                    'pointBackgroundColor' => 'rgba(255, 99, 132, 1)',
                    'pointBorderColor' => '#fff',
                    'pointHoverBackgroundColor' => '#fff',
                    'pointHoverBorderColor' => 'rgba(255, 99, 132, 1)',
                    'pointBorderWidth' => 3,
                    'pointRadius' => 5,
                ]
            ]
        ];
    }


    public static function canView(): bool
    {
        return auth()->user()->hasAnyRole(['RH Corp','RH', 'Administrador','Visor']);
    }
    public static function shouldRegisterNavigation(): bool
    {
        // Esto controla la visibilidad en la navegación.
        return static::canView();
    }
}
