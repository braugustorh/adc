<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sede extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'address',
        'phone',
        'city',
        'state',
        'address', // 'address' is misspelled
        'cp',
        'status'
    ];

    public function user()
    {
        return $this->hasMany(User::class);
    }
    public function department()
    {
        return $this->hasMany(Department::class, 'sede_id');
    }
   /* public function campaigns()
    {
        return $this->hasMany(Campaign::class, 'sedes_id');
    }*/
    public function campaigns()
    {
        return $this->belongsToMany(Campaign::class, 'campaign_sede');
    }


}
