<?php

namespace App\Livewire\Auth;

use Illuminate\Validation\ValidationException;
use Illuminate\Auth\Events\Lockout;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Str;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;

class LoginPage extends Component
{
    use LivewireAlert;

    public string $email = '';
    public string $password = '';

    public function rules()
    {
        return [
            'email' => 'required|email|exists:users|string|max:255',
            'password' => 'required|string|min:6|max:255',
        ];
    }

    public function login(): void
    {
        $this->validate();

        $this->authenticate();

        $this->alert('success', 'Login has been successfully');

        $this->redirect(route('home'), navigate: true);
    }

    public function authenticate(): void
    {
        $this->ensureIsNotRateLimited();

        if (!auth()->attempt(['email' => $this->email, 'password' => $this->password])) {
            RateLimiter::hit($this->throttleKey());

            $this->alert('error', trans('auth.failed'));

            throw ValidationException::withMessages([
                'email' => trans('auth.failed'),
            ]);
        }

        RateLimiter::clear($this->throttleKey());
    }

    /**
     * Ensure the authentication request is not rate limited.
     */
    protected function ensureIsNotRateLimited(): void
    {
        if (!RateLimiter::tooManyAttempts($this->throttleKey(), 5)) {
            return;
        }

        event(new Lockout(request()));

        $seconds = RateLimiter::availableIn($this->throttleKey());

        throw ValidationException::withMessages([
            'email' => trans('auth.throttle', [
                'seconds' => $seconds,
                'minutes' => ceil($seconds / 60),
            ]),
        ]);
    }

    /**
     * Get the authentication rate limiting throttle key.
     */
    protected function throttleKey(): string
    {
        return Str::transliterate(Str::lower($this->email) . '|' . request()->ip());
    }

    public function render()
    {
        return view('livewire.auth.login-page');
    }
}
