<?php

namespace App\Notifications;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\Log;

class UserReactivated extends Notification
{
    use Queueable;

    protected $reactivatedUser;
    protected $reactivatedBy;
    protected $isRehirable;

    public function __construct(User $reactivatedUser, User $reactivatedBy, bool $isRehirable)
    {
        $this->reactivatedUser = $reactivatedUser;
        $this->reactivatedBy = $reactivatedBy;
        $this->isRehirable = $isRehirable;
    }

    public function via($notifiable)
    {
        return ['database'];
    }

    public function toArray($notifiable)
    {
        $statusText = $this->isRehirable ? 'Recontratable' : 'No recontratable';


        return [
            'user_id' => $this->reactivatedUser->id,
            'user_name' => $this->reactivatedUser->name . ' ' . $this->reactivatedUser->first_name . ' ' . $this->reactivatedUser->last_name,
            'reactivated_by' => $this->reactivatedBy->name . ' ' . $this->reactivatedBy->first_name . ' ' . $this->reactivatedBy->last_name,
            'rehirable_status' => $statusText,
            'message' => "El usuario '{$this->reactivatedUser->name} {$this->reactivatedUser->first_name}' fue reactivado por {$this->reactivatedBy->name} {$this->reactivatedBy->first_name}. Estatus: {$statusText}",
        ];
    }
}
