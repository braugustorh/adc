<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EvaluationHistory extends Model
{
    use HasFactory;
    protected $fillable = ['evaluation_assign_id', 'campaign_id', 'user_id', 'user_evaluated_id'];

    // Relación con EvaluationAssign
    public function evaluationAssign()
    {
        return $this->belongsTo(EvaluationAssign::class, 'evaluation_assign_id');
    }

    // Relación con Campaign
    public function campaign()
    {
        return $this->belongsTo(Campaign::class);
    }

    // Relación con el usuario que evaluó
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Relación con el usuario que fue evaluado
    public function userEvaluated()
    {
        return $this->belongsTo(User::class, 'user_evaluated_id');
    }
}
