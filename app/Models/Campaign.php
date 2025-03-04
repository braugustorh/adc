<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Campaign extends Model
{
    use HasFactory;
    protected $casts = [
        'evaluations_id' => 'array',
        'sedes_id' => 'array',
    ];

    protected $fillable = [
        'name',
        'evaluations_id',
        'sedes_id',
        'description',
        'start_date',
        'end_date',
        'user_id',
        'status',
    ];


    public function evaluations()
    {
        return $this->belongsToMany(EvaluationsTypes::class, 'campaign_evaluation', 'campaign_id', 'evaluation_type_id');
    }

    public function sedes()
    {
        return $this->belongsToMany(Sede::class, 'campaign_sede','campaign_id', 'sede_id');
    }
    public function responses()
    {
        return $this->hasMany(Response::class);
    }
    public function evaluationAssignments()
    {
        return $this->hasMany(EvaluationAssign::class);
    }

    //Añadiendo tablas Pivot se comentan las siguientes relaciones ya que quedarán en deshuso
    /*
    public function sede(){
        return $this->belongsTo(Sede::class, 'sedes_id');

    }

    public function evaluations()
    {
        return $this->belongsToMany(EvaluationsTypes::class, 'campaigns_evaluations', 'campaign_id', 'evaluation_id');
    }
   public function sedes()
    {
        return $this->belongsToMany(Sede::class, 'campaigns_sedes', 'campaign_id', 'sede_id');
    }

    public function getEvaluationTypeNamesAttribute()
    {
        return $this->evaluationTypes->pluck('name')->toArray();
    }
    public function sedes()
    {
        return $this->belongsTo(Sede::class, 'sedes_id', 'id');
    }
    public function getSedesNameAttribute()
    {
        return $this->sedes->pluck('name')->toArray();
    }

    */
    //Se debe verificar si se usa esta relación
    public function evaluationTypes()
    {
        return $this->belongsTo(EvaluationsTypes::class, 'evaluations_id', 'id');
    }


}
