<?php

namespace App\Livewire\Auth;

use Illuminate\Support\Facades\Password;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;

class ForgetPasswordPage extends Component
{
    use LivewireAlert;

    public string $email = '';

    public function rules()
    {
        return [
            'email' => 'required|string|email|exists:users|max:255',
        ];
    }

    public function sendPasswordResetLink()
    {
        $this->validate();

        $status = Password::sendResetLink(['email' => $this->email]);

        if ($status != Password::RESET_LINK_SENT) {
            $this->alert('error', __($status));
            return;
        }

        $this->reset('email');

        $this->alert('success', __($status));
    }

    public function render()
    {
        return view('livewire.auth.forget-password-page');
    }
}
