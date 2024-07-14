<?php

namespace App\Livewire\Partials;

use App\Helpers\Cart;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Attributes\On;
use Livewire\Component;

class Navbar extends Component
{
    use LivewireAlert;

    public $cart_count = 0;

    public function mount()
    {
        $this->cart_count = count(Cart::all());
    }

    #[On('update-cart-count')]
    public function updateCartCount($cart_count)
    {
        $this->cart_count = $cart_count;
    }

    public function logout()
    {
        auth()->logout();

        $this->alert('success', 'Logout has been successfully');

        $this->redirect(route('home'), navigate: true);
    }

    public function render()
    {
        return view('livewire.partials.navbar');
    }
}
