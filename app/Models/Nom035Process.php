<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Nom035Process extends Model
{
    protected $table = 'nom_035_processes';

    // Campos que se pueden llenar masivamente
    protected $fillable = [
        'sede_id', // Relación con Sede
        'hr_manager_id', // Relación con User (Gerente de Recursos Humanos)
        'start_date', // Fecha de inicio del proceso
        'status', // Estado del proceso (ej. 'active', 'completed', etc.)
        'policy_document', // Documento de política relacionado
        'total_employees', // Total de empleados en la sede
        'survey_applicable', // Indica si es obligatorio la encuesta es aplicable
    ];

    // Campos que se convierten automáticamente a tipos nativos
    protected $casts = [
        'start_date' => 'datetime',
        'survey_applicable' => 'boolean',
        'status' => 'string', // Podría usarse un Enum en PHP 8.1+ si prefieres
    ];
    public function sede(): BelongsTo
    {
        return $this->belongsTo(Sede::class, 'sede_id');
    }
    public function hrManager(): BelongsTo
    {
        return $this->belongsTo(User::class, 'hr_manager_id');
    }
    public function identifiedCollaborators()
    {
        return $this->hasMany(IdentifiedCollaborator::class, 'norma_id');
    }

    /**
     * Obtener el número de colaboradores identificados
     */
    public function identifiedCollaboratorsCount(): int
    {
        return $this->hasMany(IdentifiedCollaborator::class, 'norma_id')
            ->where('sede_id', $this->sede_id)
            ->count();
    }
    public function activeSurvey():HasMany
    {
        return $this->hasMany(ActiveSurvey::class, 'norma_id')
            ->where('status', 'active');
    }
    public static function findActiveProcess($sede_id): ?self
    {
        return self::where('sede_id', $sede_id)
            ->whereIn('status', ['iniciado','en_progreso'])
            ->first();
    }
}
