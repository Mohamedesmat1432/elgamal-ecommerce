<?php

namespace App\Livewire\Auth;

use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Attributes\Locked;
use Livewire\Component;

class ResetPasswordPage extends Component
{
    use LivewireAlert;

    #[Locked]
    public string $token = '';
    public string $email = '';
    public string $password = '';
    public string $password_confirmation = '';

    public function rules()
    {
        return [
            'token' => 'required',
            'email' => 'required|string|email|max:255|exists:users,email',
            'password' => 'required|string|confirmed|min:6',
        ];
    }

    public function mount(string $token): void
    {
        $this->token = $token;

        $this->email = request()->string('email');
    }

    public function resetPassword(): void
    {
        $this->validate();

        $status = Password::reset(
            $this->only('email', 'password', 'password_confirmation', 'token'),
            function ($user) {
                $user->forceFill([
                    'password' => Hash::make($this->password),
                    'remember_token' => Str::random(60),
                ])->save();

                event(new PasswordReset($user));
            }
        );

        if ($status != Password::PASSWORD_RESET) {
            $this->addError('email', __($status));
            return;
        }

        $this->alert('success', __($status));

        $this->redirect(route('login'), navigate: true);
    }

    public function render()
    {
        return view('livewire.auth.reset-password-page');
    }
}
