<?php

namespace App\Listeners;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Auth\Events\Login;
use Illuminate\Support\Facades\Log;
use App\Models\User;

class LogSuccessfulLogin
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
     * 
     * 
     */
    public function handle(Login $event): void
    {

        // On log dans le canal dédié auth_audit
        Log::channel('auth_audit')->info('Connexion réussie', [
            'user_id'    => $event->user->id,
            'name'       => $event->user->name,
            'email'      => $event->user->email,
            'place'      => $event->user->place,
            'ip'         => request()->ip(),
            'user_agent' => request()->userAgent(),
            'time'       => now()->toDateTimeString(),
        ]);
    }
}
