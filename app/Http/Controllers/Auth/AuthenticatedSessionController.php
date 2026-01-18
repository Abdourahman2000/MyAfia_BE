<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use Illuminate\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\RedirectResponse;
use App\Providers\RouteServiceProvider;
use Illuminate\Support\Facades\Session;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Str;


class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(Request $request): View
    {
        // Generate throttle key for current request
        $email = $request->input('email', '');
        $throttleKey = $this->getThrottleKey($email, $request->ip());

        // Get current attempt information
        $attempts = RateLimiter::attempts($throttleKey);
        $attemptsRemaining = max(0, 5 - $attempts);

        // Check if currently locked out
        $isLockedOut = RateLimiter::tooManyAttempts($throttleKey, 5);
        $lockoutSeconds = $isLockedOut ? RateLimiter::availableIn($throttleKey) : 0;

        // Store in session for the view
        session([
            'login_attempts' => $attempts,
            'login_attempts_remaining' => $attemptsRemaining,
            'is_locked_out' => $isLockedOut,
            'lockout_until' => $isLockedOut ? now()->addSeconds($lockoutSeconds)->timestamp : null,
        ]);

        return view('auth.login');
    }

    /**
     * Get throttle key similar to LoginRequest
     */
    private function getThrottleKey(string $email, string $ip): string
    {
        return Str::transliterate(Str::lower($email) . '|' . $ip);
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request): RedirectResponse
    {
        $user = User::where('email', $request->email)->first();

        if ($user) {
            // Clear all existing sessions for this user
            if ($session = DB::table('sessions')->where('user_id', $user->id)) {
                $session->delete();
            };
        }

        $request->authenticate();
        $user = User::find(Auth::user()->id);
        $user->update([
            'last_login_at' => now()
        ]);



        $request->session()->regenerate();
        return redirect()->route('dashboard');
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}
