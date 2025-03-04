<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class IndicatorRange extends Model
{
    use HasFactory;
    protected $fillable = [
        'indicator_id',
        'expression_excellent',
        'excellent_threshold',
        'expression_satisfactory',
        'satisfactory_threshold',
        'expression_unsatisfactory',
        'unsatisfactory_threshold',
    ];

    public function indicator()
    {
        return $this->belongsTo(Indicator::class);
    }

}
