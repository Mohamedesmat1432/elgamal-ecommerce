<?php

namespace App\Livewire;

use App\Models\Address;
use App\Models\Order;
use App\Models\OrderItem;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Title('Order Details Page')]
class OrderDetailsPage extends Component
{
    public $order_id;

    public function mount($order)
    {
        $this->order_id = $order;
    }

    public function render()
    {
        $order = Order::with('address')->where('id', $this->order_id)->first();
        $order_items = OrderItem::with('item')->where('order_id', $this->order_id)->get();

        return view('livewire.order-details-page', [
            'order' => $order,
            'order_items' => $order_items,
        ]);
    }
}
