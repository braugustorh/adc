<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;


class OneToOneEvaluation extends Model
{
    protected $fillable = [
        'user_id',
        'supervisor_id',
        'evaluation_date',
        'status',
    ];

    // Relación con el colaborador evaluado
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    // Relación con el supervisor que realiza la evaluación
    public function supervisor(): BelongsTo
    {
        return $this->belongsTo(User::class, 'supervisor_id');
    }

    // Relación con los temas de cultura
    public function cultureTopics(): HasMany
    {
        return $this->hasMany(CultureTopic::class, 'one_to_one_evaluation_id', 'id');
    }

    // Relación con las evaluaciones de desempeño
    public function performanceEvaluations(): HasMany
    {
        return $this->hasMany(PerformanceEvaluation::class);
    }

    // Relación con los planes de desarrollo
    public function developmentPlans(): HasMany
    {
        return $this->hasMany(DevelopmentPlan::class);
    }

    // Relación con los asuntos varios
    public function miscellaneousTopics(): HasMany
    {
        return $this->hasMany(MiscellaneousTopic::class);
    }
    public function performanceFeedback(): HasMany
    {
        return $this->hasMany(PerformanceFeedback::class);
    }
}
