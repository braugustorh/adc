<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Enums\TraumaticEventType;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class TraumaticEvent extends Model
{
    protected $fillable = [
        'user_id',         // Colaborador relacionado
        'identified_id', // Relación con IdentifiedCollaborator
        'event_type',                // Enum del tipo de evento
        'description',               // Descripción del evento
        'date_occurred'             // Fecha en que ocurrió el evento
    ];

    protected $casts = [
        'date_occurred' => 'datetime',
        'event_type' => TraumaticEventType::class,
    ];

    /**
     * Obtener el colaborador relacionado con este evento
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * Obtener la identificación relacionada
     */
    public function identifiedCollaborator(): BelongsTo
    {
        return $this->belongsTo(IdentifiedCollaborator::class, 'identified_id');
    }
}

