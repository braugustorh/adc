<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Indicator extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'name',
        'objective_description',
        'evaluation_formula',
        'periodicity',
        'target_value',
        'type_of_target',
        'target_period',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function ranges()
    {
        return $this->hasOne(IndicatorRange::class);
    }

    public function progresses()
    {
        return $this->hasMany(IndicatorProgress::class);
    }
}

