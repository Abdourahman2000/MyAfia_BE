<?php

namespace App\Listeners;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Auth\Events\Failed;
use Illuminate\Support\Facades\Log;
use App\Models\User;


class LogFailedLogin
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(Failed $event): void
    {

        $name = 'Inconnu';
        $place = 'Inconnu';


        // Si l'email existe dans les credentials, on tente de retrouver l'utilisateur
        if (!empty($event->credentials['email'])) {
            $user = User::where('email', $event->credentials['email'])->first();
            if ($user) {
                $name = $user->name ?? 'Non défini';
                $place = $user->place ?? 'Non défini';
            }
        }

        // Journalisation dans le canal dédié
        Log::channel('auth_audit')->warning('Échec de connexion', [
            'email'      => $event->credentials['email'] ?? 'Non fourni',
            'name'       => $name,
            'place'      => $place,
            'ip'         => request()->ip(),
            'user_agent' => request()->userAgent(),
            'time'       => now()->toDateTimeString(),
        ]);
    }
}
