<?php

namespace App\Filament\Pages;

use App\Mail\EvaluationAssignedMail;
use App\Models\PsychometricEvaluation;
use App\Models\User;
use App\Models\Candidate;
use App\Models\EvaluationsTypes;
use Filament\Actions\Action;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput; // Si necesitas crear el candidato al vuelo
use Filament\Notifications\Notification;
use Illuminate\Support\Str;
use Filament\Pages\Page;
use Filament\Forms;
use Illuminate\Support\Facades\DB;
use App\Services\PsychometricScoringService; // <--- IMPORTANTE
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Tables\Contracts\HasTable;
use Illuminate\Support\Facades\Http;

class PsychometricDashboard extends Page implements HasTable
{
    use InteractsWithTable;
    protected static ?string $navigationIcon = 'heroicon-o-chart-bar';
    protected static string $view = 'filament.pages.psychometric-dashboard';
    protected static ?string $title = 'Dashboard de Psicometrías';
    protected static ?string $navigationLabel = 'Dashboard Psicometrías';
    protected static ?int $navigationSort = 3;

    // Mapeo de puestos a IDs de evaluaciones
    // 9=WES, 10=Moss, 11=Cleaver, 12=Kostick
    const PUESTO_EVALUACIONES = [
        'Directivo'    => [10, 11, 12, 9],
        'Mando Medio'  => [11, 12, 10, 9],
        'Supervisor'   => [11, 12, 9],
        'Administrativo' => [12, 11, 9],
    ];

    // Propiedades para filtros
    public $statusFilter = '';
    public $typeFilter = '';
    public $evaluableTypeFilter = '';

