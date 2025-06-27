<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class IdentifiedCollaborator extends Model
{
    protected $fillable = [
        'sede_id',
        'user_id',           // Colaborador identificado
        'norma_id',          // Proceso NOM-035 relacionado
        'type_identification', // Tipo de identificación (manual, encuesta, etc.)
        'identified_by',     // Usuario que identificó
        'identified_at',     // Fecha de identificación
    ];

    protected $casts = [
        'identified_at' => 'datetime',
    ];

    /**
     * Obtener el colaborador identificado
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * Obtener la sede
     */
    public function sede(): BelongsTo
    {
        return $this->belongsTo(Sede::class, 'sede_id');
    }

    /**
     * Obtener el usuario que identificó
     */
    public function identifiedByUser(): BelongsTo
    {
        return $this->belongsTo(User::class, 'identified_by');
    }

    /**
     * Obtener el proceso NOM-035 relacionado
     */
    public function norma(): BelongsTo
    {
        return $this->belongsTo(Nom035Process::class, 'norma_id');
    }

    /**
     * Obtener el evento traumático relacionado con esta identificación
     */
    public function traumaticEvent(): HasOne
    {
        return $this->hasOne(TraumaticEvent::class, 'identified_id');
    }
}

