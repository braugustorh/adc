<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class EvaluationUserAnswer extends Model
{
    use HasFactory;

    // Definimos la tabla explícitamente para evitar problemas de pluralización
    protected $table = 'evaluation_user_answers';

    protected $fillable = [
        'psychometric_evaluation_id',
        'question_id',
        'answer_id',
        'attribute', // Aquí guardamos MOST/LEAST del Cleaver
        'text_value'
    ];

    /**
     * Relación: Esta respuesta pertenece a UNA evaluación específica (la de Braulio)
     */
    public function psychometricEvaluation(): BelongsTo
    {
        return $this->belongsTo(PsychometricEvaluation::class, 'psychometric_evaluation_id');
    }

    /**
     * Relación: Esta respuesta corresponde a UNA pregunta
     */
    public function question(): BelongsTo
    {
        return $this->belongsTo(Question::class, 'question_id');
    }

    /**
     * Relación: Esta es la opción que eligió (A, B, C...)
     */
    public function answer(): BelongsTo
    {
        return $this->belongsTo(Answers::class, 'answer_id');
    }
}
