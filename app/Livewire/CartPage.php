<?php

namespace App\Livewire;

use App\Helpers\Cart;
use App\Livewire\Partials\Navbar;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;

class CartPage extends Component
{
    use LivewireAlert;

    public $cart_items = [];
    public $grand_total = 0;

    public function mount()
    {
        $this->cart_items = Cart::getCartItemsFromCookie();
        $this->grand_total = Cart::calculateGrantTotal($this->cart_items);
    }

    public function increaseQty($item_id)
    {
        $this->cart_items = Cart::increaseCartItem($item_id);
        $this->grand_total = Cart::calculateGrantTotal($this->cart_items);
    }

    public function decreaseQty($item_id)
    {
        $this->cart_items = Cart::decreaseCartItem($item_id);
        $this->grand_total = Cart::calculateGrantTotal($this->cart_items);
    }

    public function removeFromCart($item_id)
    {
        $this->cart_items = Cart::removeItemFromCart($item_id);
        $this->grand_total = Cart::calculateGrantTotal($this->cart_items);
        $this->alert('success', 'Item remove from cart successfully');
    }

    public function render()
    {
        return view('livewire.cart-page');
    }
}
