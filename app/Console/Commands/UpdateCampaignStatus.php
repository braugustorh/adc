<?php

namespace App\Console\Commands;

use App\Models\Campaign;
use App\Models\EvaluationAssign;
use App\Models\EvaluationHistory;
use App\Models\User;
use Filament\Notifications\Notification;
use Illuminate\Console\Command;

class UpdateCampaignStatus extends Command
{
    protected $signature = 'campaign:update-status';
    protected $description = 'Update campaign status based on the current date and assign evaluations';

    public function handle()
    {
        $currentDate = now()->startOfDay();
        $this->info('Updating campaign statuses...');
        $this->info('Current date: ' . $currentDate);

        $campaigns = Campaign::where(function($query) use ($currentDate) {
            $query->where('status', 'Activa')
                ->where('end_date', '<', $currentDate);
        })->orWhere(function($query) use ($currentDate) {
            $query->where('status', 'Programada')
                ->where('start_date', '<=', $currentDate);
        })->get();

        foreach ($campaigns as $campaign) {
            if ($campaign->status == 'Activa' && $campaign->end_date < $currentDate) {
                $campaign->status = 'Concluida';
                $this->info('Campaign: ' . $campaign->name . ' has ended.');
            } elseif ($campaign->status == 'Programada' && $campaign->start_date <= $currentDate) {
                $campaign->status = 'Activa';
                $this->info('Campaign: ' . $campaign->name . ' has started.');

                $this->info('Assigning evaluation 360');

                $teams = User::where('status', true)
                    ->whereNotNull('department_id')
                    ->whereNotNull('position_id')
                    ->whereNotNull('sede_id')
                    ->with('position')
                    ->get()
                    ->groupBy(['sede_id', 'department_id', 'position.supervisor_id']);

                foreach ($teams as $team) {
                    $this->assignEvaluations($team, $campaign);
                }
            }
            // Actualiza el estado de la campaña
            $campaign->save();

            // Enviar notificaciones a los usuarios asignados si la campaña cambió a Activa
            if ($campaign->status === 'Activa') {
                $this->sendNotificationsToAssignedUsers($campaign);
            }


        }


        $this->info('Campaign statuses and evaluations updated successfully.');
    }

    protected function hasEvaluatedBefore($userId, $evaluatedId, $campaignId)
    {
        // Verifica si ya se evaluaron en campañas pasadas (EvaluationHistory)
        return EvaluationHistory::where('user_id', $userId)
            ->where('user_evaluated_id', $evaluatedId)
            ->exists();
    }

    protected function sendNotificationsToAssignedUsers($campaign)
    {
        // Obtener todos los usuarios asignados a esta campaña
        $assignedEvaluations = EvaluationAssign::where('campaign_id', $campaign->id)
            ->with(['user', 'userToEvaluate'])
            ->get();

        foreach ($assignedEvaluations as $assignment) {
            // Notificar al evaluador
            $user = $assignment->user;
            $userToEvaluate = $assignment->userToEvaluate;

            if ($user) {
                // Enviar notificación al evaluador
                Notification::make()
                    ->title('Campaña de Evaluación Activa')
                    ->info()
                    ->icon('heroicon-m-information-circle')
                    ->body("Hola ha iniciado la campaña de evaluación {$campaign->name}.")
                    ->sendToDatabase($user);


            }
        }
    }


