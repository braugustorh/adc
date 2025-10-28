<?php

namespace App\Filament\Pages;

use App\Models\PsychometricEvaluation;
use App\Models\User;
use App\Models\Candidate;
use App\Models\EvaluationsTypes;
use Filament\Pages\Page;
use Filament\Forms;
use Filament\Actions\Action;
use Filament\Notifications\Notification;

class PsychometricDashboard extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-chart-bar';
    protected static string $view = 'filament.pages.psychometric-dashboard';
    protected static ?string $title = 'Dashboard de Psicometrías';
    protected static ?string $navigationLabel = 'Dashboard Psicometrías';
    protected static ?int $navigationSort = 3;

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

    public function getHeaderActions(): array
    {
        return [
            Action::make('assign_evaluation')
                ->label('Asignar Evaluación')
                ->icon('heroicon-o-plus')
                ->color('gray')
                ->form([
                    Forms\Components\Select::make('users')
                        ->label('Seleccionar Colaboradores')
                        ->multiple()
                        ->options(User::pluck('name', 'id')->toArray())
                        ->searchable(),

                    Forms\Components\Select::make('evaluation_type')
                        ->label('Tipo de Evaluación')
                        ->options(EvaluationsTypes::pluck('name', 'id')->toArray())
                        ->required(),

                    Forms\Components\DateTimePicker::make('expires_at')
                        ->label('Fecha Límite')
                        ->required(),

                    Forms\Components\Textarea::make('instructions')
                        ->label('Instrucciones Adicionales')
                        ->rows(3),
                ])
                ->action(function (array $data) {
                    foreach ($data['users'] as $userId) {
                        PsychometricEvaluation::create([
                            'evaluations_type_id' => $data['evaluation_type'],
                            'evaluable_id' => $userId,
                            'evaluable_type' => User::class,
                            'assigned_by' => auth()->id(),
                            'assigned_at' => now(),
                            'expires_at' => $data['expires_at'],
                            'instructions' => $data['instructions'],
                            'status' => 'assigned',
                        ]);
                    }

                    Notification::make()
                        ->title('Evaluaciones asignadas correctamente')
                        ->success()
                        ->send();
                }),

            Action::make('evaluate_candidate')
                ->label('Evaluar Candidato')
                ->icon('heroicon-o-user')
                ->color('primary')
                ->form([
                    Forms\Components\TextInput::make('name')
                        ->label('Nombre del Candidato')
                        ->required(),

                    Forms\Components\TextInput::make('email')
                        ->label('Email')
                        ->email()
                        ->required(),

                    Forms\Components\TextInput::make('position_applied')
                        ->label('Puesto a Evaluar')
                        ->required(),

                    Forms\Components\Select::make('evaluation_type')
                        ->label('Tipo de Evaluación')
                        ->options(EvaluationsTypes::pluck('name', 'id')->toArray())
                        ->required(),

                    Forms\Components\DateTimePicker::make('expires_at')
                        ->label('Fecha Límite')
                        ->required(),
                ])
                ->action(function (array $data) {
                    $candidate = Candidate::create([
                        'name' => $data['name'],
                        'email' => $data['email'],
                        'position_applied' => $data['position_applied'],
                    ]);

                    PsychometricEvaluation::create([
                        'evaluations_type_id' => $data['evaluation_type'],
                        'evaluable_id' => $candidate->id,
                        'evaluable_type' => Candidate::class,
                        'assigned_by' => auth()->id(),
                        'assigned_at' => now(),
                        'expires_at' => $data['expires_at'],
                        'status' => 'assigned',
                    ]);

                    Notification::make()
                        ->title('Candidato creado y evaluación asignada')
                        ->success()
                        ->send();
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
        }])->get()->map(function($type) {
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
}
