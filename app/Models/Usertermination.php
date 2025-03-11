<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserTermination extends Model
{
    protected $fillable = [
        'user_id',
        'processed_by',
        'termination_date',
        'termination_type',
        'other_reason',
        'prior_notice',
        'notice_days',
        'exit_interview',
        'interview_date',
        'interviewer_id',
        'detailed_reason',
        'performance',
        'performance_comments',
        'employee_feedback',
        'supervisor_feedback',
        'documents_delivered',
        'settlement_completed',
        'settlement_details',
        //'company_assets_returned',
        'access_deactivated',
        'access_deactivation_date',
        //'impacts_team',
        //'impact_details',
        'position_replaced',
        //'replacement_date',
        'replacement_urgency',
        'impacts_team',
        //'organizational_issues',
        //'attached_documents',
        'additional_comments',
        're_hire',
    ];
    protected $casts = [
        'documents_delivered' => 'array',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function processor()
    {
        return $this->belongsTo(User::class, 'processed_by');
    }

    public function interviewer()
    {
        return $this->belongsTo(User::class, 'interviewer_id');
    }
}
