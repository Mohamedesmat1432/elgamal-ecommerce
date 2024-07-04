<?php

namespace App\Livewire;

use Livewire\Attributes\Title;
use Livewire\Component;

#[Title('Checkout Page')]
class CheckoutPage extends Component
{
    public function render()
    {
        return view('livewire.checkout-page');
    }
}
