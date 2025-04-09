<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EvaluationAssign extends Model
{
    use HasFactory;
    protected $fillable = [
        'evaluation_id',
        'campaign_id',
        'position_id',
        'type',
        'user_to_evaluate_id',
        'user_id'
    ];

    // Relación con Campaign
    public function campaign()
    {
        return $this->belongsTo(Campaign::class);
    }

    // Relación con Position
    public function position()
    {
        return $this->belongsTo(Position::class);
    }

    // Relación con el usuario que va a ser evaluado
    public function userToEvaluate()
    {
        return $this->belongsTo(User::class, 'user_to_evaluate_id');
    }

    // Relación con el usuario que evalúa
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Relación con EvaluationHistory
    public function evaluationHistory()
    {
        return $this->hasMany(EvaluationHistory::class);
    }
    public function evaluation()
    {
        return $this->belongsTo(EvaluationsTypes::class, 'evaluation_id');
    }
    public function modelUser($id){

    return User::find($id);
    }

}