    //Poner función para que solo sea visible para RH Corp
    public static function canView(): bool
    {
        return \auth()->user()->hasAnyRole(['Administrador','RH Corp','RH']);

    }
    public static function shouldRegisterNavigation(): bool
    {
        // Esto controla la visibilidad en la navegación.
        return static::canView();

    }
    // --- AQUÍ CONSTRUIMOS LA TABLA ---
    public function table(Table $table): Table
    {
        return $table
            ->query(
                PsychometricEvaluation::query()->with(['evaluable', 'evaluationType'])
                    ->latest('created_at')
            )
            ->columns([
                Tables\Columns\TextColumn::make('evaluable.name')
                    ->label('Evaluado')
                    ->searchable()
                    ->sortable()
                    // Agrega el subtítulo (Candidato vs Colaborador)
                    ->description(fn (PsychometricEvaluation $record): string =>
                    $record->evaluable_type === \App\Models\User::class ? 'Colaborador Interno' : 'Candidato Externo'
                    )
                    // Pone un ícono distintivo
                    ->icon(fn (PsychometricEvaluation $record): string =>
                    $record->evaluable_type === \App\Models\User::class ? 'heroicon-m-identification' : 'heroicon-m-user-circle'
                    )
                    // Le da color ÚNICAMENTE al ícono (dejando el texto en color por defecto)
                    ->iconColor(fn (PsychometricEvaluation $record): string =>
                    $record->evaluable_type === \App\Models\User::class ? 'info' : 'success'
                    ),

                Tables\Columns\TextColumn::make('evaluationType.name')
                    ->label('Prueba')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'Moss' => 'success',
                        'Cleaver' => 'warning',
                        'Kostick' => 'info',
                        default => 'gray',
                    }),

                Tables\Columns\TextColumn::make('status')
                    ->label('Estado')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'completed' => 'success',
                        'assigned' => 'warning',
                        'started' => 'info',
                        default => 'gray',
                    }),

                Tables\Columns\TextColumn::make('puesto')
                    ->label('Puesto')
                    ->badge()
                    ->color(fn (?string $state): string => match ($state) {
                        'Directivo'      => 'danger',
                        'Mando Medio'    => 'warning',
                        'Supervisor'     => 'info',
                        'Administrativo' => 'success',
                        default          => 'gray',
                    })
                    ->placeholder('—'),

                Tables\Columns\TextColumn::make('updated_at')
                    ->label('Fecha')
                    ->date()
                    ->sortable(),
            ])
            ->filters([
                // Filtro por Estado
                Tables\Filters\SelectFilter::make('status')
                    ->options([
                        'assigned' => 'Asignada',
                        'started' => 'Iniciada',
                        'completed' => 'Completada',
                    ]),
                // Filtro por Tipo
                Tables\Filters\SelectFilter::make('evaluations_type_id')
                    ->label('Tipo de Prueba')
                    ->relationship('evaluationType', 'name'),
            ])
            ->actions([
                // ACCIÓN 1: VER RESULTADOS (MODAL)
                Tables\Actions\ViewAction::make('results')
                    ->label('Resultados')
                    ->icon('heroicon-o-eye')
                    ->color('info')
                    // Solo visible si está completada
                    ->visible(fn (PsychometricEvaluation $record) => $record->status === 'completed')
                    ->modalHeading('Resultados de Evaluación')
                    ->modalSubmitAction(false) // Ocultar botón "Guardar"
                    ->modalContent(function (PsychometricEvaluation $record) {
                        // AQUÍ LLAMAMOS A TU CEREBRO
                        $service = new PsychometricScoringService();
                        $results = $service->calculate($record);

                        // Retornamos la vista parcial que creamos en el Paso 1
                        return view('filament.pages.partials.results-modal', [
                            'results' => $results
                        ]);
                    }),

                // ACCIÓN 2: DESCARGAR PDF (Placeholder por ahora)
                Tables\Actions\Action::make('pdf')
                    ->label('PDF')
                    ->icon('heroicon-o-document-arrow-down')
                    ->color('success')
                    ->visible(fn (PsychometricEvaluation $record) => $record->status === 'completed')
                    ->action(fn (PsychometricEvaluation $record) => $this->downloadPdf($record))
                    ->openUrlInNewTab(),
            ]);
    }

    public function getHeaderActions(): array
    {
        return [
            // ---------------------------------------------------------------
            // ACCIÓN: Asignar a Colaboradores (Internos)
            // ---------------------------------------------------------------
            Action::make('assign_internal')
                ->label('Asignar a Colaborador')
                ->icon('heroicon-o-identification')
                ->color('primary')
                ->form([
                    // 1. Selector de Sede (Visible y editable solo para Admin/RH Corp)
                    Forms\Components\Select::make('sede_id')
                        ->label('Sede')
                        ->options(\App\Models\Sede::pluck('name', 'id'))
                        ->searchable()
                        ->preload()
                        ->live()
                        ->visible(fn () => auth()->user()->hasAnyRole(['Administrador', 'RH Corp']))
                        ->required(fn () => auth()->user()->hasAnyRole(['Administrador', 'RH Corp'])),

                    // 2. Selector de Colaborador (Dependiente de la sede)
                    Forms\Components\Select::make('user_id')
                        ->label('Colaborador')
                        ->options(function (Forms\Get $get) {
                            if (auth()->user()->hasAnyRole(['Administrador', 'RH Corp'])) {
                                $sedeId = $get('sede_id');
                            } else {
                                $sedeId = auth()->user()->sede_id;
                            }
                            if (! $sedeId) return [];
                            return \App\Models\User::where('sede_id', $sedeId)->pluck('name', 'id');
                        })
                        ->searchable()
                        ->required()
                        ->loadingMessage('Cargando colaboradores...'),

                    // 3. Puesto
                    Forms\Components\Select::make('puesto')
                        ->label('Puesto / Nivel')
                        ->options([
                            'Directivo'      => 'Directivo',
                            'Mando Medio'    => 'Mando Medio (Gerencia / Jefatura)',
                            'Supervisor'     => 'Supervisor',
                            'Administrativo' => 'Administrativo',
                        ])
                        ->required()
                        ->live()
                        ->afterStateUpdated(function (Forms\Set $set, $state) {
                            $set('evaluation_type_ids', self::PUESTO_EVALUACIONES[$state] ?? []);
                        })
                        ->helperText('Al seleccionar el puesto se pre-cargan las evaluaciones correspondientes.'),

                    // 4. Selección de Evaluaciones (se pre-llena según puesto)
                    Select::make('evaluation_type_ids')
                        ->label('Batería de Evaluaciones')
                        ->options(EvaluationsTypes::whereIN('id', [9, 10, 11, 12])->pluck('name', 'id'))
                        ->multiple()
                        ->preload()
                        ->required()
                        ->helperText('Puedes ajustar manualmente las evaluaciones pre-cargadas.'),
                ])
                ->action(function (array $data) {
                    $user = User::find($data['user_id']);
                    $batchId = (string) Str::uuid();

                    foreach ($data['evaluation_type_ids'] as $typeId) {
                        PsychometricEvaluation::create([
                            'evaluations_type_id' => $typeId,
                            'evaluable_id'        => $user->id,
                            'evaluable_type'      => User::class,
                            'assigned_by'         => auth()->id(),
                            'batch_id'            => $batchId,
                            'puesto'              => $data['puesto'] ?? null,
                            'status'              => 'assigned',
                            'assigned_at'         => now(),
                        ]);
                    }

                    Notification::make()
                        ->title('Evaluaciones Asignadas')
                        ->body("La batería fue asignada correctamente a {$user->name}.")
                        ->success()
                        ->send();

                    Notification::make()
                        ->title('Nueva Evaluación Psicométrica')
                        ->body('Se te ha asignado una prueba. Por favor, revisa tu sección de Psicometría en el menú.')
                        ->icon('heroicon-o-clipboard-document-check')
                        ->success()
                        ->sendToDatabase($user);
                }),

            // ---------------------------------------------------------------
            // ACCIÓN 2: Asignar a Candidatos (Externos)
            // ---------------------------------------------------------------
            Action::make('evaluate_candidate')
                ->label('Asignar a Candidato')
                ->icon('heroicon-o-user-plus')
                ->color('success') // Color diferente para distinguir
                ->form([
                    // Seleccionar al Candidato (Candidate)
                    Select::make('candidate_id')
                        ->label('Candidato')
                        ->options(Candidate::all()->pluck('name', 'id'))
                        ->searchable()
                        ->required()
                        ->createOptionForm([
                            TextInput::make('name')->required()->label('Nombre Completo'),
                            TextInput::make('email')->email()->required()->unique('candidates','email')->label('Correo'),
                            TextInput::make('phone')->tel()->label('Teléfono'),
                        ])
                        ->createOptionUsing(function (array $data) {
                            return Candidate::create($data)->id;
                        }),

                    // Puesto
                    Forms\Components\Select::make('puesto')
                        ->label('Puesto / Nivel')
                        ->options([
                            'Directivo'      => 'Directivo',
                            'Mando Medio'    => 'Mando Medio (Gerencia / Jefatura)',
                            'Supervisor'     => 'Supervisor',
                            'Administrativo' => 'Administrativo',
                        ])
                        ->required()
                        ->live()
                        ->afterStateUpdated(function (Forms\Set $set, $state) {
                            $set('evaluation_type_ids', self::PUESTO_EVALUACIONES[$state] ?? []);
                        })
                        ->helperText('Al seleccionar el puesto se pre-cargan las evaluaciones correspondientes.'),

                    // Selección Múltiple de Exámenes (se pre-llena según puesto)
                    Select::make('evaluation_type_ids')
                        ->label('Batería de Evaluaciones')
                        ->options(EvaluationsTypes::whereIN('id', [9, 10, 11, 12])->pluck('name', 'id'))
                        ->multiple()
                        ->preload()
                        ->required()
                        ->helperText('El candidato recibirá un único enlace para todas estas pruebas.'),

                    Forms\Components\DatePicker::make('expires_at')
                        ->label('Fecha de Vencimiento')
                        ->helperText('Fecha límite para completar todas las evaluaciones')
                        ->required()
                        ->default(now()->addDays(14)),
                ])
                ->action(function (array $data) {
                    $this->createBatchEvaluations(
                        evaluableId: $data['candidate_id'],
                        evaluableType: Candidate::class,
                        evaluationTypeIds: $data['evaluation_type_ids'],
                        puesto: $data['puesto'] ?? null,
                    );
                }),

            Action::make('configuration')
                ->label('Configuración')
                ->icon('heroicon-o-cog-6-tooth')
                ->color('gray')
                ->form([
                    Forms\Components\Section::make('Configuración del Sistema')
                        ->schema([
                            Forms\Components\Toggle::make('auto_reminders')
                                ->label('Recordatorios Automáticos')
                                ->helperText('Enviar recordatorios automáticos antes del vencimiento'),

                            Forms\Components\TextInput::make('reminder_days')
                                ->label('Días antes del vencimiento para recordatorio')
                                ->numeric()
                                ->default(3)
                                ->minValue(1)
                                ->maxValue(30),

                            Forms\Components\Select::make('default_evaluation_duration')
                                ->label('Duración por defecto de evaluaciones')
                                ->options([
                                    7 => '7 días',
                                    14 => '14 días',
                                    21 => '21 días',
                                    30 => '30 días',
                                ])
                                ->default(14),

                            Forms\Components\Toggle::make('allow_candidate_self_register')
                                ->label('Permitir auto-registro de candidatos')
                                ->helperText('Los candidatos pueden registrarse usando un enlace público'),

                            Forms\Components\Textarea::make('default_instructions')
                                ->label('Instrucciones por defecto')
                                ->rows(3)
                                ->placeholder('Instrucciones que aparecerán por defecto en las evaluaciones...'),
                        ]),

                    Forms\Components\Section::make('Notificaciones')
                        ->schema([
                            Forms\Components\Toggle::make('email_notifications')
                                ->label('Notificaciones por Email')
                                ->default(true),

                            Forms\Components\Toggle::make('system_notifications')
                                ->label('Notificaciones del Sistema')
                                ->default(true),

                            Forms\Components\Select::make('notification_recipients')
                                ->label('Destinatarios de notificaciones')
                                ->multiple()
                                ->options(User::whereHas('roles', function($query) {
                                    $query->where('name', 'RH Corp'); // Si usas Spatie Permission
                                })->pluck('name', 'id')->toArray()),
                        ]),
                ])
                ->action(function (array $data) {
                    // Aquí guardarías la configuración en settings o config
                    Notification::make()
                        ->title('Configuración guardada correctamente')
                        ->success()
                        ->send();
                }),
        ];
    }

    public function getStats(): array
    {
        $totalUsers = User::count();
        $totalCandidates = Candidate::count();

        return [
            [
                'label' => 'Evaluaciones Activas',
                'value' => PsychometricEvaluation::whereIn('status', ['assigned', 'started', 'in_progress'])->count(),
                'description' => "{$totalUsers} Colaboradores | {$totalCandidates} Candidatos",
                'color' => 'primary',
            ],
            [
                'label' => 'Completadas Hoy',
                'value' => PsychometricEvaluation::where('status', 'completed')
                    ->whereDate('completed_at', today())->count(),
                'color' => 'success',
            ],
            [
                'label' => 'Pendientes',
                'value' => PsychometricEvaluation::where('status', 'assigned')->count(),
                'color' => 'warning',
            ],
            [
                'label' => 'Total Personas',
                'value' => $totalUsers + $totalCandidates,
                'color' => 'info',
            ],
        ];
    }

    public function getEvaluationTypes(): array
    {
        return EvaluationsTypes::withCount(['psychometricEvaluations' => function($query) {
            $query->whereIn('status', ['assigned', 'started', 'in_progress']);
        }])->whereIn('id',[9,10,11,12])
            ->get()->map(function($type) {
            return [
                'name' => $type->name,
                'count' => $type->psychometric_evaluations_count,
            ];
        })->toArray();
    }

    public function getFilteredEvaluations()
    {
        $query = PsychometricEvaluation::with(['evaluable', 'evaluationType'])
            ->whereIn('status', ['assigned', 'started', 'in_progress', 'completed'])
            ->latest();

        // Aplicar filtros
        if ($this->statusFilter) {
            $query->where('status', $this->statusFilter);
        }

        if ($this->typeFilter) {
            $query->where('evaluations_type_id', $this->typeFilter);
        }

        if ($this->evaluableTypeFilter) {

            $query->where('evaluable_type','like','%'.$this->evaluableTypeFilter.'%');
        }

        return $query->limit(15)->get();
    }

    public function applyStatusFilter($status)
    {
        $this->statusFilter = $this->statusFilter === $status ? '' : $status;
    }

    public function applyTypeFilter($type)
    {
        $this->evaluableTypeFilter = $this->evaluableTypeFilter === $type ? '' : $type;
    }

    public function clearFilters()
    {
        $this->statusFilter = '';
        $this->typeFilter = '';
        $this->evaluableTypeFilter = '';
    }
    public function mount(){
        //Mandar un erro 403 si no tiene el rol de RH Corp y Administrador
        if (!\auth()->user()?->hasAnyRole('RH Corp','Administrador','Super Administrador')) {
            abort(403, 'No tienes permiso para acceder a este recurso.');
        }
    }

    // -----------------------------------------------------------------------
