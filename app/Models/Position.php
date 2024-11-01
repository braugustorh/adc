<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Position extends Model
{
    use HasFactory;
    protected $fillable = [
        'department_id',
        'name',
        'description',
        'order',
        'status',
        'supervisor_id',
        'evaluation_grades'
    ];

    public function department()
    {
        return $this->belongsTo(Department::class, 'department_id');
    }
    public function user()
    {
        return $this->hasMany(User::class, 'position_id');
    }
    public function supervisor()
    {
        return $this->belongsTo(Position::class, 'supervisor_id', 'id');
    }

    // Relación inversa de los subordinados
    public function subordinates()
    {
        return $this->hasMany(Position::class, 'supervisor_id', 'id');
    }


}
