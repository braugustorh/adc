<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Psychometry extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $fillable = [
        'user_id',
        'test_name',
        'test_description',
        'result_url',
        'interpretation_url',
        'comments',
        'application_date',
        'expiration_date',
        'leadership',
        'communication',
        'conflict_management',
        'negotiation',
        'organization',
        'problem_analysis',
        'decision_making',
        'strategic_thinking',
        'resilience',
        'focus_on_results',
        'teamwork',
        'willingness_service'

    ];

    public function user():belongsTo
    {
        return $this->belongsTo(User::class);
    }
}
