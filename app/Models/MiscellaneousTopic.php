<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Models\OneToOneEvaluation;

class MiscellaneousTopic extends Model
{
    protected $fillable = [
        'one_to_one_evaluation_id',
        'who_says',
        'topic',
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