    protected function assignEvaluations($team, $campaign)
    {

        foreach ($team as $supervisorId=>$members) {
            //$supervisorId =$members[0]->with('position')->first()->position->supervisor_id;
            //dd($supervisorId);
            $supervisor = User::find($supervisorId);

            if ($supervisor) {
                foreach ($members as $group) {
                    foreach ($group as $member) {
                        $supervisorId = $member->position->supervisor_id;
                        $superArray= User::where('position_id','=',$supervisorId)->get();
                        if ($superArray->count()>0){
                            $userID=$superArray[0]->id;
                            $user=New User();
                            $supervisor=$user->find($userID);
                            if ($supervisor){
                                if ($supervisor->id !== $member->id) {
                                    // Asigna la evaluación del supervisor al miembro del equipo
                                    $this->info("Assigning evaluation from supervisor {$supervisor->name} to {$member->name}");
                                    $this->assignEvaluation($supervisor, $member->id, $campaign);
                                }
                                switch ($member->position->evaluation_grades) {
                                    case 90:
                                        $this->assignEvaluation($member, $supervisor->id, $campaign);
                                        break;
                                    case 180:
                                        $this->assignSelfEvaluation($member, $campaign);
                                        $this->assignEvaluation($member, $supervisor->id, $campaign);
                                        break;
                                    case 270:
                                        $this->assignSelfEvaluation($member, $campaign);
                                        $this->assignEvaluation($member, $supervisor->id, $campaign);
                                        $this->assignPeerEvaluation($members, $member, $campaign);
                                        break;
                                    case 360:
                                        $this->assignSelfEvaluation($member, $campaign);
                                        $this->assignEvaluation($member, $supervisor->id, $campaign);
                                        $this->assignPeerEvaluation($members, $member, $campaign);

                                        // Aquí podrías agregar lógica adicional para la evaluación del cliente si aplica
                                        break;
                                }
                            }
                        }

                    }
                }
            }
        }
    }

    protected function assignSelfEvaluation($member, $campaign)
    {
        // Verifica que no se haya autoevaluado antes en esta campaña (dentro de EvaluationAssign)
        if (!$this->isAlreadyAssigned($member->id, $member->id, $campaign->id)) {
            $this->assignEvaluation($member, $member->id, $campaign);
        }
    }

    protected function assignPeerEvaluation($members, $member, $campaign)
    {
        $peers = $members->where('id', '!=', $member->id)->shuffle();

        foreach ($peers as $group) {
            foreach ($group as $peer) {
                if ($peer instanceof \App\Models\User) {
                    // Verifica que no se haya asignado una evaluación duplicada dentro de EvaluationAssign
                    if (!$this->isAlreadyAssigned($member->id, $peer->id, $campaign->id)) {
                        // Verifica si ya se evaluaron en campañas pasadas usando hasEvaluatedBefore
                        if (!$this->hasEvaluatedBefore($member->id, $peer->id, $campaign->id)) {
                            $this->assignEvaluation($member, $peer->id, $campaign);
                            //Quien realiza la evaluación es el supervisor y el evaluado es el miembro del equipo
                            //assignEvaluation recibe (evaluador, evaluado, campaña)
                            break 2; // Sal del bucle una vez que se asigna la evaluación
                        }else{
                            //rutina para evaluar si ya se asignó la evaluación en campañas pasadas
                            $this->info("Peer evaluation already assigned in older campign from {$member->name} to {$peer->name}");
                        }
                    }else{
                        $this->info("Peer evaluation already assigned from {$member->name} to {$peer->name}");
                    }
                }
            }
        }
    }

    protected function assignEvaluation($evaluator, $evaluateeId, $campaign)
    {
        // Realiza la asignación de evaluación
        EvaluationAssign::create([
            'evaluation_id' => 2, // Ajusta esto según tu modelo
            'campaign_id' => $campaign->id,
            'position_id' => $evaluator->position_id,
            'user_to_evaluate_id' => $evaluateeId,
            'user_id' => $evaluator->id,
        ]);
        $this->info("Assigned evaluation from {$evaluator->name} to {$evaluateeId}");
    }

    protected function isAlreadyAssigned($userId, $evaluateeId, $campaignId)
    {
        // Verifica si ya existe una asignación en la misma campaña (EvaluationAssign)
        return EvaluationAssign::where('user_id', $userId)
            ->where('user_to_evaluate_id', $evaluateeId)
            ->where('campaign_id', $campaignId)
            ->exists();
    }


}
