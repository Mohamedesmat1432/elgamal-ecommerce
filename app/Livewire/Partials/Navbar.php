<?php

namespace App\Livewire\Partials;

use App\Helpers\Cart;
use Livewire\Attributes\On;
use Livewire\Component;

class Navbar extends Component
{
    public $cart_count = 0;

    public function mount()
    {
        $this->cart_count = count(Cart::getCartItemsFromCookie());
    }

    #[On('update-cart-count')]
    public function updateCartCount($cart_count)
    {
        $this->cart_count = $cart_count;
    }

    public function render()
    {
        return view('livewire.partials.navbar');
    }
}
