<?php

namespace App\Livewire;

use Livewire\Attributes\Title;
use Livewire\Component;

#[Title('Order Details Page')]
class OrderDetailsPage extends Component
{
    public function render()
    {
        return view('livewire.order-details-page');
    }
}
