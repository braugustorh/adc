<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ExitSurvey extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'reasons_for_leaving',
        'reasons_details',
        'physical_environment_rating',
        'induction_rating',
        'training_rating',
        'motivation_rating',
        'recognition_rating',
        'salary_rating',
        'supervisor_treatment_rating',
        'rh_treatment_rating',
        'met_expectations',
        'expectations_explanation',
        'favorite_aspects',
        'least_favorite_aspects',
        'improvements',
        'suggestions',
        'status'
    ];

    protected $casts = [
        'reasons_for_leaving' => 'array',
        'met_expectations' => 'boolean',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
