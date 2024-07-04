<?php

namespace App\Livewire;

use Livewire\Attributes\Title;
use Livewire\Component;

#[Title('MyOrders Page')]
class MyOrdersPage extends Component
{
    public function render()
    {
        return view('livewire.my-orders-page');
    }
}