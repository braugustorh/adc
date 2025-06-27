<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class TraumaticEventSurvey extends Model
{
    protected $fillable=[
        'sede_id',
        'user_id',           // Colaborador identificado
        'norma_id',          // Proceso NOM-035 relacionado
        'question_id',      // ID del reactivo respondido
        'response',         // Respuesta del colaborador
        'status',          // Estado de la respuesta (1 activo, 0 inactivo)
    ];
    protected $casts = [
        'response' => 'string',
        'status' => 'boolean',
    ];
    /**
     * Relación con la sede
     */
    public function sede(): BelongsTo
    {
        return $this->belongsTo(Sede::class, 'sede_id');
    }
    /**
     * Relación con el usuario
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }
    /**
     * Relación con el proceso NOM-035
     */
    public function norma(): BelongsTo
    {
        return $this->belongsTo(Nom035Process::class, 'norma_id');
    }
    /**
     * Relación con el reactivo respondido
     */
    public function question(): BelongsTo
    {
        return $this->belongsTo(Question::class, 'question_id');
    }
}
