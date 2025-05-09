<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\OneToOneEvaluation;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CultureTopic extends Model
{
    protected $fillable = [
        'one_to_one_evaluation_id',
        'theme',
        'comments',
        'commitments',
        'scheduled_date',
        'progress',
    ];

    // Relación con la evaluación
    public function evaluation(): BelongsTo
    {
        return $this->belongsTo(OneToOneEvaluation::class, 'one_to_one_evaluation_id');
    }
}
