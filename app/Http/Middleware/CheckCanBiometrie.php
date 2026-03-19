<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class CheckCanBiometrie
{
    public function handle($request, Closure $next)
    {
        if (Auth::check() && Auth::user()->canbiometrie) {
            return $next($request);
        }

        return redirect()->route('biometrie.index')
            ->with('error', "Vous n'êtes pas autorisé à accéder à cette section.");
    }
}
