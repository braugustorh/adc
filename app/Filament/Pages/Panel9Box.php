<?php

namespace App\Filament\Pages;

use App\Models\Campaign;
use App\Models\Psychometry;
use Filament\Actions\Contracts\HasLivewire;
use Filament\Resources\Concerns\HasTabs;
use Filament\Tables\Grouping\Group;
use App\Models\Evaluation360Response;
use App\Models\EvaluationAssign;
use App\Models\Position;
use App\Models\User;
use Carbon\Carbon;
use Filament\Pages\Page;
use Filament\Tables\Table;
use Illuminate\Support\Facades\DB;
use Filament\Tables\Contracts\HasTable;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Concerns\InteractsWithTable;
class Panel9Box extends Page implements HasTable
{
    use InteractsWithTable;
    protected static ?string $navigationIcon = 'heroicon-o-document-text';
    protected static ?string $navigationLabel = ' Panel 9Box';
    protected static ?string $navigationGroup = 'Evaluaciones';
    protected ?string $heading = 'Panel 9 Box';
    protected ?string $subheading = 'Visualiza el análisis de los colaboradores';
        protected static ?int $navigationSort = 3;

    protected static string $view = 'filament.pages.panel9-box';
    public $members;
    public $campaigns;
    public $campaignId;
    public $totales;
    public $activeTab='tab1';
    public $quadrants = [];
    public $orderedIndexes = [4, 7, 9, 2, 5, 8, 1, 3, 6];
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
 public $colorBadgets=[
        9 => 'success',
        8 => 'success',
        7 => 'success',
        6 => 'warning',
        5 => 'warning',
        4 => 'warning',
        3 => 'info',
        2 => 'info',
        1 => 'danger',
        ];
    //protected static ?string $model = Evaluation360Response::class;
    public function mount(){
        $this->campaignId = Campaign::whereStatus('Activa')->first()->id;
        //$this->quadrants=collect();
       //$this->loadQuadrantData();
    }
    protected function getTableQuery()
    {
        return Evaluation360Response::select('evaluated_user_id', 'competence_id', DB::raw('AVG(response) as score'))
            ->where('campaign_id', $this->campaignId)
            ->groupBy('evaluated_user_id', 'competence_id');
    }
    protected function getTableColumns(): array
    {
        return [
            Tables\Columns\ImageColumn::make('evaluatedUsers.profile_photo')->rounded()->label(''),
            Tables\Columns\TextColumn::make('evaluatedUsers.name')->label('User'),
            Tables\Columns\TextColumn::make('competences.name')->label('Competencia'),
            // Tables\Columns\TextColumn::make('questions.question')->label('Pregunta'),
            Tables\Columns\TextColumn::make('score')->label('Score'),
        ];
    }
    public function getTableRecordKey($record): string
    {
        return $record->evaluated_user_id . '-' . $record->competence_id;
    }


    public function prepareQuadrantData():void
    {
        // Inicializar los cuadrantes
        for ($i = 1; $i <= 9; $i++) {
            $this->quadrants[$i] = [
                'collaborators' => [],
                'percentage' => 0,
            ];
        }
        // Obtener todos los colaboradores
        $collaborators = Evaluation360Response::select('evaluated_user_id')
            ->selectRaw('AVG(response) as total_360')
            ->where('campaign_id', $this->campaignId)
            ->groupBy('evaluated_user_id')
            ->get();

        $totalCollaborators = $collaborators->count();
        $potentials=Psychometry::select('user_id',DB::raw('
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
            ->groupBy('user_id')
            ->pluck('total_average','user_id');

        foreach ($collaborators as $collaborator) {

            $potentialScore = $potentials[$collaborator->evaluated_user_id] ?? null;
            // Determinar el cuadrante del colaborador
            $quadrant = $this->getQuadrantForCollaborator($collaborator,$potentialScore);

            // Agregar el colaborador al cuadrante correspondiente
            $this->quadrants[$quadrant]['collaborators'][] = $collaborator;
        }
        // Calcular el porcentaje de colaboradores en cada cuadrante
        for ($i = 1; $i <= 9; $i++) {
            $count = count($this->quadrants[$i]['collaborators']);
            $percentage = $totalCollaborators > 0 ? ($count / $totalCollaborators) * 100 : 0;
            $this->quadrants[$i]['percentage'] = number_format($percentage, 2);
        }

    }

    private function getQuadrantForCollaborator($collaborator,$potential)
    {
        // Supongamos que tienes los puntajes de desempeño y potencial
        /*
         * Aqui buscamos los puntajes de desempeño y potencial del colaborador
         * en la Psicometria y en la evaluación
         * el eje X será el desempeño y el eje Y será el potencial
         */
        // Obtener los puntajes de desempeño y potencial (valores de 0 a 5)

        $performanceScore = $collaborator->total_360;
        $potentialScore = $potential;

        // Mapear los puntajes a niveles (1: Bajo, 2: Medio, 3: Alto)
        $performanceLevel = $this->mapScoreToLevel($performanceScore);
        $potentialLevel = $this->mapScoreToLevel($potentialScore);

        // Calcular el cuadrante (1 a 9)
        $quadrant = ($performanceLevel - 1) * 3 + $potentialLevel;

        return $quadrant;
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
    public function changeTab($tab)
    {

        if ($tab === 'tab3') {
           $this->loadQuadrantData();
            $this->activeTab = $tab;

        } else {
            $this->quadrants = [];

            $this->activeTab = $tab;
        }
    }
    public function loadQuadrantData()
    {
        $this->prepareQuadrantData();
    }




}
