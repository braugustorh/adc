<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Evaluation360Response extends Model
{
    use HasFactory;
    protected $fillable = [
        'campaign_id',
        'user_id',
        'evaluated_user_id',
        'competence_id',
        'question_id',
        'response',
    ];
    public function responses()
    {
      return $this->belongsTo(Question::class, 'question_id');
    }
    public function competences()
    {
      return $this->belongsTo(Competence::class, 'competence_id');
    }
    public function users()
    {
      return $this->belongsTo(User::class, 'user_id');
    }
    public function evaluatedUsers()
    {
      return $this->belongsTo(User::class, 'evaluated_user_id');
    }
    public function campaigns()
    {
      return $this->belongsTo(Campaign::class, 'campaign_id');
    }
    public function questions()
    {
      return $this->belongsTo(Question::class, 'question_id');
    }
}
