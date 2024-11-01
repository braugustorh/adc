<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;


class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'first_name',
        'last_name',
        'curp',
        'sex',
        'nationality',
        'birthdate',
        'birth_country',
        'birth_state',
        'birth_city',
        'disability',
        'phone',
        'email',
        'password',
        'scholarship',
        'career',
        'sede_id',
        'contract_type',
        'entry_date',
        'position_id',
        'department_id',
        'address',
        'city',
        'state',
        'cp',
        'country',
        'profile_photo',
        'colony',
        'status',
        'rfc',
        'emergency_name',
        'emergency_phone',
        'relationship_contact',
        'employee_number',
        'imss',

    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    public function sede()
    {
        return $this->belongsTo(Sede::class);
    }
    public function position(): belongsTo
    {
        return $this->belongsTo(Position::class, 'position_id');
    }
    public function department(): belongsTo
    {
        return $this->belongsTo(Department::class);
    }
    public function portfolio (): hasOne{
        return $this->hasOne(Portfolio::class);
    }
    public function psychometry(): hasMany{
    return $this->hasMany(Psychometry::class);
    }
    public function evaluationResponses360User(): hasMany{
        return $this->hasMany(Evaluation360Response::class, 'user_id');
    }
    public function evaluationResponses360Evaluated(): hasMany{
        return $this->hasMany(Evaluation360Response::class, 'evaluated_user_id');
    }
}
