<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EvaluationsTypes extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'status'
    ];
    public function competences()
    {
        return $this->hasMany(Competence::class);
    }

    public function questions()
    {
        return $this->hasMany(Question::class, 'evaluations_type_id');
    }

    public function campaigns()
    {
        return $this->belongsToMany(Campaign::class, 'campaign_evaluation');
    }
    public function evaluationAssign()
    {
        return $this->hasMany(EvaluationAssign::class, 'evaluation_id');
    }
    // Agregar esta relación
    public function psychometricEvaluations()
    {
        return $this->hasMany(PsychometricEvaluation::class, 'evaluations_type_id');
    }

}
