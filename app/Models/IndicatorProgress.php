<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class IndicatorProgress extends Model
{
    use HasFactory;
    protected $table = 'indicator_progresses';

    protected $fillable = [
        'indicator_id',
        'month',
        'year',
        'progress_value',
    ];

    public function indicator()
    {
        return $this->belongsTo(Indicator::class);
    }
}
