<?php

namespace App\Http\Requests\Auth;

use Illuminate\Auth\Events\Lockout;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

class LoginRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\Rule|array|string>
     */
    public function rules(): array
    {
        return [
            'email' => ['required', 'string', 'email'],
            'password' => ['required', 'string'],
        ];
    }

    /**
     * Attempt to authenticate the request's credentials.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function authenticate(): void
    {
        $this->ensureIsNotRateLimited();

        if (! Auth::attempt($this->only('email', 'password'), $this->boolean('remember'))) {
            $throttleKey = $this->throttleKey();
            $attemptKey = $this->attemptKey();

            RateLimiter::hit($throttleKey);
            $attempts = RateLimiter::attempts($throttleKey);

            // If this is the 5th failed attempt, implement progressive lockout
            if ($attempts >= 5) {
                $lockoutLevel = $this->getLockoutLevel($attemptKey);
                $lockoutMinutes = $this->calculateLockoutTime($lockoutLevel);

                // Set the progressive lockout with custom duration
                RateLimiter::clear($throttleKey);
                RateLimiter::hit($throttleKey, $lockoutMinutes * 60); // Convert to seconds

                // Increment lockout level for next time
                cache()->put($attemptKey . ':level', $lockoutLevel + 1, now()->addDays(1));

                // Store lockout info for frontend
                session([
                    'lockout_until' => now()->addMinutes($lockoutMinutes)->timestamp,
                    'lockout_minutes' => $lockoutMinutes,
                    'lockout_level' => $lockoutLevel + 1
                ]);
            }

            throw ValidationException::withMessages([
                'email' => trans('auth.failed'),
            ]);
        }

        // Clear all lockout data on successful login
        RateLimiter::clear($this->throttleKey());
        cache()->forget($this->attemptKey() . ':level');
        session()->forget(['login_attempts', 'login_attempts_remaining', 'lockout_level', 'lockout_until', 'lockout_minutes']);
    }

    /**
     * Calculate progressive lockout time based on level
     */
    private function calculateLockoutTime(int $level): int
    {
        // First lockout: 5 minutes, then double each time (10, 20, 40, 80...)
        return 5 * pow(2, $level);
    }

    /**
     * Ensure the login request is not rate limited.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function ensureIsNotRateLimited(): void
    {
        $throttleKey = $this->throttleKey();
        $attemptKey = $this->attemptKey();

        // Get current attempt count and lockout level
        $attempts = RateLimiter::attempts($throttleKey);
        $lockoutLevel = $this->getLockoutLevel($attemptKey);

        // Check if user is currently locked out
        if (RateLimiter::tooManyAttempts($throttleKey, 5)) {
            event(new Lockout($this));

            $seconds = RateLimiter::availableIn($throttleKey);
            $minutes = ceil($seconds / 60);

            // Store lockout info for frontend
            session([
                'lockout_until' => now()->addSeconds($seconds)->timestamp,
                'lockout_minutes' => $minutes,
                'lockout_level' => $lockoutLevel
            ]);

            throw ValidationException::withMessages([
                'email' => "Trop de tentatives de connexion. Veuillez réessayer dans {$minutes} minute(s).",
            ]);
        }

        // Store current attempt info for frontend (before this attempt)
        session([
            'login_attempts' => $attempts,
            'login_attempts_remaining' => max(0, 5 - $attempts),
            'lockout_level' => $lockoutLevel
        ]);
    }

    /**
     * Get the progressive lockout level for the user
     */
    private function getLockoutLevel(string $attemptKey): int
    {
        return (int) cache()->get($attemptKey . ':level', 0);
    }

    /**
     * Get the attempt tracking key for progressive lockouts
     */
    private function attemptKey(): string
    {
        return 'progressive_lockout:' . $this->throttleKey();
    }

    /**
     * Get the rate limiting throttle key for the request.
     */
    public function throttleKey(): string
    {
        return Str::transliterate(Str::lower($this->string('email')) . '|' . $this->ip());
    }
}
