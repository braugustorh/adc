<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Department extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'sede_id',
        'status'
    ];

    public function sede()
    {
        return $this->belongsTo(Sede::class);
    }
    public function user()
    {
        return $this->hasMany(User::class);
    }
    public function position()
    {
        return $this->hasMany(Position::class, 'department_id');
    }
}
