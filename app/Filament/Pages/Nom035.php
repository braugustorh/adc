<?php

namespace App\Filament\Pages;

use App\Models\ActiveSurvey;
use App\Models\Evaluation;
use App\Models\EvaluationsTypes;
use App\Models\IdentifiedCollaborator;
use App\Models\Nom035Process;
use App\Models\RiskFactorSurvey;
use App\Models\RiskFactorSurveyOrganizational;
use App\Models\TraumaticEvent;
use App\Models\TraumaticEventSurvey;
use App\Models\User;
use Barryvdh\DomPDF\PDF;
use Filament\Notifications\Notification;
use Filament\Pages\Page;
use Illuminate\Events\Dispatcher;
use PhpOffice\PhpWord\TemplateProcessor;
use PhpOffice\PhpWord\Writer\PDF\DomPDF;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Response;
use PhpOffice\PhpPresentation\IOFactory;
use PhpOffice\PhpPresentation\PhpPresentation;


class Nom035 extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-document-text';
    protected static ?string $title= '';
    protected static ?string $navigationGroup = 'NOM-035';
    protected static ?string $navigationLabel= 'Panel de Control';
    protected static string $view = 'filament.pages.nom35';
    protected static ?int $navigationSort = 1;

    // Propiedades existentes
    public $stage = 'welcome';
    public $colabs;
    public $muestra;
    // Propiedades para el modal de identificación
    public $selectedCollaborator = null;
    public $identifiedColaborators = [];
    public $colaborators;
    public $availableColaborators;
    // Propiedades para el modal de identificación
    public $selectedEventType = null;
    public $eventDescription = '';
    public $eventDate = null;
    public $colabResponsesG1 = 0;
    public $colabResponsesG2 = 0;
    public $colabResponsesG3 = 0;
    public $norma;
    public $calificacion;
    public $resultCuestionario;
    public Int $level = 0; //Nivel de encuesta depende de la cantidad de colaboradores
    public $activeGuideI = false, $activeGuideII = false, $activeGuideIII = false;
    public $eventTypesByCategory;
    public $muestraGuideIII = 0;
    public $responsesTotalG2;
    public $generalResults = [];
    public $generalResultsCategory = [];
    public $domainResults = [];
    public $generalResultsGuideIII = [];
    public $resultCuestionarioG3;
    public $calificacionG3;
    public $totalResponsesG3 = 0;
    public $generalResultsGuideIIICategory=[];
    public $generalDomainResultsGuideIII= [];
    public $fechaInicioG2, $fechaFinG2;
    //Variables cover para categorias
    public $coverAmbientResponses, $coverLeadershipResponses, $coverActivityResponses, $coverTimeResponses;
    //Variables cover para dominio
    public $coverWorkActivityResponses, $coverWorkControlResponses, $coverConditionResponses,
        $coverWorkJourneyResponses, $coverWordAndFamilyResponses, $coverWorkRelationsResponses,
        $coverViolenceResponses,$coverDomainLeadershipResponses;



    public $categories=[
      'Ambiente de trabajo'=> [2,1,3],
      'Factores propios de la actividad ' =>[4,9,5,6,7,8,41,42,43,10,11,12,13,20,21,22,18,19,26,27],

    ];



    public static function canView(): bool
    {
        return \auth()->user()->hasAnyRole(['Administrador','RH Corp','RH']);

    }
    public static function shouldRegisterNavigation(): bool
    {
        // Esto controla la visibilidad en la navegación.
        return static::canView();

    }
    // Inicializar datos
    public function mount()
    {
        $this->norma=Nom035Process::findActiveProcess(auth()->user()->sede_id);
        // Cargar colaboradores de la sede actual
        if($this->norma !== null){
            // Si ya existe un proceso activo, redirigir al panel
            $activeSurvey = ActiveSurvey::where('norma_id', $this->norma->id)->get();
/*
            $guideTypes = EvaluationsTypes::where('name', 'like', 'Nom035: Guía %')
                ->pluck('id', 'name');



            $this->activeGuideI = $activeSurvey->contains('evaluations_type_id', $guideTypes['Nom035: Guía I'] ?? 0);
            $this->activeGuideII = $activeSurvey->contains('evaluations_type_id', $guideTypes['Nom035: Guía II'] ?? 0);
            $this->activeGuideIII = $activeSurvey->contains('evaluations_type_id', $guideTypes['Nom035: Guía III'] ?? 0);
           */
            $this->colabResponsesG1= TraumaticEventSurvey::where('norma_id', $this->norma->id)
                ->where('sede_id', $this->norma->sede_id)
                ->distinct('user_id')
                ->count();
            // Debug: verificar qué registros existen
            $guideTypes = EvaluationsTypes::where('name', 'like', 'Nom035: Guía %')
                ->pluck('id', 'name');

            // Temporal: ver qué claves tienes disponibles
            \Log::info('Available guide types:', $guideTypes->toArray());

            // Usar get() en lugar de acceso directo al array
            $guideIId = EvaluationsTypes::where('name', 'Nom035: Guía I')->first()?->id;
            $guideIIId = EvaluationsTypes::where('name', 'Nom035: Guía II')->first()?->id;
            $guideIIIId = EvaluationsTypes::where('name', 'Nom035: Guía III')->first()?->id;

            $this->activeGuideI = $activeSurvey->contains('evaluations_type_id', $guideIId);
            $this->activeGuideII = $activeSurvey->contains('evaluations_type_id', $guideIIId);
            $this->activeGuideIII = $activeSurvey->contains('evaluations_type_id', $guideIIIId);


            $this->stage = 'panel';
            $queryResG2=RiskFactorSurvey::where('norma_id', $this->norma->id)
                        ->where('sede_id', $this->norma->sede_id);
            $calificacion=$queryResG2->sum('equivalence_response');
            $this->responsesTotalG2=$queryResG2->distinct('user_id')->count('user_id');
            $this->calificacion = $this->responsesTotalG2 > 0 ? $calificacion / $this->responsesTotalG2 : 0;

            $this->loadIdentifiedEvents();
        }else{
            $this->norma=collect();
        }

        $this->colabs =User::where('sede_id', auth()->user()->sede_id ?? null)
            ->where('status', true)
            ->get();
        $this->colaborators = $this->colabs;
        $this->availableColaborators = $this->colaborators;

        // Calcular muestra según el número de colaboradores
        if ($this->colabs->count() >= 51) {
            $this->muestra = $this->calculateSampleSize($this->colabs->count());
            $this->level=3;
        }else if ($this->colabs->count()>=16 && $this->colabs->count()<=50) {
            $this->muestra =$this->colabs->count();
            $this->level=2;
        } else {
            $this->muestra = $this->colabs->count();
            $this->level=1;
        }

        $this->selectedCollaborator = null;
        $this->selectedEventType = null;
        $this->eventDate = now()->format('Y-m-d');
        $this->eventTypesByCategory = \App\Enums\TraumaticEventType::getByCategory();



    }

    // Metodo para crear registro (existente)
    public function createRecord()
    {
        // Simular carga
        $saveProcess= new Nom035Process();
        $saveProcess->sede_id = auth()->user()->sede_id;
        $saveProcess->hr_manager_id = auth()->id();
        $saveProcess->start_date = now();
        $saveProcess->status = 'iniciado';
        $saveProcess->total_employees = $this->colabs->count();
        $saveProcess->survey_applicable = $this->colabs->count()>=16;
        $saveProcess->save();
        $this->norma = $saveProcess;
        // Notificación de éxito
        Notification::make()
            ->title('Proceso NOM-035 iniciado')
            ->body('El proceso ha sido creado exitosamente.')
            ->success()
            ->send();
        $this->stage = 'panel';
    }

    // Metodo para abrir el modal de identificación
    public function openIdentificationModal()
    {
        $this->resetIdentificationModal();
        $this->dispatch('open-modal', id: 'identify-modal');
    }

    // Metodo para cerrar el modal de identificación
    public function closeIdentificationModal()
    {
        $this->dispatch('close-modal', id: 'identify-modal');
        $this->resetIdentificationModal();
    }

    public function openModalResults()
    {
        if($this->calificacion>=90){
            $this->resultCuestionario='Muy Alto';
        }elseif ($this->calificacion>=70 && $this->calificacion<90 ) {
            $this->resultCuestionario='Alto';
        }elseif ($this->calificacion>=45 && $this->calificacion<70) {
            $this->resultCuestionario='Medio';
        }elseif ($this->calificacion>=20 && $this->calificacion<45) {
            $this->resultCuestionario='Bajo';
        }elseif ($this->calificacion<20) {
            $this->resultCuestionario='Despreciable';
        }


        $responses = RiskFactorSurvey::where('norma_id', $this->norma->id)
            ->where('sede_id', auth()->user()->sede_id)
            ->get()
            ->groupBy('user_id')
            ->map(function ($items) {
                return $items->sum('equivalence_response');
            });

        //Asigna el rango del resultado
        $this->generalResults = [
            'total' => $responses->count(),
            'null' => $responses->filter(fn($value) => $value < 20)->count(),
            'low' => $responses->filter(fn($value) => $value >= 20 && $value < 45)->count(),
            'medium' => $responses->filter(fn($value) => $value >= 45 && $value < 70)->count(),
            'high' => $responses->filter(fn($value) => $value >= 70 && $value < 90)->count(),
            'very_high' => $responses->filter(fn($value) => $value >= 90)->count(),
        ];
        /*
         * Asignación de los resultados generales por categoría
         */

        $ambientResponses = RiskFactorSurvey::where('norma_id', $this->norma->id)
            ->where('sede_id', auth()->user()->sede_id)
            ->whereHas('question', function($q) {
                $q->whereIn('order', [1, 2, 3]);
            })
            ->get()
            ->groupBy('user_id')
            ->map(function ($items) {
                return $items->sum('equivalence_response');
            });
        $this->coverAmbientResponses = $ambientResponses;
        $activityResponses = RiskFactorSurvey::where('norma_id', $this->norma->id)
            ->where('sede_id', auth()->user()->sede_id)
            ->whereHas('question', function($q) {
                $q->whereIn('order', [4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 18, 19,20,21,22,26,27,42,43,44]);
            })
            ->get()
            ->groupBy('user_id')
            ->map(function ($items) {
                return $items->sum('equivalence_response');
            });
        $this->coverActivityResponses = $activityResponses;
        $timeResponses = RiskFactorSurvey::where('norma_id', $this->norma->id)
            ->where('sede_id', auth()->user()->sede_id)
            ->whereHas('question', function($q) {
                $q->whereIn('order', [14,15,16,17]);
            })
            ->get()
            ->groupBy('user_id')
            ->map(function ($items) {
                return $items->sum('equivalence_response');
            });
        $this->coverTimeResponses = $timeResponses;
        $leadershipResponses = RiskFactorSurvey::where('norma_id', $this->norma->id)
            ->where('sede_id', auth()->user()->sede_id)
            ->whereHas('question', function($q) {
                $q->whereIn('order', [23,24,25,28,29,30,31,32,33,34,35,36,37,38,39,40,46,47,48]);
            })
            ->get()
            ->groupBy('user_id')
            ->map(function ($items) {
                return $items->sum('equivalence_response');
            });
        $this->coverLeadershipResponses = $leadershipResponses;
        //Se revisó la asignación de los resultados vs  excel; y salio bien la asignación
        $this->generalResultsCategory=[
            'ambiente'=>[
                'nombre' => 'Ambiente de trabajo',
                'total' => $ambientResponses->count(),
                'null' => $ambientResponses->filter(fn($value) => $value < 3)->count(),
                'low' => $ambientResponses->filter(fn($value) => $value >= 3 && $value < 5)->count(),
                'medium' => $ambientResponses->filter(fn($value) => $value >= 5 && $value < 7)->count(),
                'high' => $ambientResponses->filter(fn($value) => $value >= 7 && $value < 9)->count(),
                'very_high' => $ambientResponses->filter(fn($value) => $value >= 9)->count(),
            ],
            'actividad'=>[
                'nombre' => 'Factores propios de la actividad',
                'total' => $activityResponses->count(),
                'null' => $activityResponses->filter(fn($value) => $value < 10)->count(),
                'low' => $activityResponses->filter(fn($value) => $value >= 10 && $value < 20)->count(),
                'medium' => $activityResponses->filter(fn($value) => $value >= 20 && $value < 30)->count(),
                'high' => $activityResponses->filter(fn($value) => $value >= 30 && $value < 40)->count(),
                'very_high' => $activityResponses->filter(fn($value) => $value >= 40)->count(),
            ],
            'tiempo'=>[
                'nombre' => 'Organización del tiempo de trabajo',
                'total' => $timeResponses->count(),
                'null' => $timeResponses->filter(fn($value) => $value < 4)->count(),
                'low' => $timeResponses->filter(fn($value) => $value >= 4 && $value < 6)->count(),
                'medium' => $timeResponses->filter(fn($value) => $value >= 6 && $value < 9)->count(),
                'high' => $timeResponses->filter(fn($value) => $value >= 9 && $value < 12)->count(),
                'very_high' => $timeResponses->filter(fn($value) => $value >= 12)->count(),
            ],
            'liderazgo'=>[
                'nombre' => 'Liderazgo y relaciones en el trabajo',
                'total' => $leadershipResponses->count(),
                'null' => $leadershipResponses->filter(fn($value) => $value < 10)->count(),
                'low' => $leadershipResponses->filter(fn($value) => $value >= 10 && $value < 18)->count(),
                'medium' => $leadershipResponses->filter(fn($value) => $value >= 18 && $value < 28)->count(),
                'high' => $leadershipResponses->filter(fn($value) => $value >= 28 && $value < 38)->count(),
                'very_high' => $leadershipResponses->filter(fn($value) => $value >= 38)->count(),
            ]
        ];
        /*
         ******** SECCIÓN DE DOMINIO
         */
        $conditionResponses = RiskFactorSurvey::where('norma_id', $this->norma->id)
            ->where('sede_id', auth()->user()->sede_id)
            ->whereHas('question', function($q) {
                $q->whereIn('order', [1, 2, 3]);
            })
            ->get()
            ->groupBy('user_id')
            ->map(function ($items) {
                return $items->sum('equivalence_response');
            });
        $this->coverConditionResponses = $conditionResponses;
        $workActivityResponses = RiskFactorSurvey::where('norma_id', $this->norma->id)
            ->where('sede_id', auth()->user()->sede_id)
            ->whereHas('question', function($q) {
                $q->whereIn('order', [4, 5, 6, 7, 8, 9, 10, 11, 12, 13,42,43,44]);
            })
            ->get()
            ->groupBy('user_id')
            ->map(function ($items) {
                return $items->sum('equivalence_response');
            });
        $this->coverWorkActivityResponses = $workActivityResponses;
        $workControlResponses = RiskFactorSurvey::where('norma_id', $this->norma->id)
            ->where('sede_id', auth()->user()->sede_id)
            ->whereHas('question', function($q) {
                $q->whereIn('order', [20,21,22,18,19,26,27]);
            })
            ->get()
            ->groupBy('user_id')
            ->map(function ($items) {
                return $items->sum('equivalence_response');
            });
        $this->coverWorkControlResponses = $workControlResponses;

        $workJourneyResponses = RiskFactorSurvey::where('norma_id', $this->norma->id)
            ->where('sede_id', auth()->user()->sede_id)
            ->whereHas('question', function($q) {
                $q->whereIn('order', [14,15]);
            })
            ->get()
            ->groupBy('user_id')
            ->map(function ($items) {
                return $items->sum('equivalence_response');
            });
        $this->coverWorkJourneyResponses = $workJourneyResponses;

        $wordAndFamilyResponses = RiskFactorSurvey::where('norma_id', $this->norma->id)
            ->where('sede_id', auth()->user()->sede_id)
            ->whereHas('question', function($q) {
                $q->whereIn('order', [16,17]);
            })
            ->get()
            ->groupBy('user_id')
            ->map(function ($items) {
                return $items->sum('equivalence_response');
            });
        $this->coverWordAndFamilyResponses = $wordAndFamilyResponses;
        $leadershipResponses= RiskFactorSurvey::where('norma_id', $this->norma->id)
            ->where('sede_id', auth()->user()->sede_id)
            ->whereHas('question', function($q) {
                $q->whereIn('order', [23,24,25,28,29]);
            })
            ->get()
            ->groupBy('user_id')
            ->map(function ($items) {
                return $items->sum('equivalence_response');
            });
        $this->coverDomainLeadershipResponses = $leadershipResponses;
        $workRelationsResponses = RiskFactorSurvey::where('norma_id', $this->norma->id)
            ->where('sede_id', auth()->user()->sede_id)
            ->whereHas('question', function($q) {
                $q->whereIn('order', [30,31,32,46,47,48]);
            })
            ->get()
            ->groupBy('user_id')
            ->map(function ($items) {
                return $items->sum('equivalence_response');
            });
        $this->coverWorkRelationsResponses = $workRelationsResponses;
        $violenceResponses = RiskFactorSurvey::where('norma_id', $this->norma->id)
            ->where('sede_id', auth()->user()->sede_id)
            ->whereHas('question', function($q) {
                $q->whereIn('order', [33,34,35,36,37,38,39,40]);
            })
            ->get()
            ->groupBy('user_id')
            ->map(function ($items) {
                return $items->sum('equivalence_response');
            });
        $this->coverViolenceResponses = $violenceResponses;
        // Asignar los resultados de dominio en un array
        $this->domainResults=[
            'conditions'=>[
                'nombre' => 'Condiciones del entorno de trabajo',
                'total' => $conditionResponses->count(),
                'null' => $conditionResponses->filter(fn($value) => $value < 3)->count(),
                'low' => $conditionResponses->filter(fn($value) => $value >= 3 && $value < 5)->count(),
                'medium' => $conditionResponses->filter(fn($value) => $value >= 5 && $value < 7)->count(),
                'high' => $conditionResponses->filter(fn($value) => $value >= 7 && $value < 9)->count(),
                'very_high' => $conditionResponses->filter(fn($value) => $value >= 9)->count(),
            ],
            'work_activity'=>[
                'nombre' => 'Carga de Trabajo',
                'total' => $workActivityResponses->count(),
                'null' => $workActivityResponses->filter(fn($value) => $value < 12)->count(),
                'low' => $workActivityResponses->filter(fn($value) => $value >= 12 && $value < 16)->count(),
                'medium' => $workActivityResponses->filter(fn($value) => $value >= 16 && $value < 20)->count(),
                'high' => $workActivityResponses->filter(fn($value) => $value >= 20 && $value < 24)->count(),
                'very_high' => $workActivityResponses->filter(fn($value) => $value >= 24)->count(),
            ],
            'work_control'=>[
                'nombre' => 'Control del trabajo',
                'total' => $workControlResponses->count(),
                'null' => $workControlResponses->filter(fn($value) => $value < 5)->count(),
                'low' => $workControlResponses->filter(fn($value) => $value >= 5 && $value < 8)->count(),
                'medium' => $workControlResponses->filter(fn($value) => $value >= 8 && $value < 11)->count(),
                'high' => $workControlResponses->filter(fn($value) => $value >= 11 && $value < 14)->count(),
                'very_high' => $workControlResponses->filter(fn($value) => $value >= 14)->count(),
            ],
            'work_journey'=>[
                'nombre' => 'Organización del tiempo de trabajo',
                'total' => $workJourneyResponses->count(),
                'null' => $workJourneyResponses->filter(fn($value) => $value < 1)->count(),
                'low' => $workJourneyResponses->filter(fn($value) => $value >= 1 && $value < 2)->count(),
                'medium' => $workJourneyResponses->filter(fn($value) => $value >= 2 && $value < 4)->count(),
                'high' => $workJourneyResponses->filter(fn($value) => $value >= 4 && $value < 6)->count(),
                'very_high' => $workJourneyResponses->filter(fn($value) => $value >= 6)->count(),
            ],
            'work_family'=>[
                'nombre' => 'Interferencia trabajo-familia',
                'total' => $wordAndFamilyResponses->count(),
                'null' => $wordAndFamilyResponses->filter(fn($value) => $value < 1)->count(),
                'low' => $wordAndFamilyResponses->filter(fn($value) => $value >= 1 && $value < 2)->count(),
                'medium' => $wordAndFamilyResponses->filter(fn($value) => $value >= 2 && $value < 4)->count(),
                'high' => $wordAndFamilyResponses->filter(fn($value) => $value >= 4 && $value < 6)->count(),
                'very_high' => $wordAndFamilyResponses->filter(fn($value) => $value >= 6)->count(),
            ],
            'leadership'=>[
                'nombre' => 'Liderazgo y relaciones en el trabajo',
                'total' => $leadershipResponses->count(),
                'null' => $leadershipResponses->filter(fn($value) => $value < 3)->count(),
                'low' => $leadershipResponses->filter(fn($value) => $value >= 3 && $value < 5)->count(),
                'medium' => $leadershipResponses->filter(fn($value) => $value >= 5 && $value < 8)->count(),
                'high' => $leadershipResponses->filter(fn($value) => $value >= 8 && $value < 11)->count(),
                'very_high' => $leadershipResponses->filter(fn($value) => $value >= 11)->count(),
            ],
            'work_relations'=>[
                'nombre' => 'Relaciones en el trabajo',
                'total' => $workRelationsResponses->count(),
                'null' => $workRelationsResponses->filter(fn($value) => $value < 5)->count(),
                'low' => $workRelationsResponses->filter(fn($value) => $value >= 5 && $value < 8)->count(),
                'medium' => $workRelationsResponses->filter(fn($value) => $value >= 8 && $value < 11)->count(),
                'high' => $workRelationsResponses->filter(fn($value) => $value >= 11 && $value < 14)->count(),
                'very_high' => $workRelationsResponses->filter(fn($value) => $value >= 14)->count(),
            ],
            'violence'=>[
                'nombre' => 'Violencia en el trabajo',
                'total' => $violenceResponses->count(),
                'null' => $violenceResponses->filter(fn($value) => $value < 7)->count(),
                'low' => $violenceResponses->filter(fn($value) => $value >= 7 && $value < 10)->count(),
                'medium' => $violenceResponses->filter(fn($value) => $value >= 10 && $value < 13)->count(),
                'high' => $violenceResponses->filter(fn($value) => $value >= 13 && $value < 16)->count(),
                'very_high' => $violenceResponses->filter(fn($value) => $value >= 16)->count(),
            ]
        ];


        // Ahora calculamos los resultados generales por categoría
        /*
        $this->generalResultsCategory['ambiente'] = RiskFactorSurvey::where('norma_id', $this->norma->id)
            ->where('sede_id', auth()->user()->sede_id)
            ->whereHas('question', function($q) {
                $q->whereIn('order', [1, 2, 3]);
            })
            ->sum('equivalence_response');
        $this->generalResultsCategory['actividad'] = RiskFactorSurvey::where('norma_id', $this->norma->id)
            ->where('sede_id', auth()->user()->sede_id)
            ->whereHas('question', function($q) {
                $q->whereIn('order', [4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 18, 19,20,21,22,26,27,42,43,44]);
            })
            ->sum('equivalence_response');
        $this->generalResultsCategory['tiempo'] = RiskFactorSurvey::where('norma_id', $this->norma->id)
            ->where('sede_id', auth()->user()->sede_id)
            ->whereHas('question', function($q) {
                $q->whereIn('order', [14,15,16,17]);
            })
            ->sum('equivalence_response');
        $this->generalResultsCategory['liderazgo'] = RiskFactorSurvey::where('norma_id', $this->norma->id)
            ->where('sede_id', auth()->user()->sede_id)
            ->whereHas('question', function($q) {
                $q->whereIn('order', [23,24,25,28,29,30,31,32,33,34,35,36,37,38,39,40,46,47,48]);
            })
            ->sum('equivalence_response');

        //ahora se asigna el valor de acuerdo al resultado si es menor de 10 es nulo, de 10 a 20 es bajo, de 21 a 45 es medio, de 46 a 70 es alto y mayor a 70 es muy alto
        $this->generalResultsCategory['ambiente_level'] = match (true) {
            $this->generalResults['ambiente'] <= 10 => 'Nulo',
            $this->generalResults['ambiente'] > 10 && $this->generalResults['ambiente'] <= 20 => 'Bajo',
            $this->generalResults['ambiente'] > 20 && $this->generalResults['ambiente'] <= 45 => 'Medio',
            $this->generalResults['ambiente'] > 45 && $this->generalResults['ambiente'] <= 70 => 'Alto',
            $this->generalResults['ambiente'] > 70 => 'Muy Alto',
            default => 'N/A',
        };
        $this->generalResultsCategory['actividad_level'] = match (true) {
            $this->generalResults['actividad'] <= 10 => 'Nulo',
            $this->generalResults['actividad'] > 10 && $this->generalResults['actividad'] <= 20 => 'Bajo',
            $this->generalResults['actividad'] > 20 && $this->generalResults['actividad'] <= 45 => 'Medio',
            $this->generalResults['actividad'] > 45 && $this->generalResults['actividad'] <= 70 => 'Alto',
            $this->generalResults['actividad'] > 70 => 'Muy Alto',
            default => 'N/A',
        };
        $this->generalResultsCategory['tiempo_level'] = match (true) {
            $this->generalResults['tiempo'] <= 10 => 'Nulo',
            $this->generalResults['tiempo'] > 10 && $this->generalResults['tiempo'] <= 20 => 'Bajo',
            $this->generalResults['tiempo'] > 20 && $this->generalResults['tiempo'] <= 45 => 'Medio',
            $this->generalResults['tiempo'] > 45 && $this->generalResults['tiempo'] <= 70 => 'Alto',
            $this->generalResults['tiempo'] > 70 => 'Muy Alto',
            default => 'N/A',
        };
        $this->generalResultsCategory['liderazgo_level'] = match (true) {
            $this->generalResults['liderazgo'] <= 10 => 'Nulo',
            $this->generalResults['liderazgo'] > 10 && $this->generalResults['liderazgo'] <= 20 => 'Bajo',
            $this->generalResults['liderazgo'] > 20 && $this->generalResults['liderazgo'] <= 45 => 'Medio',
            $this->generalResults['liderazgo'] > 45 && $this->generalResults['liderazgo'] <= 70 => 'Alto',
            $this->generalResults['liderazgo'] > 70 => 'Muy Alto',
            default => 'N/A',
        };
        $categories = [
            'Ambiente de trabajo'
            'Factores propios de la actividad',
            'Organización del tiempo de trabajo',
            'Liderazgo y relaciones en el trabajo',
        ];

            */

        $this->dispatch('open-modal', id: 'modal-result');
    }

    public function resultsGuideIII()
    {
        $queryResG3=RiskFactorSurveyOrganizational::where('norma_id', $this->norma->id)
            ->where('sede_id', $this->norma->sede_id);


        $calificacion=$queryResG3->sum('equivalence_response');
        $countCollabs=$queryResG3->distinct('user_id')->count('user_id');
        $this->totalResponsesG3=$countCollabs;
        $this->calificacionG3 = $this->totalResponsesG3 > 0 ? $calificacion / $this->totalResponsesG3 : 0;


        if($calificacion>=140){
            $this->resultCuestionarioG3='Muy Alto';
        }elseif ($calificacion>=99 && $calificacion<140 ) {
            $this->resultCuestionarioG3='Alto';
        }elseif ($calificacion>=75 && $calificacion<99) {
            $this->resultCuestionarioG3='Medio';
        }elseif ($calificacion>=50 && $calificacion<75) {
            $this->resultCuestionarioG3='Bajo';
        }elseif ($calificacion<50) {
            $this->resultCuestionarioG3='Despreciable';
        }
        //Se trabaja con los resultados generales de la guía III
        $this->generalResultsGuideIII = [];
        $responses= RiskFactorSurveyOrganizational::where('norma_id', $this->norma->id)
            ->where('sede_id', auth()->user()->sede_id)
            ->get()
            ->groupBy('user_id')
            ->map(function ($items) {
                return $items->sum('equivalence_response');
            });
        /*
         * Asignación de los resultados generales de la guía III
         */
        $this->generalResultsGuideIII = [
            'total' => $responses->count(),
            'null' => $responses->filter(fn($value) => $value < 50)->count(),
            'low' => $responses->filter(fn($value) => $value >= 50 && $value < 75)->count(),
            'medium' => $responses->filter(fn($value) => $value >= 75 && $value < 99)->count(),
            'high' => $responses->filter(fn($value) => $value >= 99 && $value < 140)->count(),
            'very_high' => $responses->filter(fn($value) => $value >= 140)->count(),
        ];
        /*
         * Asignación de los resultados generales por categoría de la guía III
         */
        $ambienteQuery= RiskFactorSurveyOrganizational::where('norma_id', $this->norma->id)
            ->where('sede_id', auth()->user()->sede_id)
            ->whereHas('question', function($q) {
                $q->whereIn('order', [1, 2, 3,4,5]);
            })
            ->get()
            ->groupBy('user_id')
            ->map(function ($items) {
                return $items->sum('equivalence_response');
            });
        $actividadQuery= RiskFactorSurveyOrganizational::where('norma_id', $this->norma->id)
            ->where('sede_id', auth()->user()->sede_id)
            ->whereHas('question', function($q) {
                $q->whereIn('order', [6,7,8,9,10,11,12,13,14,15,16,23,24,25,26,27,28,29,30,35,36,66,67,68,69]);
            })
            ->get()
            ->groupBy('user_id')
            ->map(function ($items) {
                return $items->sum('equivalence_response');
            });
        $tiempoQuery= RiskFactorSurveyOrganizational::where('norma_id', $this->norma->id)
            ->where('sede_id', auth()->user()->sede_id)
            ->whereHas('question', function($q) {
                $q->whereIn('order', [17,18,19,20,21,22]);
            })
            ->get()
            ->groupBy('user_id')
            ->map(function ($items) {
                return $items->sum('equivalence_response');
            });
        $liderazgoQuery= RiskFactorSurveyOrganizational::where('norma_id', $this->norma->id)
            ->where('sede_id', auth()->user()->sede_id)
            ->whereHas('question', function($q) {
                $q->whereIn('order', [31,32,33,34,37,38,39,40,41,42,43,44,45,46,57,58,59,60,61,62,63,64,71,72,73,74]);
            })
            ->get()
            ->groupBy('user_id')
            ->map(function ($items) {
                return $items->sum('equivalence_response');
            });
        $envirommentQuery= RiskFactorSurveyOrganizational::where('norma_id', $this->norma->id)
            ->where('sede_id', auth()->user()->sede_id)
            ->whereHas('question', function($q) {
                $q->whereIn('order', [47,48,49,50,51,52,53,54,55,56]);
            })
            ->get()
            ->groupBy('user_id')
            ->map(function ($items) {
                return $items->sum('equivalence_response');
            });
        $this->generalResultsGuideIIICategory = [
                'ambiente' => [
                    'nombre' => 'Ambiente de trabajo',
                    'total' => $ambienteQuery->count(),
                    'null' => $ambienteQuery->filter(fn($value) => $value < 5)->count(),
                    'low' => $ambienteQuery->filter(fn($value) => $value >= 5 && $value < 9)->count(),
                    'medium' => $ambienteQuery->filter(fn($value) => $value >= 9 && $value < 11)->count(),
                    'high' => $ambienteQuery->filter(fn($value) => $value >= 11 && $value < 14)->count(),
                    'very_high' => $ambienteQuery->filter(fn($value) => $value >= 14)->count(),
                ],
                'actividad' => [
                    'nombre' => 'Factores propios de la actividad',
                    'total' => $actividadQuery->count(),
                    'null' => $actividadQuery->filter(fn($value) => $value < 15)->count(),
                    'low' => $actividadQuery->filter(fn($value) => $value >= 15 && $value < 30)->count(),
                    'medium' => $actividadQuery->filter(fn($value) => $value >= 30 && $value < 45)->count(),
                    'high' => $actividadQuery->filter(fn($value) => $value >= 45 && $value < 60)->count(),
                    'very_high' => $actividadQuery->filter(fn($value) => $value >= 60)->count(),
                ],
                'tiempo' => [
                    'nombre' => 'Organización del tiempo de trabajo',
                    'total' => $tiempoQuery->count(),
                    'null' => $tiempoQuery->filter(fn($value) => $value < 5)->count(),
                    'low' => $tiempoQuery->filter(fn($value) => $value >= 5 && $value < 7)->count(),
                    'medium' => $tiempoQuery->filter(fn($value) => $value >= 7 && $value < 10)->count(),
                    'high' => $tiempoQuery->filter(fn($value) => $value >= 10 && $value < 13)->count(),
                    'very_high' => $tiempoQuery->filter(fn($value) => $value >= 13)->count(),
                ],
                'liderazgo' => [
                    'nombre' => 'Liderazgo y relaciones en el trabajo',
                    'total' => $liderazgoQuery->count(),
                    'null' => $liderazgoQuery->filter(fn($value) => $value < 14)->count(),
                    'low' => $liderazgoQuery->filter(fn($value) => $value >= 14 && $value < 29)->count(),
                    'medium' => $liderazgoQuery->filter(fn($value) => $value >= 29 && $value < 42)->count(),
                    'high' => $liderazgoQuery->filter(fn($value) => $value >= 42 && $value < 58)->count(),
                    'very_high' => $liderazgoQuery->filter(fn($value) => $value >= 58)->count(),
                ],
                'enviromment' => [
                    'nombre' => 'Condiciones del entorno de trabajo',
                    'total' => $envirommentQuery->count(),
                    'null' => $envirommentQuery->filter(fn($value) => $value < 10)->count(),
                    'low' => $envirommentQuery->filter(fn($value) => $value >= 10 && $value < 14)->count(),
                    'medium' => $envirommentQuery->filter(fn($value) => $value >= 14 && $value < 18)->count(),
                    'high' => $envirommentQuery->filter(fn($value) => $value >= 18 && $value < 23)->count(),
                    'very_high' => $envirommentQuery->filter(fn($value) => $value >= 23)->count(),
                ]
            ];
        /*
         * Asignación de los resultados generales por Dominio de la guía III
         */
        $this->generalDomainResultsGuideIII = [];
        $conditionResponses = RiskFactorSurveyOrganizational::where('norma_id', $this->norma->id)
            ->where('sede_id', auth()->user()->sede_id)
            ->whereHas('question', function($q) {
                $q->whereIn('order', [1, 2, 3, 4, 5]);
            })
            ->get()
            ->groupBy('user_id')
            ->map(function ($items) {
                return $items->sum('equivalence_response');
            });
        $workActivityResponses = RiskFactorSurveyOrganizational::where('norma_id', $this->norma->id)
            ->where('sede_id', auth()->user()->sede_id)
            ->whereHas('question', function($q) {
                $q->whereIn('order', [6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 66, 67, 68, 69]);
            })
            ->get()
            ->groupBy('user_id')
            ->map(function ($items) {
                return $items->sum('equivalence_response');
            });
        $workControlResponses = RiskFactorSurveyOrganizational::where('norma_id', $this->norma->id)
            ->where('sede_id', auth()->user()->sede_id)
            ->whereHas('question', function($q) {
                $q->whereIn('order', [23,24,25, 26, 27, 28, 29, 30,35,36]);
            })
            ->get()
            ->groupBy('user_id')
            ->map(function ($items) {
                return $items->sum('equivalence_response');
            });
        $workJourneyResponses = RiskFactorSurveyOrganizational::where('norma_id', $this->norma->id)
            ->where('sede_id', auth()->user()->sede_id)
            ->whereHas('question', function($q) {
                $q->whereIn('order', [17, 18]);
            })
            ->get()
            ->groupBy('user_id')
            ->map(function ($items) {
                return $items->sum('equivalence_response');
            });
        $wordAndFamilyResponses = RiskFactorSurveyOrganizational::where('norma_id', $this->norma->id)
            ->where('sede_id', auth()->user()->sede_id)
            ->whereHas('question', function($q) {
                $q->whereIn('order', [19, 20, 21, 22]);
            })
            ->get()
            ->groupBy('user_id')
            ->map(function ($items) {
                return $items->sum('equivalence_response');
            });
        $leadershipResponses= RiskFactorSurveyOrganizational::where('norma_id', $this->norma->id)
            ->where('sede_id', auth()->user()->sede_id)
            ->whereHas('question', function($q) {
                $q->whereIn('order', [31, 32, 33, 34, 37, 38, 39, 40, 41]);
            })
            ->get()
            ->groupBy('user_id')
            ->map(function ($items) {
                return $items->sum('equivalence_response');
            });
        $workRelationsResponses = RiskFactorSurveyOrganizational::where('norma_id', $this->norma->id)
            ->where('sede_id', auth()->user()->sede_id)
            ->whereHas('question', function($q) {
                $q->whereIn('order', [42, 43, 44, 45, 46, 71,72,73,74]);
            })
            ->get()
            ->groupBy('user_id')
            ->map(function ($items) {
                return $items->sum('equivalence_response');
            });
        $violenceResponses = RiskFactorSurveyOrganizational::where('norma_id', $this->norma->id)
            ->where('sede_id', auth()->user()->sede_id)
            ->whereHas('question', function($q) {
                $q->whereIn('order', [57,58,59,60,61,62,63,64]);
            })
            ->get()
            ->groupBy('user_id')
            ->map(function ($items) {
                return $items->sum('equivalence_response');
            });
        $performanceResponses = RiskFactorSurveyOrganizational::where('norma_id', $this->norma->id)
            ->where('sede_id', auth()->user()->sede_id)
            ->whereHas('question', function($q) {
                $q->whereIn('order', [47,48,49,50,51,52]);
            })
            ->get()
            ->groupBy('user_id')
            ->map(function ($items) {
                return $items->sum('equivalence_response');
            });
        $inestableResponses = RiskFactorSurveyOrganizational::where('norma_id', $this->norma->id)
            ->where('sede_id', auth()->user()->sede_id)
            ->whereHas('question', function($q) {
                $q->whereIn('order', [53,54,55,56]);
            })
            ->get()
            ->groupBy('user_id')
            ->map(function ($items) {
                return $items->sum('equivalence_response');
            });
        // Asignar los resultados de dominio en un array
        $this->generalDomainResultsGuideIII = [
            'conditions'=>[
                'nombre' => 'Condiciones en el ambiente de trabajo',
                'total' => $conditionResponses->count(),
                'null' => $conditionResponses->filter(fn($value) => $value < 5)->count(),
                'low' => $conditionResponses->filter(fn($value) => $value >= 5 && $value < 9)->count(),
                'medium' => $conditionResponses->filter(fn($value) => $value >= 9 && $value < 11)->count(),
                'high' => $conditionResponses->filter(fn($value) => $value >= 11 && $value < 14)->count(),
                'very_high' => $conditionResponses->filter(fn($value) => $value >= 14)->count(),
            ],
            'work_activity'=>[
                'nombre' => 'Carga de Trabajo',
                'total' => $workActivityResponses->count(),
                'null' => $workActivityResponses->filter(fn($value) => $value < 15)->count(),
                'low' => $workActivityResponses->filter(fn($value) => $value >= 15 && $value < 21)->count(),
                'medium' => $workActivityResponses->filter(fn($value) => $value >= 21 && $value < 27)->count(),
                'high' => $workActivityResponses->filter(fn($value) => $value >= 27 && $value < 37)->count(),
                'very_high' => $workActivityResponses->filter(fn($value) => $value >= 37)->count(),
            ],
            'work_control'=>[
                'nombre' => 'Falta de control sobre el trabajo',
                'total' => $workControlResponses->count(),
                'null' => $workControlResponses->filter(fn($value) => $value < 11)->count(),
                'low' => $workControlResponses->filter(fn($value) => $value >= 11 && $value < 16)->count(),
                'medium' => $workControlResponses->filter(fn($value) => $value >= 16 && $value < 21)->count(),
                'high' => $workControlResponses->filter(fn($value) => $value >= 21 && $value < 25)->count(),
                'very_high' => $workControlResponses->filter(fn($value) => $value >= 25)->count(),
            ],
            'work_journey'=>[
                'nombre' => 'Jornada de trabajo',
                'total' => $workJourneyResponses->count(),
                'null' => $workJourneyResponses->filter(fn($value) => $value < 1)->count(),
                'low' => $workJourneyResponses->filter(fn($value) => $value >= 1 && $value < 2)->count(),
                'medium' => $workJourneyResponses->filter(fn($value) => $value >= 2 && $value < 4)->count(),
                'high' => $workJourneyResponses->filter(fn($value) => $value >= 4 && $value < 6)->count(),
                'very_high' => $workJourneyResponses->filter(fn($value) => $value >= 6)->count(),
            ],
            'work_family'=>[
                'nombre' => 'Interferencia en la relación trabajo-familia',
                'total' => $wordAndFamilyResponses->count(),
                'null' => $wordAndFamilyResponses->filter(fn($value) => $value < 4)->count(),
                'low' => $wordAndFamilyResponses->filter(fn($value) => $value >= 4 && $value < 6)->count(),
                'medium' => $wordAndFamilyResponses->filter(fn($value) => $value >= 6 && $value < 8)->count(),
                'high' => $wordAndFamilyResponses->filter(fn($value) => $value >= 8 && $value < 10)->count(),
                'very_high' => $wordAndFamilyResponses->filter(fn($value) => $value >= 10)->count(),
            ],
            'leadership'=>[
                'nombre' => 'Liderazgo',
                'total' => $leadershipResponses->count(),
                'null' => $leadershipResponses->filter(fn($value) => $value < 9)->count(),
                'low' => $leadershipResponses->filter(fn($value) => $value >= 9 && $value < 12)->count(),
                'medium' => $leadershipResponses->filter(fn($value) => $value >= 12 && $value < 16)->count(),
                'high' => $leadershipResponses->filter(fn($value) => $value >= 16 && $value < 20)->count(),
                'very_high' => $leadershipResponses->filter(fn($value) => $value >= 20)->count(),
            ],
            'work_relations'=>[
                'nombre' => 'Relaciones en el trabajo',
                'total' => $workRelationsResponses->count(),
                'null' => $workRelationsResponses->filter(fn($value) => $value < 10)->count(),
                'low' => $workRelationsResponses->filter(fn($value) => $value >= 10 && $value < 13)->count(),
                'medium' => $workRelationsResponses->filter(fn($value) => $value >= 13 && $value < 17)->count(),
                'high' => $workRelationsResponses->filter(fn($value) => $value >= 17 && $value < 21)->count(),
                'very_high' => $workRelationsResponses->filter(fn($value) => $value >= 21)->count(),
            ],
            'violence'=>[
                'nombre' => 'Violencia',
                'total' => $violenceResponses->count(),
                'null' => $violenceResponses->filter(fn($value) => $value < 7)->count(),
                'low' => $violenceResponses->filter(fn($value) => $value >= 7 && $value < 10)->count(),
                'medium' => $violenceResponses->filter(fn($value) => $value >= 10 && $value < 13)->count(),
                'high' => $violenceResponses->filter(fn($value) => $value >= 13 && $value < 16)->count(),
                'very_high' => $violenceResponses->filter(fn($value) => $value >= 16)->count(),
            ],
            'performance'=>[
                'nombre' => 'Reconocimiento del desempeño',
                'total' => $performanceResponses->count(),
                'null' => $performanceResponses->filter(fn($value) => $value < 6)->count(),
                'low' => $performanceResponses->filter(fn($value) => $value >=6 && $value < 10)->count(),
                'medium' => $performanceResponses->filter(fn($value) => $value >= 10 && $value < 14)->count(),
                'high' => $performanceResponses->filter(fn($value) => $value >= 14 && $value < 16)->count(),
                'very_high' => $performanceResponses->filter(fn($value) => $value >= 16)->count(),
            ],
            'inestable'=>[
                'nombre' => 'Insuficiente sentido de pertenencia e, inestabilidad',
                'total' => $inestableResponses->count(),
                'null' => $inestableResponses->filter(fn($value) => $value < 4)->count(),
                'low' => $inestableResponses->filter(fn($value) => $value >= 4 && $value < 6)->count(),
                'medium' => $inestableResponses->filter(fn($value) => $value >= 6 && $value < 8)->count(),
                'high' => $inestableResponses->filter(fn($value) => $value >= 8 && $value < 10)->count(),
                'very_high' => $inestableResponses->filter(fn($value) => $value >= 10)->count(),
            ],
        ];


        $this->dispatch('open-modal',id:'test-results-guia-iii');
    }

    public function closeTestResultsGuideIII()
    {
        $this->dispatch('close-modal', id: 'test-results-guia-iii');
    }

    // Metodo para cerrar el modal de identificación
    public function closeModalResult()
    {
        $this->dispatch('close-modal', id: 'modal-result');

    }

    // Reiniciar estado del modal
    private function resetIdentificationModal()
    {
        $this->selectedCollaborator = null;
        $this->selectedEventType = null;
        $this->eventDescription = '';
        $this->loadIdentifiedEvents();
        $this->updateAvailableColaborators();
    }

    // Cargar colaboradores ya identificados de la BD
    private function loadIdentifiedColaborators()
    {
        $identified = IdentifiedCollaborator::
        where('norma_id', $this->norma->id ?? null)
        ->where('sede_id', auth()->user()->sede_id ?? null)
            ->with('user')
            ->get();


        $this->identifiedColaborators = $identified->map(function ($item) {
            return [
                'id' => $item->collaborator_id,
                'name' => $item->collaborator->name . ' ' . $item->collaborator->first_name . ' ' . $item->collaborator->second_name
            ];
        })->toArray();

        $this->updateAvailableColaborators();
    }

    // Actualizar la lista de colaboradores disponibles
    private function updateAvailableColaborators()
    {
        $identifiedIds = collect($this->identifiedColaborators)->pluck('id')->toArray();
        if($identifiedIds){
            $this->availableColaborators = $this->colabs->whereNotIn('id', $identifiedIds);
        }else{
            $this->availableColaborators = $this->colabs;
        }

    }

    // Agregar colaborador a la lista de identificados
    public function addToIdentifiedList()
    {
        if (!$this->selectedCollaborator || !$this->selectedEventType) {
            return;
        }

        $collaborator = $this->colaborators->firstWhere('id', $this->selectedCollaborator);
        if (!$collaborator) {
            return;
        }

        // Obtener la etiqueta del tipo de evento
        $eventTypeLabel = '';
        foreach ($this->eventTypesByCategory as $category => $types) {
            foreach ($types as $type) {
                if ($type->value === $this->selectedEventType) {
                    $eventTypeLabel = $type->label();
                    break 2;
                }
            }
        }

        $exists = collect($this->identifiedColaborators)->contains('id', $collaborator->id);
        if (!$exists) {
            $this->identifiedColaborators[] = [
                'id' => $collaborator->id,
                'name' => $collaborator->name . ' ' . $collaborator->first_name . ' ' . $collaborator->second_name,
                'event_type' => $this->selectedEventType,
                'event_type_label' => $eventTypeLabel,
                'description' => $this->eventDescription,
                'event_date' => $this->eventDate
            ];

            // Reiniciar campos después de agregar
            $this->selectedCollaborator = null;
            $this->selectedEventType = null;
            $this->eventDescription = '';
            $this->updateAvailableColaborators();
        }
    }

    // Eliminar colaborador de la lista de identificados
    public function removeFromIdentifiedList($index)
    {
        if (isset($this->identifiedColaborators[$index])) {
            unset($this->identifiedColaborators[$index]);
            $this->identifiedColaborators = array_values($this->identifiedColaborators);
            $this->updateAvailableColaborators();
        }
    }


    private function calculateSampleSize($population)
    {
        // Implementación del cálculo de muestra
        // Ejemplo básico
        return ceil(((.9604*$population))/(.0025 * ($population - 1) +.9604));
    }
    public function saveIdentifiedColaborators()
    {
        try {
            $normaId = $this->norma->id ?? null;

            if (!$normaId) {
                Notification::make()
                    ->title('Error al guardar')
                    ->body('No se encontró un proceso NOM-035 activo')
                    ->danger()
                    ->send();
                return;
            }

            // Primero procesamos cada elemento de la lista
            foreach ($this->identifiedColaborators as $identified) {
                $identifiedCollaborator = null;
                $traumaticEvent = null;

                if (!empty($identified['record_id'])) {
                    // Si existe un registro, encontramos el evento y su identificación
                    $traumaticEvent = TraumaticEvent::find($identified['record_id']);
                    if ($traumaticEvent) {
                        $identifiedCollaborator = $traumaticEvent->identifiedCollaborator;
                    }
                }

                // Si no existe la identificación, la creamos
                if (!$identifiedCollaborator) {
                    $identifiedCollaborator = IdentifiedCollaborator::create([
                        'sede_id' => auth()->user()->sede_id,
                        'user_id' => $identified['id'],
                        'norma_id' => $normaId,
                        'type_identification' => 'manual',
                        'identified_by' => auth()->id(),
                        'identified_at' => now(),
                    ]);
                }

                // Ahora creamos o actualizamos el evento traumático
                if ($traumaticEvent) {
                    // Actualizar evento existente
                    $traumaticEvent->update([
                        'event_type' => $identified['event_type'],
                        'description' => $identified['description'],
                        'date_occurred' => $identified['event_date'],
                        'updated_at' => now(),
                    ]);
                } else {
                    // Crear nuevo evento
                    TraumaticEvent::create([
                        'user_id' => $identified['id'],
                        'identified_id' => $identifiedCollaborator->id,
                        'event_type' => $identified['event_type'],
                        'description' => $identified['description'],
                        'date_occurred' => $identified['event_date'],
                    ]);
                }
            }

            // Eliminar registros que ya no están en la lista
            $currentIds = collect($this->identifiedColaborators)->pluck('id')->toArray();

            // Primero encontramos todas las identificaciones para esta norma y sede
            $existingIdentifications = IdentifiedCollaborator::where('norma_id', $normaId)
                ->where('sede_id', auth()->user()->sede_id)
                ->get();

            // Luego eliminamos las que no están en la lista actual
            foreach ($existingIdentifications as $existingId) {
                if (!in_array($existingId->user_id, $currentIds)) {
                    // Eliminar el evento traumático primero (la restricción de clave foránea manejará el resto)
                    if ($existingId->traumaticEvent) {
                        $existingId->traumaticEvent->delete();
                    }

                    // Luego eliminamos la identificación
                    $existingId->delete();
                }
            }

            Notification::make()
                ->title('Colaboradores y eventos registrados correctamente')
                ->success()
                ->send();

            $this->closeIdentificationModal();
        } catch (\Exception $e) {
            Notification::make()
                ->title('Error al guardar')
                ->body('Ha ocurrido un error: ' . $e->getMessage())
                ->danger()
                ->send();
        }
    }

    // Cargar eventos traumáticos ya registrados
    private function loadIdentifiedEvents()
    {
        $normaId = $this->norma->id;

        if (!$normaId) {
            $this->identifiedColaborators = [];
            return;
        }else{
            $normaId=$this->norma->id??null;
        }

        // Obtenemos todas las identificaciones con sus eventos
        $identifications = IdentifiedCollaborator::where('norma_id', $normaId)
            ->where('sede_id', auth()->user()->sede_id)
            ->with(['user', 'traumaticEvent'])
            ->get();

        $this->identifiedColaborators = [];

        foreach ($identifications as $identification) {
            $event = $identification->traumaticEvent;

            // Solo incluimos si tiene un evento traumático asociado
            if ($event) {
                $this->identifiedColaborators[] = [
                    'id' => $identification->user_id,
                    'name' => $identification->user->name . ' ' . $identification->user->first_name . ' ' . $identification->user->second_name,
                    'event_type' => $event->event_type->value,
                    'event_type_label' => $event->event_type->label(),
                    'description' => $event->description,
                    'event_date' => $event->date_occurred->format('Y-m-d'),
                    'record_id' => $event->id
                ];
            }
        }

        $this->updateAvailableColaborators();
    }

    public function openTestDialog(){

        $this->dispatch('open-modal', id: 'test-dialog');
    }
    public function closeTestDialog()
    {
        $this->dispatch('close-modal', id: 'test-dialog');
    }

    public function sendTest(){

        $someUsers= IdentifiedCollaborator::where('sede_id', $this->norma->sede_id)
            ->where('norma_id', $this->norma->id)
            ->where('type_identification','manual')
            ->exists();
        $evaluationId=EvaluationsTypes::select('id')
            ->where('name', 'like', 'Nom035: Guía I')
            ->first()->id ?? null;

        // Aquí puedes implementar la lógica para enviar el cuestionario
        $send= ActiveSurvey::create([
            'norma_id' => $this->norma->id,
            'evaluations_type_id' => $evaluationId,
            'some_users' => $someUsers,
        ]);
        $this->norma->status='en_progreso';
        $this->norma->save();

        Notification::make()
            ->title('Cuestionario enviado')
            ->body('Se ha enviado a ')
            ->success()
            ->send();

        $this->closeTestDialog();
        $this->redirect('/dashboard/nom035');
    }
    public function activeRiskFactorTest()
    {

        $evaluationId=EvaluationsTypes::select('id')
            ->where('name', 'like', 'Nom035: Guía II')
            ->first()->id ?? null;

        // Aquí puedes implementar la lógica para enviar el cuestionario
        $send= ActiveSurvey::create([
            'norma_id' => $this->norma->id,
            'evaluations_type_id' => $evaluationId,
            'some_users' => 0,
        ]);
        Notification::make()
            ->title('Guia II Activada')
            ->body('Se ha activado la Guia II correctamente')
            ->success()
            ->send();
        $this->redirect('/dashboard/nom035');

    }

    public function activeGuiaIII($value)
    {
        if($value) {
            //obetnemos la cantidad de colaboradores que seran asignados de manera aleatoria en esa sede $this->muestraGuideIII
            //Selecciona la cantidad de colaboradores a asignar el test $this->muestraGuideIII;

            $collaborators = IdentifiedCollaborator::where('sede_id', $this->norma->sede_id)
                ->where('norma_id', $this->norma->id)
                ->where('type_identification','manual')
                ->inRandomOrder()
                ->take($this->muestraGuideIII)
                ->pluck('user_id')
                ->toArray();


        }else{
            // Verificar si ya existe una encuesta activa para la Guía III
            $evaluationId=EvaluationsTypes::select('id')
                ->where('name', 'like', 'Nom035: Guía III')
                ->first()->id ?? null;

            // Aquí puedes implementar la lógica para enviar el cuestionario

            $send= ActiveSurvey::create([
                'norma_id' => $this->norma->id,
                'evaluations_type_id' => $evaluationId,
                'some_users' => 0,
            ]);

            //Hacer la alerta de que ha sido habilitada la guia III
            Notification::make()
                ->title('Guía III habilitada')
                ->body('Se habilitó la Guía III para su sede.')
                ->success()
                ->send();

            // Si no hay colaboradores seleccionados, no hacemos nada
            //Obtenemos todos los ids de los usuarios de esa sede para enviar las notificaciones de que se ha habilitado la GUIA III
            $collaborators=User::where('sede_id', $this->norma->sede_id)
                ->where('status', true)
                ->get();
            //Ahora enviamos las notificaciones a los usuarios
            foreach ($collaborators as $collaboratorId) {
                Notification::make()
                    ->title('Guía III habilitada')
                    ->info()
                    ->icon('heroicon-m-information-circle')
                    ->body('La Guía III ha sido habilitada para su sede. Por favor, complete el cuestionario.')
                    ->sendToDatabase($collaboratorId);
            }
            $this->closeTypeTest();
            $this->redirect('/dashboard/nom035');
            return;

        }

    }
    public function openTypeTest(){
        $this->muestraGuideIII= $this->calculateSampleSize($this->colabs->count());

        $this->dispatch('open-modal', id: 'type-test-modal');
    }
    public function closeTypeTest()
    {
        $this->dispatch('close-modal', id: 'type-test-modal');
    }

    // Metodo para descargar la plantilla de Word personalizada
    public function descargarWord()
    {
        $templatePath = storage_path('app/plantillas/Política_de_riesgos.docx'); // Mueve el archivo ahí
        //$templatePath = storage_path('app/plantillas/politica_adc.pptx'); // Mueve el archivo ahí
        $sede = auth()->user()->sede->name;
        $name=auth()->user()->name . ' ' . auth()->user()->first_mame . ' ' . auth()->user()->last_name;
        $template = new TemplateProcessor($templatePath);
        $template->setValue('sede', $sede);
        $template->setValue('fecha', now()->format('d/m/Y'));
        $template->setValue('name', $name);

        $outputPath = storage_path('app/livewire-tmp/Política_de_riesgos_personalizada.docx');
        $template->saveAs($outputPath);

        return response()->download($outputPath)->deleteFileAfterSend();
    }
    public function descargarExcel()
    {
        $path = storage_path('app/plantillas/plan_de_accion.xlsx');
        return response()->download($path, 'Plan_de_Accion_NOM035.xlsx');
    }

    public function descargarPowerPoint()
    {
        $templatePath = storage_path('app/plantillas/politica_adc.pptx');
        //$templatePath = storage_path('app/plantillas/Politica_de_riesgos.pptx');
        $sede = auth()->user()->sede->name;
        $name = auth()->user()->name . ' ' . auth()->user()->first_name . ' ' . auth()->user()->last_name;

        // Cargar la presentación existente
        $pptReader = IOFactory::createReader('PowerPoint2007');
        $presentation = $pptReader->load($templatePath);

        // Recorrer todas las diapositivas y sus shapes
        foreach ($presentation->getAllSlides() as $slide) {
            foreach ($slide->getShapeCollection() as $shape) {
                if ($shape instanceof \PhpOffice\PhpPresentation\Shape\RichText) {
                    $text = $shape->getPlainText();

                    // Reemplazos de placeholders
                    $text = str_replace('${sede}', $sede, $text);
                    $text = str_replace('${fecha}', now()->format('d/m/Y'), $text);
                    $text = str_replace('${name}', $name, $text);

                    // Actualizar el shape con el texto reemplazado
                    $shape->createTextRun($text);
                }
            }
        }

        // Guardar en temporal
        $outputPath = storage_path('app/livewire-tmp/Politica_de_riesgos_personalizada.pptx');
        $writer = IOFactory::createWriter($presentation, 'PowerPoint2007');
        $writer->save($outputPath);

        // Descargar
        return response()->download($outputPath)->deleteFileAfterSend();
    }

    // Metodo para exportar a PDF el reporte de Personal Identificado de html a pdf
    public function downloadPdfShift()
    {
        $identifiedEmployees = IdentifiedCollaborator::where('norma_id', $this->norma->id)
            ->where('sede_id', auth()->user()->sede_id)
            ->with(['user', 'traumaticEvent'])
            ->get();
        //Quiero traer los empleados que contestaron la encuesta de la Guía I
        $totalPersonsSurvey = TraumaticEventSurvey::where('norma_id', $this->norma->id)
            ->where('sede_id', auth()->user()->sede_id)
            ->get();

        // Verificar si hay empleados identificados
        $employees = $identifiedEmployees->map(function($identified) {
            return [
                'name' => $identified->user->name . ' ' . $identified->user->first_name . ' ' . $identified->user->second_name,
                'section1' => $identified->section1 ? 'ok' : 'false',
                'section2' => $identified->section2 ? 'ok' : 'false',
                'section3' => $identified->section3 ? 'ok' : 'false',
                'section4' => $identified->section4 ? 'ok' : 'false',
                'requires_clinical' => $identified->requires_clinical,
            ];
        })->toArray();

        // Verificar si hay empleados identificados
        $generalResults = [];
        $currentUserId = null;
        $section1 = 'No';
        $section2 = 0;
        $section3 = 0;
        $section4 = 0;

        foreach ($totalPersonsSurvey as $index => $item) {
            // Si cambiamos de usuario, guardamos los resultados del usuario anterior
            if ($currentUserId !== null && $currentUserId !== $item->user->id) {
                // Guardar resultados del usuario anterior
                $generalResults[] = [
                    'name' => $previousUserName,
                    'section1' => $section1,
                    'section2' => $section2 >= 1 ? 'Sí' : 'No',
                    'section3' => $section3 >= 3 ? 'Sí' : 'No',
                    'section4' => $section4 >= 2 ? 'Sí' : 'No',
                    'requires_clinical' => $section2 >= 1 || $section3 >= 3 || $section4 >= 2,
                ];
                $individualEmployees[]=[
                    'name'=> $previousUserName,
                    'position' => User::find($currentUserId)->position->name ?? 'No definido',
                    'requires_clinical' => $section2 >= 1 || $section3 >= 3 || $section4 >= 2,
                ];

                // Reiniciar variables para el nuevo usuario
                $section1 = 'No';
                $section2 = 0;
                $section3 = 0;
                $section4 = 0;
            }

            // Actualizar usuario actual
            $currentUserId = $item->user->id;
            $previousUserName = $item->user->name . ' ' . $item->user->first_name . ' ' . $item->user->last_name;

            // Procesar respuestas por sección
            if ($item->question->competence->name === 'Sección I') {
                $section1 = $item->response == 'si' ? 'Sí' : 'No';
            } elseif ($item->question->competence->name === 'Sección II') {
                if ($item->response == 'si') {
                    $section2++;
                }
            } elseif ($item->question->competence->name === 'Sección III') {
                if ($item->response == 'si') {
                    $section3++;
                }
            } elseif ($item->question->competence->name === 'Sección IV') {
                if ($item->response == 'si') {
                    $section4++;
                }
            }
        }

        // No olvides guardar el último usuario después del bucle
        if ($currentUserId !== null) {
            $generalResults[] = [
                'name' => $previousUserName,
                'section1' => $section1,
                'section2' => $section2 >= 1 ? 'Sí' : 'No',
                'section3' => $section3 >= 3 ? 'Sí' : 'No',
                'section4' => $section4 >= 2 ? 'Sí' : 'No',
                'requires_clinical' => $section2 >= 1 || $section3 >= 3 || $section4 >= 2,
            ];

            $individualEmployees[]=[
                'name'=> $previousUserName,
                'position' => User::find($currentUserId)->position->name ?? 'No definido',
                'requires_clinical' => $section2 >= 1 || $section3 >= 3 || $section4 >= 2,
            ];
        }



        // Pasar las variables directamente, no como arreglo
        $html = view('filament.pages.nom35.identification_report', [
            'company' => auth()->user()->sede->name ?? 'No definido', //OK
            'reportDate' => \Carbon\Carbon::now()->locale('es')->isoFormat('D [de] MMMM, YYYY'),
            'period' => $this->norma->start_date->locale('es')->isoFormat('D [de] MMMM, YYYY') . ' al ' . \Carbon\Carbon::now()->locale('es')->isoFormat('D [de] MMMM, YYYY'),
            'totalSurveys' => $this->colabResponsesG1,
            'noClinical' => $this->colabResponsesG1 - $identifiedEmployees->count(),
            'clinical' => $identifiedEmployees->count(),
            'noClinicalPercent' => $identifiedEmployees->count() > 0 ?
                number_format((($this->colabResponsesG1 - $identifiedEmployees->count()) / $this->colabResponsesG1 ) * 100, 1) : '0',
            'clinicalPercent' => $identifiedEmployees->count() > 0 ?
                number_format(($identifiedEmployees->count() / $this->colabResponsesG1 ) * 100, 1) : '0',
            'employees' => $employees,
            'individualEmployees' => $individualEmployees,
            'totalPersonsSurvey' => $generalResults,
        ])->render();


        // Forzar codificación UTF-8
        $html = mb_convert_encoding($html, 'UTF-8', 'UTF-8');

        $payload = [
            'source'    => $html,
            'landscape' => false,
            'use_print' => false,
            'margin'    => [
                'top'    => 20,
                'bottom' => 20,
                'left'   => 15,
                'right'  => 15,
            ],
        ];


        $response = Http::withHeaders([
            'Content-Type' => 'application/json',
            'X-API-Key'    => config('services.pdfshift.api_key'),
        ])
            ->withBody(json_encode($payload, JSON_UNESCAPED_UNICODE), 'application/json')
            ->post('https://api.pdfshift.io/v3/convert/pdf');


        if ($response->successful()) {

            $pdfContent = $response->body();
            // Forzar descarga en el navegador
            return response()->streamDownload(function () use ($pdfContent) {
                echo $pdfContent;
            },'documento.pdf');


        }else{
            Notification::make()
                ->title('Error al generar PDF')
                ->body('No se pudo generar el PDF: ' . $response->body())
                ->danger()
                ->send();
            //return abort(500, 'Error al generar el PDF');

        }
    }

    public function reportGeneralGIIDownload()
    {

        $recomendaciones=[
            'Muy Alto' =>'Se requiere realizar el análisis de cada categoría y dominio para establecer las acciones de intervención apropiadas, mediante un Programa de intervención que deberá incluir evaluaciones específicas1, y contemplar campañas de sensibilización, revisar la política de prevención de riesgos psicosociales y programas para la prevención de los factores de riesgo psicosocial, la promoción de un entorno organizacional favorable y la prevención de la violencia laboral, así como reforzar su aplicación y difusión.',
            'Alto' => 'Se requiere realizar un análisis de cada categoría y dominio, de manera que se puedan determinar las acciones de intervención apropiadas a través de un Programa de intervención, que podrá incluir una evaluación específica y deberá incluir una campaña de sensibilización, revisar la política de prevención de riesgos psicosociales y programas para la prevención de los factores de riesgo psicosocial, la promoción de un entorno organizacional favorable y la prevención de la violencia laboral, así como reforzar su aplicación y difusión.',
            'Medio' => 'Se requiere revisar la política de prevención de riesgos psicosociales y programas para la prevención de los factores de riesgo psicosocial, la promoción de un entorno organizacional favorable y la prevención de la violencia laboral, así como reforzar su aplicación y difusión, mediante un Programa de intervención.',
            'Bajo' => 'Es necesario una mayor difusión de la política de prevención de riesgos psicosociales y programas para: la prevención de los factores de riesgo psicosocial, la promoción de un entorno organizacional favorable y la prevención de la violencia laboral. ',
            'Nulo' => 'El riesgo resulta despreciable por lo que no se requiere medidas adicionales.'
        ];
         $html=view('filament.pages.nom35.risk_factor_report', [
            'company' => auth()->user()->sede->name ?? 'No definido', //OK
            'reportDate' => \Carbon\Carbon::now()->locale('es')->isoFormat('D [de] MMMM, YYYY'),
            'period' => $this->norma->start_date->locale('es')->isoFormat('D [de] MMMM, YYYY') . ' al ' . \Carbon\Carbon::now()->locale('es')->isoFormat('D [de] MMMM, YYYY'),
            'responsesTotalG2' => $this->responsesTotalG2,
            'generalResults' => $this->generalResults,
            'calificacionG2' => $this->calificacion,
            'resultCuestionario' => $this->resultCuestionario,
            'categories'=>$this->generalResultsCategory,
            'dominios'=> $this->domainResults,
            'recommendations' =>$recomendaciones[$this->resultCuestionario==='Muy Alto'?'Muy-Alto':$this->resultCuestionario],
            ])->render();


        // Forzar codificación UTF-8
        $html = mb_convert_encoding($html, 'UTF-8', 'UTF-8');

        $payload = [
            'source'    => $html,
            'landscape' => false,
            'use_print' => false,
            'margin'    => [
                'top'    => 10,
                'bottom' => 10,
                'left'   => 10,
                'right'  => 10,
            ],
        ];


        $response = Http::withHeaders([
            'Content-Type' => 'application/json',
            'X-API-Key'    => config('services.pdfshift.api_key'),
        ])
            ->withBody(json_encode($payload, JSON_UNESCAPED_UNICODE), 'application/json')
            ->post('https://api.pdfshift.io/v3/convert/pdf');
        if ($response->successful()) {

            $pdfContent = $response->body();
            // Forzar descarga en el navegador
            return response()->streamDownload(function () use ($pdfContent) {
                echo $pdfContent;
            },'ReporteGeneral.pdf');


        }else{
            Notification::make()
                ->title('Error al generar PDF')
                ->body('No se pudo generar el PDF: ' . $response->body())
                ->danger()
                ->send();
            //return abort(500, 'Error al generar el PDF');

        }


    }
   /* public function reportIndividualGIIDownload(){
        $domainNames = [
            'conditions' => 'Condiciones del ambiente de trabajo',
            'work_activity' => 'Carga de Trabajo',
            'work_control' => 'Falta de control sobre el trabajo',
            'work_journey' => 'Organización del tiempo de trabajo',
            'work_family' => 'Interferencia trabajo-familia',
            'leadership' => 'Liderazgo y relaciones en el trabajo',
            'work_relations' => 'Relaciones en el trabajo',
            'violence' => 'Violencia en el trabajo',
        ];

        $categoryNames = [
            'ambiente' => 'Ambiente de trabajo',
            'activity' => 'Factores propios de la actividad',
            'time' => 'Organización del tiempo de trabajo',
            'leadership' => 'Liderazgo y relaciones en el trabajo',
        ];

        //quiero traer todos los usuarios que respondieron la encuesta de la guia II
        $users = RiskFactorSurvey::where('norma_id', $this->norma->id)
            ->where('sede_id', auth()->user()->sede_id)
            ->with('user')
            ->get()
            ->groupBy('user_id')
            ->map(function ($items, $userId) {
                $user = $items->first()->user;
                $responses = $items->mapWithKeys(function ($item) {
                    return [$item->question->order => $item->equivalence_response];
                })->toArray();

                $dimensions = [
                    'condiciones_peligrosas' => array_sum(array_intersect_key($responses, array_flip([2]))),
                    'condiciones_deficientes' => array_sum(array_intersect_key($responses, array_flip([1]))),
                    'trabajos_peligrosos' => array_sum(array_intersect_key($responses, array_flip([3]))),
                    'cargas_cuantitativas' => array_sum(array_intersect_key($responses, array_flip([4,9]))),
                    'ritmos_acelerados' => array_sum(array_intersect_key($responses, array_flip([5,6]))),
                    'carga_mental' => array_sum(array_intersect_key($responses, array_flip([7,8]))),
                    'cargas_psicologicas' => array_sum(array_intersect_key($responses, array_flip([42,43,44]))),
                    'alta_responsabilidad' => array_sum(array_intersect_key($responses, array_flip([10,11]))),
                    'cargas_contradictorias' => array_sum(array_intersect_key($responses, array_flip([12,13]))),
                    'falta_control' => array_sum(array_intersect_key($responses, array_flip([20,21,22]))),
                    'posibilidad_desarrollo' => array_sum(array_intersect_key($responses, array_flip([18,19]))),
                    'capacitacion' => array_sum(array_intersect_key($responses, array_flip([26,27]))),
                    'jornadas_extensas' => array_sum(array_intersect_key($responses, array_flip([14,15]))),
                    'influencia_fuera_trabajo' => array_sum(array_intersect_key($responses, array_flip([16]))),
                    'responsabilidades_familiares' => array_sum(array_intersect_key($responses, array_flip([17]))),
                    'claridad_funciones' => array_sum(array_intersect_key($responses, array_flip([23,24,25]))),
                    'liderazgo' => array_sum(array_intersect_key($responses, array_flip([28,29]))),
                    'relaciones_sociales' => array_sum(array_intersect_key($responses, array_flip([30,31,32]))),
                    'relacion_colaboradores' => array_sum(array_intersect_key($responses, array_flip([46,47,48]))),
                    'violencia_laboral' => array_sum(array_intersect_key($responses, array_flip([33,34,35,36,37,38,39,40]))),
                ];


                // Calcular los dominios
                $domains = [
                    'conditions' => array_sum(array_intersect_key($responses, array_flip([1,2,3]))),
                    'work_activity' => array_sum(array_intersect_key($responses, array_flip([4,9,5,6,7,8,42,43,44,10,11,12,13]))),
                    'work_control' => array_sum(array_intersect_key($responses, array_flip([20,21,22,18,19,26,27]))),
                    'work_journey' => array_sum(array_intersect_key($responses, array_flip([14,15]))),
                    'work_family' => array_sum(array_intersect_key($responses, array_flip([16,17]))),
                    'leadership' => array_sum(array_intersect_key($responses, array_flip([23,24,25,28,29]))),
                    'work_relations' => array_sum(array_intersect_key($responses, array_flip([30,31,32,46,47,48]))),
                    'violence' => array_sum(array_intersect_key($responses, array_flip([33,34,35,36,37,38,39,40]))),
                ];

                // Calcular categories
                $categories = [
                    'ambiente' => array_sum(array_intersect_key($responses, array_flip([1,2,3]))),
                    'activity' => $domains['work_activity']+$domains['work_control'],
                    'time' => $domains['work_journey']+$domains['work_family'],
                    'leadership' =>$domains['leadership']+$domains['work_relations']+$domains['violence'],
                ];

                return [
                    'user' => $user,
                    'responses' => $responses,
                    'categories' => $categories,
                    'domains' => $domains,
                    'dimensions' => $dimensions,
                    'total_score' => array_sum($responses),
                ];
            })->toArray();
        dd($users);

    }*/
    public function reportIndividualGIIDownload(){
        $domainNames = [
            'conditions' => 'Condiciones del ambiente de trabajo',
            'work_activity' => 'Carga de Trabajo',
            'work_control' => 'Falta de control sobre el trabajo',
            'work_journey' => 'Organización del tiempo de trabajo',
            'work_family' => 'Interferencia trabajo-familia',
            'leadership' => 'Liderazgo y relaciones en el trabajo',
            'work_relations' => 'Relaciones en el trabajo',
            'violence' => 'Violencia en el trabajo',
        ];

        $categoryNames = [
            'ambiente' => 'Ambiente de trabajo',
            'activity' => 'Factores propios de la actividad',
            'time' => 'Organización del tiempo de trabajo',
            'leadership' => 'Liderazgo y relaciones en el trabajo',
        ];

        $dimensionNames = [
            'condiciones_peligrosas' => 'Condiciones peligrosas e inseguras',
            'condiciones_deficientes' => 'Condiciones deficientes e insalubres',
            'trabajos_peligrosos' => 'Trabajos peligrosos',
            'cargas_cuantitativas' => 'Cargas cuantitativas',
            'ritmos_acelerados' => 'Ritmos de trabajo acelerado',
            'carga_mental' => 'Carga mental',
            'cargas_psicologicas' => 'Cargas psicológicas emocionales',
            'alta_responsabilidad' => 'Alta responsabilidad',
            'cargas_contradictorias' => 'Cargas contradictorias o inconsistentes',
            'falta_control' => 'Falta de control y autonomía sobre el trabajo',
            'posibilidad_desarrollo' => 'Posibilidades de desarrollo',
            'capacitacion' => 'Capacitación insuficiente',
            'jornadas_extensas' => 'Jornadas de trabajo y rotación de turnos',
            'influencia_fuera_trabajo' => 'Influencia del trabajo fuera del centro laboral',
            'responsabilidades_familiares' => 'Responsabilidades familiares',
            'claridad_funciones' => 'Claridad de funciones',
            'liderazgo' => 'Liderazgo',
            'relaciones_sociales' => 'Relaciones sociales en el trabajo',
            'relacion_colaboradores' => 'Relación con los colaboradores',
            'violencia_laboral' => 'Violencia laboral',
        ];

        $recomendaciones=[
            'Muy Alto' =>'Se requiere realizar el análisis de cada categoría y dominio para establecer las acciones de intervención apropiadas, mediante un Programa de intervención que deberá incluir evaluaciones específicas1, y contemplar campañas de sensibilización, revisar la política de prevención de riesgos psicosociales y programas para la prevención de los factores de riesgo psicosocial, la promoción de un entorno organizacional favorable y la prevención de la violencia laboral, así como reforzar su aplicación y difusión.',
            'Alto' => 'Se requiere realizar un análisis de cada categoría y dominio, de manera que se puedan determinar las acciones de intervención apropiadas a través de un Programa de intervención, que podrá incluir una evaluación específica y deberá incluir una campaña de sensibilización, revisar la política de prevención de riesgos psicosociales y programas para la prevención de los factores de riesgo psicosocial, la promoción de un entorno organizacional favorable y la prevención de la violencia laboral, así como reforzar su aplicación y difusión.',
            'Medio' => 'Se requiere revisar la política de prevención de riesgos psicosociales y programas para la prevención de los factores de riesgo psicosocial, la promoción de un entorno organizacional favorable y la prevención de la violencia laboral, así como reforzar su aplicación y difusión, mediante un Programa de intervención.',
            'Bajo' => 'Es necesario una mayor difusión de la política de prevención de riesgos psicosociales y programas para: la prevención de los factores de riesgo psicosocial, la promoción de un entorno organizacional favorable y la prevención de la violencia laboral. ',
            'Nulo' => 'El riesgo resulta despreciable por lo que no se requiere medidas adicionales.'
        ];

        // Traer todos los usuarios que respondieron la encuesta de la guía II
        $users = RiskFactorSurvey::where('norma_id', $this->norma->id)
            ->where('sede_id', auth()->user()->sede_id)
            ->with('user')
            ->get()
            ->groupBy('user_id')
            ->map(function ($items, $userId) use ($domainNames, $categoryNames, $dimensionNames,$recomendaciones) {
                $user = $items->first()->user;
                $responses = $items->mapWithKeys(function ($item) {
                    return [$item->question->order => $item->equivalence_response];
                })->toArray();

                // Calcular las dimensiones
                $dimensions = [
                    'condiciones_peligrosas' => array_sum(array_intersect_key($responses, array_flip([2]))),
                    'condiciones_deficientes' => array_sum(array_intersect_key($responses, array_flip([1]))),
                    'trabajos_peligrosos' => array_sum(array_intersect_key($responses, array_flip([3]))),
                    'cargas_cuantitativas' => array_sum(array_intersect_key($responses, array_flip([4,9]))),
                    'ritmos_acelerados' => array_sum(array_intersect_key($responses, array_flip([5,6]))),
                    'carga_mental' => array_sum(array_intersect_key($responses, array_flip([7,8]))),
                    'cargas_psicologicas' => array_sum(array_intersect_key($responses, array_flip([42,43,44]))),
                    'alta_responsabilidad' => array_sum(array_intersect_key($responses, array_flip([10,11]))),
                    'cargas_contradictorias' => array_sum(array_intersect_key($responses, array_flip([12,13]))),
                    'falta_control' => array_sum(array_intersect_key($responses, array_flip([20,21,22]))),
                    'posibilidad_desarrollo' => array_sum(array_intersect_key($responses, array_flip([18,19]))),
                    'capacitacion' => array_sum(array_intersect_key($responses, array_flip([26,27]))),
                    'jornadas_extensas' => array_sum(array_intersect_key($responses, array_flip([14,15]))),
                    'influencia_fuera_trabajo' => array_sum(array_intersect_key($responses, array_flip([16]))),
                    'responsabilidades_familiares' => array_sum(array_intersect_key($responses, array_flip([17]))),
                    'claridad_funciones' => array_sum(array_intersect_key($responses, array_flip([23,24,25]))),
                    'liderazgo' => array_sum(array_intersect_key($responses, array_flip([28,29]))),
                    'relaciones_sociales' => array_sum(array_intersect_key($responses, array_flip([30,31,32]))),
                    'relacion_colaboradores' => array_sum(array_intersect_key($responses, array_flip([46,47,48]))),
                    'violencia_laboral' => array_sum(array_intersect_key($responses, array_flip([33,34,35,36,37,38,39,40]))),
                ];

                // Calcular los dominios
                $domains = [
                    'conditions' => array_sum(array_intersect_key($responses, array_flip([1,2,3]))),
                    'work_activity' => array_sum(array_intersect_key($responses, array_flip([4,9,5,6,7,8,42,43,44,10,11,12,13]))),
                    'work_control' => array_sum(array_intersect_key($responses, array_flip([20,21,22,18,19,26,27]))),
                    'work_journey' => array_sum(array_intersect_key($responses, array_flip([14,15]))),
                    'work_family' => array_sum(array_intersect_key($responses, array_flip([16,17]))),
                    'leadership' => array_sum(array_intersect_key($responses, array_flip([23,24,25,28,29]))),
                    'work_relations' => array_sum(array_intersect_key($responses, array_flip([30,31,32,46,47,48]))),
                    'violence' => array_sum(array_intersect_key($responses, array_flip([33,34,35,36,37,38,39,40]))),
                ];

                // Calcular categorías
                $categories = [
                    'ambiente' => array_sum(array_intersect_key($responses, array_flip([1,2,3]))),
                    'activity' => $domains['work_activity']+$domains['work_control'],
                    'time' => $domains['work_journey']+$domains['work_family'],
                    'leadership' => $domains['leadership']+$domains['work_relations']+$domains['violence'],
                ];

                // Función para determinar nivel de riesgo
                $getRiskLevel = function($score, $thresholds) {
                    if ($score < $thresholds[0]) return 'Nulo o despreciable';
                    if ($score < $thresholds[1]) return 'Bajo';
                    if ($score < $thresholds[2]) return 'Medio';
                    if ($score < $thresholds[3]) return 'Alto';
                    return 'Muy alto';
                };

                // Agregar niveles de riesgo para cada dimensión
                $dimensionsWithLevels = [];
                foreach ($dimensions as $key => $value) {
                    $dimensionsWithLevels[$key] = [
                        'score' => $value,
                        'name' => $dimensionNames[$key],
                        'level' => $this->getDimensionRiskLevel($key, $value)
                    ];
                }
                $domainsWithLevels = [];
                foreach ($domains as $key => $value) {
                    $domainsWithLevels[$key] = [
                        'score' => $value,
                        'name' => $domainNames[$key],
                        'level' => $this->getDomainRiskLevel($key, $value)
                    ];
                }
                // Agregar niveles de riesgo para cada categoría
                $categoriesWithLevels = [];
                foreach ($categories as $key => $value) {
                    $categoriesWithLevels[$key] = [
                        'score' => $value,
                        'name' => $categoryNames[$key],
                        'level' => $this->getCategoryRiskLevel($key, $value)

                    ];
                }
                // Estructura jerárquica: Categorías -> Dominios -> Dimensiones
                $structure = [
                    'ambiente' => [
                        'name' => 'Ambiente de trabajo',
                        'score' => $dimensions['condiciones_peligrosas'] + $dimensions['condiciones_deficientes'] + $dimensions['trabajos_peligrosos'],
                        'level' => $this->getCategoryRiskLevel('ambiente', $dimensions['condiciones_peligrosas'] + $dimensions['condiciones_deficientes'] + $dimensions['trabajos_peligrosos']),
                        'domains' => [
                            'conditions' => [
                                'name' => 'Condiciones en el ambiente de trabajo',
                                'score' => $dimensions['condiciones_peligrosas'] + $dimensions['condiciones_deficientes'] + $dimensions['trabajos_peligrosos'],
                                'level' => $this->getDomainRiskLevel('conditions', $dimensions['condiciones_peligrosas'] + $dimensions['condiciones_deficientes'] + $dimensions['trabajos_peligrosos']),
                                'dimensions' => [
                                    [
                                        'name' => 'Condiciones peligrosas e inseguras',
                                        'score' => $dimensions['condiciones_peligrosas'],
                                        'level' => $this->getDimensionRiskLevel('condiciones_peligrosas', $dimensions['condiciones_peligrosas'])
                                    ],
                                    [
                                        'name' => 'Condiciones deficientes e insalubres',
                                        'score' => $dimensions['condiciones_deficientes'],
                                        'level' => $this->getDimensionRiskLevel('condiciones_deficientes', $dimensions['condiciones_deficientes'])
                                    ],
                                    [
                                        'name' => 'Trabajos peligrosos',
                                        'score' => $dimensions['trabajos_peligrosos'],
                                        'level' => $this->getDimensionRiskLevel('trabajos_peligrosos', $dimensions['trabajos_peligrosos'])
                                    ]
                                ]
                            ]
                        ]
                    ],
                    'activity' => [
                        'name' => 'Factores propios de la actividad',
                        'score' => array_sum(array_slice($dimensions, 3, 9)), // Suma de todas las dimensiones de actividad
                        'level' => $this->getCategoryRiskLevel('activity', array_sum(array_slice($dimensions, 3, 9))),
                        'domains' => [
                            'work_activity' => [
                                'name' => 'Carga de trabajo',
                                'score' => $dimensions['cargas_cuantitativas'] + $dimensions['ritmos_acelerados'] + $dimensions['carga_mental'] + $dimensions['cargas_psicologicas'] + $dimensions['alta_responsabilidad'] + $dimensions['cargas_contradictorias'],
                                'level' => $this->getDomainRiskLevel('work_activity', $dimensions['cargas_cuantitativas'] + $dimensions['ritmos_acelerados'] + $dimensions['carga_mental'] + $dimensions['cargas_psicologicas'] + $dimensions['alta_responsabilidad'] + $dimensions['cargas_contradictorias']),
                                'dimensions' => [
                                    [
                                        'name' => 'Cargas cuantitativas',
                                        'score' => $dimensions['cargas_cuantitativas'],
                                        'level' => $this->getDimensionRiskLevel('cargas_cuantitativas', $dimensions['cargas_cuantitativas'])
                                    ],
                                    [
                                        'name' => 'Ritmos de trabajo acelerado',
                                        'score' => $dimensions['ritmos_acelerados'],
                                        'level' => $this->getDimensionRiskLevel('ritmos_acelerados', $dimensions['ritmos_acelerados'])
                                    ],
                                    [
                                        'name' => 'Carga mental',
                                        'score' => $dimensions['carga_mental'],
                                        'level' => $this->getDimensionRiskLevel('carga_mental', $dimensions['carga_mental'])
                                    ],
                                    [
                                        'name' => 'Cargas psicológicas emocionales',
                                        'score' => $dimensions['cargas_psicologicas'],
                                        'level' => $this->getDimensionRiskLevel('cargas_psicologicas', $dimensions['cargas_psicologicas'])
                                    ],
                                    [
                                        'name' => 'Cargas de alta responsabilidad',
                                        'score' => $dimensions['alta_responsabilidad'],
                                        'level' => $this->getDimensionRiskLevel('alta_responsabilidad', $dimensions['alta_responsabilidad'])
                                    ],
                                    [
                                        'name' => 'Cargas contradictorias o inconsistentes',
                                        'score' => $dimensions['cargas_contradictorias'],
                                        'level' => $this->getDimensionRiskLevel('cargas_contradictorias', $dimensions['cargas_contradictorias'])
                                    ]
                                ]
                            ],
                            'work_control' => [
                                'name' => 'Falta de control sobre el trabajo',
                                'score' => $dimensions['falta_control'] + $dimensions['posibilidad_desarrollo'] + $dimensions['capacitacion'],
                                'level' => $this->getDomainRiskLevel('work_control', $dimensions['falta_control'] + $dimensions['posibilidad_desarrollo'] + $dimensions['capacitacion']),
                                'dimensions' => [
                                    [
                                        'name' => 'Falta de control y autonomía sobre el trabajo',
                                        'score' => $dimensions['falta_control'],
                                        'level' => $this->getDimensionRiskLevel('falta_control', $dimensions['falta_control'])
                                    ],
                                    [
                                        'name' => 'Limitada o nula posibilidad de desarrollo',
                                        'score' => $dimensions['posibilidad_desarrollo'],
                                        'level' => $this->getDimensionRiskLevel('posibilidad_desarrollo', $dimensions['posibilidad_desarrollo'])
                                    ],
                                    [
                                        'name' => 'Limitada o inexistente capacitación',
                                        'score' => $dimensions['capacitacion'],
                                        'level' => $this->getDimensionRiskLevel('capacitacion', $dimensions['capacitacion'])
                                    ]
                                ]
                            ]
                        ]
                    ],
                    'time' => [
                        'name' => 'Organización del tiempo de trabajo',
                        'score' => $dimensions['jornadas_extensas'] + $dimensions['influencia_fuera_trabajo'] + $dimensions['responsabilidades_familiares'],
                        'level' => $this->getCategoryRiskLevel('time', $dimensions['jornadas_extensas'] + $dimensions['influencia_fuera_trabajo'] + $dimensions['responsabilidades_familiares']),
                        'domains' => [
                            'work_journey' => [
                                'name' => 'Jornada de trabajo',
                                'score' => $dimensions['jornadas_extensas'],
                                'level' => $this->getDomainRiskLevel('work_journey', $dimensions['jornadas_extensas']),
                                'dimensions' => [
                                    [
                                        'name' => 'Jornadas de trabajo extensas',
                                        'score' => $dimensions['jornadas_extensas'],
                                        'level' => $this->getDimensionRiskLevel('jornadas_extensas', $dimensions['jornadas_extensas'])
                                    ]
                                ]
                            ],
                            'work_family' => [
                                'name' => 'Interferencia en la relación trabajo-familia',
                                'score' => $dimensions['influencia_fuera_trabajo'] + $dimensions['responsabilidades_familiares'],
                                'level' => $this->getDomainRiskLevel('work_family', $dimensions['influencia_fuera_trabajo'] + $dimensions['responsabilidades_familiares']),
                                'dimensions' => [
                                    [
                                        'name' => 'Influencia del trabajo fuera del centro laboral',
                                        'score' => $dimensions['influencia_fuera_trabajo'],
                                        'level' => $this->getDimensionRiskLevel('influencia_fuera_trabajo', $dimensions['influencia_fuera_trabajo'])
                                    ],
                                    [
                                        'name' => 'Influencia de las responsabilidades familiares',
                                        'score' => $dimensions['responsabilidades_familiares'],
                                        'level' => $this->getDimensionRiskLevel('responsabilidades_familiares', $dimensions['responsabilidades_familiares'])
                                    ]
                                ]
                            ]
                        ]
                    ],
                    'leadership' => [
                        'name' => 'Liderazgo y relaciones en el trabajo',
                        'score' => $dimensions['claridad_funciones'] + $dimensions['liderazgo'] + $dimensions['relaciones_sociales'] + $dimensions['relacion_colaboradores'] + $dimensions['violencia_laboral'],
                        'level' => $this->getCategoryRiskLevel('leadership', $dimensions['claridad_funciones'] + $dimensions['liderazgo'] + $dimensions['relaciones_sociales'] + $dimensions['relacion_colaboradores'] + $dimensions['violencia_laboral']),
                        'domains' => [
                            'leadership' => [
                                'name' => 'Liderazgo',
                                'score' => $dimensions['claridad_funciones'] + $dimensions['liderazgo'],
                                'level' => $this->getDomainRiskLevel('leadership', $dimensions['claridad_funciones'] + $dimensions['liderazgo']),
                                'dimensions' => [
                                    [
                                        'name' => 'Escasa claridad de funciones',
                                        'score' => $dimensions['claridad_funciones'],
                                        'level' => $this->getDimensionRiskLevel('claridad_funciones', $dimensions['claridad_funciones'])
                                    ],
                                    [
                                        'name' => 'Características del liderazgo',
                                        'score' => $dimensions['liderazgo'],
                                        'level' => $this->getDimensionRiskLevel('liderazgo', $dimensions['liderazgo'])
                                    ]
                                ]
                            ],
                            'work_relations' => [
                                'name' => 'Relaciones en el trabajo',
                                'score' => $dimensions['relaciones_sociales'] + $dimensions['relacion_colaboradores'],
                                'level' => $this->getDomainRiskLevel('work_relations', $dimensions['relaciones_sociales'] + $dimensions['relacion_colaboradores']),
                                'dimensions' => [
                                    [
                                        'name' => 'Relaciones sociales en el trabajo',
                                        'score' => $dimensions['relaciones_sociales'],
                                        'level' => $this->getDimensionRiskLevel('relaciones_sociales', $dimensions['relaciones_sociales'])
                                    ],
                                    [
                                        'name' => 'Deficiente relación con los colaboradores que supervisa',
                                        'score' => $dimensions['relacion_colaboradores'],
                                        'level' => $this->getDimensionRiskLevel('relacion_colaboradores', $dimensions['relacion_colaboradores'])
                                    ]
                                ]
                            ],
                            'violence' => [
                                'name' => 'Violencia',
                                'score' => $dimensions['violencia_laboral'],
                                'level' => $this->getDomainRiskLevel('violence', $dimensions['violencia_laboral']),
                                'dimensions' => [
                                    [
                                        'name' => 'Violencia laboral',
                                        'score' => $dimensions['violencia_laboral'],
                                        'level' => $this->getDimensionRiskLevel('violencia_laboral', $dimensions['violencia_laboral'])
                                    ]
                                ]
                            ]
                        ]
                    ]
                ];

                return [
                    'users' => $user,
                    'user_id' => $userId,
                    'empresa' => auth()->user()->sede->name,
                    'nombre' => $user->name . ' ' . $user->first_name . ' ' . $user->last_name,
                    'fecha' => \Carbon\Carbon::now()->locale('es')->isoFormat('D [de] MMMM, YYYY'),
                    'fecha_aplicacion' => $items->first()->created_at->locale('es')->isoFormat('D [de] MMMM, YYYY'),
                    'puesto' => $user->position->name ?? 'No definido',
                    'responses' => $responses,
                    'categories' => $categoriesWithLevels,
                    'domains' => $domainsWithLevels,
                    'dimensions' => $dimensionsWithLevels,
                    'total_score' => array_sum($responses),
                    'risk_level' => $this->getTotalRiskLevel(array_sum($responses)), // Placeholder, puedes calcularlo si es necesario
                    'recommendation' => $recomendaciones[$this->getTotalRiskLevel(array_sum($responses))] ?? 'No se encontró recomendación para este nivel de riesgo.',
                    'structure' => $structure,
                ];
            })->toArray();
        // Renderizar la vista con los datos

        $html = view('filament.pages.nom35.risk_factor_individual_report', [
            'users' => $users,
        ])->render();


        // Forzar codificación UTF-8
        $html = mb_convert_encoding($html, 'UTF-8', 'UTF-8');

        $payload = [
            'source'    => $html,
            'landscape' => false,
            'use_print' => false,
            'margin'    => [
                'top'    => 10,
                'bottom' => 10,
                'left'   => 10,
                'right'  => 10,
            ],
        ];

        $response = Http::withHeaders([
            'Content-Type' => 'application/json',
            'X-API-Key'    => config('services.pdfshift.api_key'),
        ])
            ->withBody(json_encode($payload, JSON_UNESCAPED_UNICODE), 'application/json')
            ->post('https://api.pdfshift.io/v3/convert/pdf');

        if ($response->successful()) {
            $pdfContent = $response->body();
            return response()->streamDownload(function () use ($pdfContent) {
                echo $pdfContent;
            },'ReporteIndividual.pdf');
        } else {
            Notification::make()
                ->title('Error al generar PDF')
                ->body('No se pudo generar el PDF: ' . $response->body())
                ->danger()
                ->send();
        }
    }

