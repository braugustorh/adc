<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ClimateOrganizationalResponses extends Model
{
    use HasFactory;
    protected $fillable=[
        'campaign_id',
        'user_id',
        'competence_id',
        'question_id',
        'response',
        'created_at',
        'updated_at'
    ];
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public static function getResponsesBySedeAndCampaign($sedeId, $campaignId = null)
    {
        $query = ClimateOrganizationalResponses::select('climate_organizational_responses.*')
            ->join('users', 'climate_organizational_responses.user_id', '=', 'users.id')
            ->where('users.sede_id', $sedeId);
        if ($campaignId) {
            $query->where('climate_organizational_responses.campaign_id', $campaignId);
        }

        return $query->get();
    }
    public static function getCompetenceAverages($queryClima,$evaluationId)
    {
        $competences = Competence::where('status', 1)
            ->where('evaluations_type_id', $evaluationId)
            ->get();
        $data = [];

        foreach ($competences as $competence) {
            $average = $queryClima->where('competence_id', $competence->id)
                ->avg('response');
            $data[] = [
                'competence' => $competence->name,
                'average' => $average,
            ];
        }

        return $data;
    }

    public static function getGlobalScore($responses = null)
    {
        // Si no se proporcionan respuestas, usar todas
        if ($responses === null) {
            $responses = self::all();
        }

        // Si no hay respuestas, retornar 0
        if ($responses->isEmpty()) {
            return 0;
        }

        // Calcular el promedio global de todas las respuestas
        return round($responses->avg('response'), 2);
    }
    public function competence(){
        return $this->belongsTo(Competence::class, 'competence_id');
    }
    public function question(){
        return $this->belongsTo(Question::class, 'question_id');
    }
    public function campaign(){
        return $this->belongsTo(Campaign::class, 'campaign_id');
    }




}
