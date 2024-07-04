<?php

namespace App\Livewire;

use App\Helpers\Cart;
use App\Livewire\Partials\Navbar;
use App\Models\Item;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Title('Item Detials')]
class ItemDetailsPage extends Component
{
    use LivewireAlert;

    public $slug;
    public $quantity = 1;

    public function mount($slug)
    {
        $this->slug = $slug;
    }

    public function addToCart($item_id)
    {
        $cart_count = Cart::add($item_id, $this->quantity);
        $this->dispatch('update-cart-count', cart_count: $cart_count)->to(Navbar::class);
        $this->alert('success', 'Item add to cart successfully');
    }

    public function increaseQty()
    {
        $this->quantity++;
    }

    public function decreaseQty()
    {
        if($this->quantity > 1) {
            $this->quantity--;
        }
    }

    public function render()
    {
        $item = Item::where('slug', $this->slug)->first();

        return view('livewire.item-details-page', [
            'item' => $item,
        ]);
    }
}
