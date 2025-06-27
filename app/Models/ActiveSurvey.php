<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ActiveSurvey extends Model
{
    protected $fillable=[
        'norma_id', // Relación con Nom035Process
        'evaluations_type_id', // Relación con Survey
        'some_users', // No indica si solo algunos usuarios deben responder false o true
    ];
    protected $casts = [
        'some_users' => 'boolean',
    ];

    public function nom035Process():BelongsTo
    {
        return $this->belongsTo(Nom035Process::class, 'norma_id');
    }
    public function evaluation():BelongsTo
    {
        return $this->belongsTo(EvaluationsTypes::class, 'evaluations_type_id');
    }

}
