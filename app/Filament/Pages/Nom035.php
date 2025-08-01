<?php

namespace App\Filament\Pages;

use App\Models\ActiveSurvey;
use App\Models\Evaluation;
use App\Models\EvaluationsTypes;
use App\Models\IdentifiedCollaborator;
use App\Models\Nom035Process;
use App\Models\RiskFactorSurvey;
use App\Models\TraumaticEvent;
use App\Models\TraumaticEventSurvey;
use App\Models\User;
use Filament\Notifications\Notification;
use Filament\Pages\Page;
use Illuminate\Events\Dispatcher;
use PhpOffice\PhpWord\TemplateProcessor;



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
        if($this->norma !== null){
            // Si ya existe un proceso activo, redirigir al panel
            $activeSurvey = ActiveSurvey::where('norma_id', $this->norma->id)->get();
/*
            $guideTypes = EvaluationsTypes::where('name', 'like', 'Nom035: Guía %')
                ->pluck('id', 'name');

            $this->colabResponsesG1= TraumaticEventSurvey::where('norma_id', $this->norma->id)
                ->distinct('user_id')
                ->count();

            $this->activeGuideI = $activeSurvey->contains('evaluations_type_id', $guideTypes['Nom035: Guía I'] ?? 0);
            $this->activeGuideII = $activeSurvey->contains('evaluations_type_id', $guideTypes['Nom035: Guía II'] ?? 0);
            $this->activeGuideIII = $activeSurvey->contains('evaluations_type_id', $guideTypes['Nom035: Guía III'] ?? 0);
           */
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
            $this->calificacion=RiskFactorSurvey::where('norma_id', $this->norma->id)->sum('equivalence_response')??null;
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


        $this->dispatch('open-modal', id: 'modal-result');
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
            return;

        }

    }
    public function openTypeTest(){
        $this->muestraGuideIII= $this->calculateSampleSize(131);

        $this->dispatch('open-modal', id: 'type-test-modal');
    }
    public function closeTypeTest()
    {
        $this->dispatch('close-modal', id: 'type-test-modal');
    }

    public function descargarWord()
    {
        $templatePath = storage_path('app/plantillas/Política_de_riesgos.docx'); // Mueve el archivo ahí
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



}

