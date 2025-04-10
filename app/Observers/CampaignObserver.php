<?php

namespace App\Observers;

use App\Models\Campaign;
use App\Models\User;
use Filament\Notifications\Notification;

class CampaignObserver
{
    /**
     * Handle the Campaign "created" event.
     */
    public function created(Campaign $campaign): void
    {
        //
    }

    /**
     * Handle the Campaign "updated" event.
     */
    public function updated(Campaign $campaign): void
    {
        // Verificar si cambió a Activa
        if ($campaign->status === 'Activa' && $campaign->getOriginal('status') !== 'Activa') {
            // Obtener usuarios de las sedes
            $sedeIds = $campaign->sedes->pluck('id')->toArray();
            $users = User::whereIn('sede_id', $sedeIds)->get();

            foreach ($users as $user) {
                Notification::make()
                    ->title("Campaña Activada: {$campaign->name}")
                    ->body("La campaña '{$campaign->name}' ha sido activada para tu sede.")
                    ->success()
                    ->sendToDatabase($user);
            }

            // Notificar al administrador
            if (auth()->check()) {
                Notification::make()
                    ->title('Notificaciones enviadas')
                    ->body("Se han enviado notificaciones a " . $users->count() . " usuarios.")
                    ->success()
                    ->send();
            }
        }
    }


    /**
     * Handle the Campaign "deleted" event.
     */
    public function deleted(Campaign $campaign): void
    {
        //
    }

    /**
     * Handle the Campaign "restored" event.
     */
    public function restored(Campaign $campaign): void
    {
        //
    }

    /**
     * Handle the Campaign "force deleted" event.
     */
    public function forceDeleted(Campaign $campaign): void
    {
        //
    }
}
