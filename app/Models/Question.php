<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    use HasFactory;
    protected $fillable=[
       'evaluations_type_id',
       'competence_id',
       'order',
       'question',
       'comment',
       'answer_type_id',
       'status',
    ];
    public function evaluationType()
    {
        return $this->belongsTo(EvaluationsTypes::class, 'evaluations_type_id');
    }

    public function competence()
    {
        return $this->belongsTo(Competence::class, 'competence_id');
    }

    public function answerType()
    {
        return $this->belongsTo(AnswerType::class);
    }

    public function answers()
    {
        return $this->hasMany(Answer::class);
    }

    public function responses()
    {
        return $this->hasMany(Response::class);
    }
    public function evaluation360responses()
    {
        return $this->hasMany(Evaluation360Response::class, 'question_id');
    }
    public function climateOrganizationResponses()
    {
        return $this->hasMany(ClimateOrganizationalResponses::class, 'question_id');
    }

}
