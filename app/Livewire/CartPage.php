<?php

namespace App\Livewire;

use App\Helpers\Cart;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Title('Cart Page')]
class CartPage extends Component
{
    use LivewireAlert;

    public $cart_items = [];
    public $grand_total = 0;

    public function mount()
    {
        $this->cart_items = Cart::all();
        $this->grand_total = Cart::calculateTotal($this->cart_items);
    }

    public function increaseQty($item_id)
    {
        $this->cart_items = Cart::increase($item_id);
        $this->grand_total = Cart::calculateTotal($this->cart_items);
    }

    public function decreaseQty($item_id)
    {
        $this->cart_items = Cart::decrease($item_id);
        $this->grand_total = Cart::calculateTotal($this->cart_items);
    }

    public function removeFromCart($item_id)
    {
        $this->cart_items = Cart::remove($item_id);
        $this->grand_total = Cart::calculateTotal($this->cart_items);
        $this->alert('success', 'Item remove from cart successfully');
    }

    public function render()
    {
        return view('livewire.cart-page');
    }
}
