<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Models\OneToOneEvaluation;

class DevelopmentPlan extends Model
{
    protected $fillable = [
        'one_to_one_evaluation_id',
        'strengths',
        'opportunities',
        'development_area',
        'progress',
        'scheduled_date',
        'learning_type',
    ];

    // Relación con la evaluación
    public function evaluation(): BelongsTo
    {
        return $this->belongsTo(OneToOneEvaluation::class, 'one_to_one_evaluation_id');
    }
}