// FUNCIÓN AUXILIAR (Para no repetir código)
// -----------------------------------------------------------------------
// Esta función encapsula la lógica "difícil" para que tus acciones queden limpias
    protected function createBatchEvaluations($evaluableId, $evaluableType, $evaluationTypeIds, $puesto = null)
    {
        $batchId = Str::uuid();
        $accessToken = Str::random(40);

        DB::transaction(function () use ($evaluableId, $evaluableType, $evaluationTypeIds, $batchId, $accessToken, $puesto) {
            foreach ($evaluationTypeIds as $typeId) {
                PsychometricEvaluation::create([
                    'evaluations_type_id' => $typeId,
                    'evaluable_id'        => $evaluableId,
                    'evaluable_type'      => $evaluableType,
                    'assigned_by'         => auth()->id(),
                    'batch_id'            => $batchId,
                    'access_token'        => $accessToken,
                    'puesto'              => $puesto,
                    'status'              => 'assigned',
                    'assigned_at'         => now(),
                ]);
            }
        });
        // 2. Recuperar al usuario/candidato para obtener su email y nombre
        $recipient = $evaluableType::find($evaluableId);

        // 3. ENVÍO DEL CORREO AL USUARIO
        if ($recipient && $recipient->email) {
            \Mail::to($recipient->email)->send(new EvaluationAssignedMail($recipient, $accessToken));

            $msg = 'Evaluaciones asignadas y correo enviado exitosamente.';
        } else {
            $msg = 'Evaluaciones creadas, pero no se pudo enviar el correo (sin email).';
        }
        Notification::make()
            ->title('Batería asignada correctamente')
            ->body( $msg) //
            ->success()
            ->send();

        // Aquí podrías llamar a tu Job de envío de correos
        // SendEvaluationLinkJob::dispatch($evaluableId, $evaluableType, $accessToken);
    }
    public function downloadPdf(PsychometricEvaluation $record)
    {
        // 1. Calculamos los resultados con tu cerebro psicométrico
        $service = new PsychometricScoringService();
        $results = $service->calculate($record);

        // 2. Preparamos los datos para la vista del PDF
        $candidateName = $record->evaluable->name ?? 'Candidato';
        $testName = $results['test_name'] ?? 'Evaluacion';
        $date = \Carbon\Carbon::parse($record->updated_at)->locale('es')->isoFormat('D [de] MMMM, YYYY');

        // 3. Renderizamos el HTML (Crearemos esta vista en el Paso 2)
        $html = view('pdf.psychometric_report', [
            'record' => $record,
            'results' => $results,
            'candidateName' => $candidateName,
            'date' => $date,
        ])->render();

        // 4. Forzar codificación UTF-8
        $html = mb_convert_encoding($html, 'UTF-8', 'UTF-8');

        // 5. Payload para PDFShift
        $payload = [
            'source'    => $html,
            'landscape' => false,
            'use_print' => true, // <-- Recomendado en true para que Tailwind aplique estilos de impresión
            'margin'    => [
                'top'    => '20px',
                'bottom' => '20px',
                'left'   => '15px',
                'right'  => '15px',
            ],
        ];

        // 6. Llamada a la API
        $response = Http::withHeaders([
            'Content-Type' => 'application/json',
            'X-API-Key'    => config('services.pdfshift.api_key'),
        ])
            ->withBody(json_encode($payload, JSON_UNESCAPED_UNICODE), 'application/json')
            ->post('https://api.pdfshift.io/v3/convert/pdf');

        // 7. Retorno / Descarga
        if ($response->successful()) {
            $pdfContent = $response->body();

            // Nombre del archivo dinámico
            $fileName = 'Reporte_' . Str::slug($testName) . '_' . Str::slug($candidateName) . '.pdf';

            return response()->streamDownload(function () use ($pdfContent) {
                echo $pdfContent;
            }, $fileName);

        } else {
            Notification::make()
                ->title('Error al generar PDF')
                ->body('No se pudo generar el PDF con PDFShift.')
                ->danger()
                ->send();
        }
    }

}
