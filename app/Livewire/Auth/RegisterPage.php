<?php

namespace App\Livewire\Auth;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Title('Register Page')]
class RegisterPage extends Component
{
    use LivewireAlert;

    public string $name = '';
    public string $email = '';
    public string $password = '';

    public function rules()
    {
        return [
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email|string|max:255',
            'password' => 'required|string|min:6|max:255',
        ];
    }

    public function register()
    {
        $validated = $this->validate();

        $validated['password'] = Hash::make($this->password);

        $user = User::create($validated);

        auth()->login($user);

        $this->alert('success', 'User register has been successfully');

        $this->redirectIntended(default: route('home', absolute: false), navigate: true);
    }

    public function render()
    {
        return view('livewire.auth.register-page');
    }
}
