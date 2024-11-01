<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ClimateOrganizationalResponses extends Model
{
    use HasFactory;
    protected $fillable=[
        'campaign_id',
        'user_id',
        'competence_id',
        'question_id',
        'response',
        'created_at',
        'updated_at'
    ];
}
