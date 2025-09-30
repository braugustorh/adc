<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphMany;

class Candidate extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'email',
        'phone',
        'position_applied',
        'notes',
        'status',
    ];

    public function psychometricEvaluations(): MorphMany
    {
        return $this->morphMany(PsychometricEvaluation::class, 'evaluable');
    }
}
