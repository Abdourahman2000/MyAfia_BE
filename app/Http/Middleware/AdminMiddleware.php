<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class AdminMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        // Check if the user is authenticated and has the 'admin' or 'super_admin' role
        if (Auth::check() && (Auth::user()->type == 'admin' || Auth::user()->type == 'super_admin')) {
            return $next($request);
        }

        // If the user is not an admin, you can redirect or abort the request
        return redirect('/'); // Redirect to home page or any other page
        // Or return abort(403); // Forbid access
    }
}
