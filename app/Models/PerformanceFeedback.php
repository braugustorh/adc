<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PerformanceFeedback extends Model
{
    use HasFactory;
    protected $fillable = [
        'one_to_one_evaluation_id',
        'user_id',
        'strengths',
        'opportunities'
    ];
}