// Método auxiliar para determinar el nivel de riesgo de las dimensiones
    private function getDimensionRiskLevel($dimension, $score)
    {
        $thresholds = [
            'condiciones_peligrosas' => [0, 2, 4, 6],
            'condiciones_deficientes' => [0, 2, 4, 6],
            'trabajos_peligrosos' => [0, 1, 2, 3],
            'cargas_cuantitativas' => [0, 2, 4, 6],
            'ritmos_acelerados' => [0, 2, 4, 6],
            'carga_mental' => [0, 3, 6, 9],
            'cargas_psicologicas' => [0, 3, 6, 9],
            'alta_responsabilidad' => [0, 2, 4, 6],
            'cargas_contradictorias' => [0, 2, 4, 6],
            'falta_control' => [0, 3, 6, 9],
            'posibilidad_desarrollo' => [0, 2, 4, 6],
            'capacitacion' => [0, 2, 4, 6],
            'jornadas_extensas' => [0, 1, 2, 3],
            'influencia_fuera_trabajo' => [0, 1, 2, 3],
            'responsabilidades_familiares' => [0, 1, 2, 3],
            'claridad_funciones' => [0, 3, 6, 9],
            'liderazgo' => [0, 2, 4, 6],
            'relaciones_sociales' => [0, 3, 6, 9],
            'relacion_colaboradores' => [0, 3, 6, 9],
            'violencia_laboral' => [0, 7, 14, 21],
        ];

        $levels = ['Nulo', 'Bajo', 'Medio', 'Alto', 'Muy alto'];
        $dimensionThresholds = $thresholds[$dimension] ?? [0, 1, 2, 3];

        // Verificar cada nivel en orden
        if ($score < $dimensionThresholds[1]) return $levels[0];
        if ($score < $dimensionThresholds[2]) return $levels[1];
        if ($score < $dimensionThresholds[3]) return $levels[2];
        if ($score >= $dimensionThresholds[3]) return $levels[4]; // Muy alto

        return $levels[3]; // Alto como fallback
    }
    private function getDomainRiskLevel($domain, $score)
    {
        $thresholds = [
            'conditions' => [3, 5, 7, 9],
            'work_activity' => [12, 16, 20, 24],
            'work_control' => [5, 8, 11, 14],
            'work_journey' => [1, 2, 4, 6],
            'work_family' => [1, 2, 4, 6],
            'leadership' => [3, 5, 8, 11],
            'work_relations' => [5, 8, 11, 14],
            'violence' => [7, 10, 13, 16],
        ];

        $levels = ['Nulo', 'Bajo', 'Medio', 'Alto', 'Muy alto'];
        $domainThresholds = $thresholds[$domain] ?? [1, 2, 3, 4];

        if ($score < $domainThresholds[0]) return $levels[0];
        if ($score >= $domainThresholds[0] && $score < $domainThresholds[1]) return $levels[1];
        if ($score >= $domainThresholds[1] && $score < $domainThresholds[2]) return $levels[2];
        if ($score >= $domainThresholds[2] && $score < $domainThresholds[3]) return $levels[3];

        return $levels[4];
    }

    private function getCategoryRiskLevel($category, $score)
    {

        $thresholds = [
            'ambiente' => [3, 5, 7, 9],
            'activity' => [10, 20, 30, 40],
            'time' => [4, 6, 9, 12],
            'leadership' => [10, 18, 28, 38],
        ];

        $levels = ['Nulo o despreciable', 'Bajo', 'Medio', 'Alto', 'Muy alto'];
        $categoryThresholds = $thresholds[$category] ?? [1, 2, 3, 4];

        if ($score < $categoryThresholds[0]) return $levels[0];
        if ($score >= $categoryThresholds[0] && $score < $categoryThresholds[1]) return $levels[1];
        if ($score >= $categoryThresholds[1] && $score < $categoryThresholds[2]) return $levels[2];
        if ($score >= $categoryThresholds[2] && $score < $categoryThresholds[3]) return $levels[3];

        return $levels[4];
    }
    private function getTotalRiskLevel($score)
    {
        if ($score < 20) {
            return 'Nulo';
        } elseif ($score >= 20 && $score < 45) {
            return 'Bajo';
        } elseif ($score >= 45 && $score < 70) {
            return 'Medio';
        } elseif ($score >= 70 && $score < 90) {
            return 'Alto';
        } elseif ($score >= 90) {
            return 'Muy alto';
        }

        return 'N/A';
    }

    public function reportCoverGII()
    {
        $recomendaciones = [
            'Muy Alto' =>'Se requiere realizar el análisis de cada categoría y dominio para establecer las acciones de intervención apropiadas, mediante un Programa de intervención que deberá incluir evaluaciones específicas1, y contemplar campañas de sensibilización, revisar la política de prevención de riesgos psicosociales y programas para la prevención de los factores de riesgo psicosocial, la promoción de un entorno organizacional favorable y la prevención de la violencia laboral, así como reforzar su aplicación y difusión.',
            'Alto' => 'Se requiere realizar un análisis de cada categoría y dominio, de manera que se puedan determinar las acciones de intervención apropiadas a través de un Programa de intervención, que podrá incluir una evaluación específica y deberá incluir una campaña de sensibilización, revisar la política de prevención de riesgos psicosociales y programas para la prevención de los factores de riesgo psicosocial, la promoción de un entorno organizacional favorable y la prevención de la violencia laboral, así como reforzar su aplicación y difusión.',
            'Medio' => 'Se requiere revisar la política de prevención de riesgos psicosociales y programas para la prevención de los factores de riesgo psicosocial, la promoción de un entorno organizacional favorable y la prevención de la violencia laboral, así como reforzar su aplicación y difusión, mediante un Programa de intervención.',
            'Bajo' => 'Es necesario una mayor difusión de la política de prevención de riesgos psicosociales y programas para: la prevención de los factores de riesgo psicosocial, la promoción de un entorno organizacional favorable y la prevención de la violencia laboral. ',
            'Nulo' => 'El riesgo resulta despreciable por lo que no se requiere medidas adicionales.'
        ];

        //Quiero obtener el promedio de las respuestas de la guía II por categoría
        $categories = [
            'ambiente' => [
                'name' => 'Ambiente de trabajo',
                'result' => $this->coverAmbientResponses->avg(),
                'risk_level' => $this->getCategoryRiskLevel('ambiente', $this->coverAmbientResponses->avg()),
            ],
            'activity' => [
                'name' => 'Factores propios de la actividad',
                'result' => $this->coverActivityResponses->avg(),
                'risk_level' => $this->getCategoryRiskLevel('activity', $this->coverActivityResponses->avg()),
            ],
            'time' => [
                'name' => 'Organización del tiempo de trabajo',
                'result' => $this->coverTimeResponses->avg(),
                'risk_level' => $this->getCategoryRiskLevel('time', $this->coverTimeResponses->avg()),
            ],
            'leadership' => [
                'name' => 'Liderazgo y relaciones en el trabajo',
                'result' => $this->coverLeadershipResponses->avg(),
                'risk_level' => $this->getCategoryRiskLevel('leadership', $this->coverLeadershipResponses->avg()),
            ],
        ];
        $domains = [
            'conditions' => [
                'name' => 'Condiciones en el ambiente de trabajo',
                'result' => $this->coverConditionResponses->avg(),
                'risk_level' => $this->getDomainRiskLevel('conditions', $this->coverConditionResponses->avg()),
            ],
            'work_activity' => [
                'name' => 'Carga de trabajo',
                'result' => $this->coverWorkActivityResponses->avg(),
                'risk_level' => $this->getDomainRiskLevel('work_activity', $this->coverWorkActivityResponses->avg()),
            ],
            'work_control' => [
                'name' => 'Falta de control sobre el trabajo',
                'result' => $this->coverWorkControlResponses->avg(),
                'risk_level' => $this->getDomainRiskLevel('work_control', $this->coverWorkControlResponses->avg()),
            ],
            'work_journey' => [
                'name' => 'Jornada de trabajo',
                'result' => $this->coverWorkJourneyResponses->avg(),
                'risk_level' => $this->getDomainRiskLevel('work_journey', $this->coverWorkJourneyResponses->avg()),
            ],
            'work_family' => [
                'name' => 'Interferencia en la relación trabajo-familia',
                'result' => $this->coverWordAndFamilyResponses->avg(),
                'risk_level' => $this->getDomainRiskLevel('work_family', $this->coverWordAndFamilyResponses->avg()),
            ],
            'leadership' => [
                'name' => 'Liderazgo',
                'result' => $this->coverDomainLeadershipResponses->avg(),
                'risk_level' => $this->getDomainRiskLevel('leadership', $this->coverDomainLeadershipResponses->avg()),
            ],
            'work_relations' => [
                'name' => 'Relaciones en el trabajo',
                'result' => $this->coverWorkRelationsResponses->avg(),
                'risk_level' => $this->getDomainRiskLevel('work_relations', $this->coverWorkRelationsResponses->avg()),
            ],
            'violence' => [
                'name' => 'Violencia laboral',
                'result' => $this->coverViolenceResponses->avg(),
                'risk_level' => $this->getDomainRiskLevel('violence', $this->coverViolenceResponses->avg()),
            ],
        ];



        $html=view('filament.pages.nom35.risk_factor_report_cover', [
            'company' => auth()->user()->sede->name ?? 'No definido', //OK
            'reportDate' => \Carbon\Carbon::now()->locale('es')->isoFormat('D [de] MMMM, YYYY'),
            'period' => $this->norma->start_date->locale('es')->isoFormat('D [de] MMMM, YYYY') . ' al ' . \Carbon\Carbon::now()->locale('es')->isoFormat('D [de] MMMM, YYYY'),
            'responsesTotalG2' => $this->responsesTotalG2,
            'generalResults' => $this->generalResults,
            'calificacionG2' => $this->calificacion,
            'resultCuestionario' => $this->resultCuestionario,
            'categories'=>$categories,
            'domains'=> $domains,
            //'recommendations' =>$recomendaciones[$this->resultCuestionario==='Muy Alto'?'Muy-Alto':$this->resultCuestionario],
        ])->render();
        // Forzar codificación UTF-8
        $html = mb_convert_encoding($html, 'UTF-8', 'UTF-8');
        $payload = [
            'source'    => $html,
            'landscape' => false,
            'use_print' => false,
            'margin'    => [
                'top'    => 10,
                'bottom' => 10,
                'left'   => 10,
                'right'  => 10,
            ],
        ];
        $response = Http::withHeaders([
            'Content-Type' => 'application/json',
            'X-API-Key'    => config('services.pdfshift.api_key'),
        ])
            ->withBody(json_encode($payload, JSON_UNESCAPED_UNICODE), 'application/json')
            ->post('https://api.pdfshift.io/v3/convert/pdf');
        if ($response->successful()) {
            $pdfContent = $response->body();
            return response()->streamDownload(function () use ($pdfContent) {
                echo $pdfContent;
            },'Caratula.pdf');
        } else {
            Notification::make()
                ->title('Error al generar PDF')
                ->body('No se pudo generar el PDF: ' . $response->body())
                ->danger()
                ->send();
        }
    }
    public function downloadNorma(){
        return response()->download(storage_path('app/documents/NORMA_Oficial_Mexicana_NOM-035-STPS-2018.pdf'),'NORMA_Oficial_Mexicana_NOM-035-STPS-2018.pdf');
    }




}

