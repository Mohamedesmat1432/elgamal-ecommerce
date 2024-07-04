<?php

namespace App\Livewire;

use App\Helpers\Cart;
use App\Livewire\Partials\Navbar;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Item;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Attributes\Title;
use Livewire\Attributes\Url;
use Livewire\Component;
use Livewire\WithPagination;

#[Title('Items')]
class ItemsPage extends Component
{
    use WithPagination, LivewireAlert;

    #[Url()]
    public $selected_categories = [];

    #[Url()]
    public $selected_brands = [];

    #[Url()]
    public $sort = 'latest';

    #[Url()]
    public $in_stock = 0;

    #[Url()]
    public $on_sale = 0;

    #[Url()]
    public $price_range = 30000;

    public function addToCart($item_id)
    {
        $cart_count = Cart::add($item_id);
        $this->dispatch('update-cart-count', cart_count: $cart_count)->to(Navbar::class);
        $this->alert('success', 'Item add to cart successfully');
    }

    public function render()
    {
        $brands = Brand::isActive(1)->get(['id', 'name', 'slug']);
        $categories = Category::isActive(1)->get(['id', 'name', 'slug']);
        $items = Item::isActive(1);

        if(!empty($this->selected_categories)){
            $items->whereIn('category_id', $this->selected_categories);
        }

        if(!empty($this->selected_brands)){
            $items->whereIn('brand_id', $this->selected_brands);
        }

        if($this->sort == 'latest') {
            $items->latest();
        }

        if($this->sort == 'price') {
            $items->orderBy('price');
        }

        if($this->in_stock) {
            $items->inStock(1);
        }

        if($this->on_sale) {
            $items->onSale(1);
        }

        if($this->price_range) {
            $items->whereBetween('price', [0, $this->price_range]);
        }

        return view('livewire.items-page', [
            'min_price' => Item::min('price'),
            'max_price' => Item::max('price'),
            'brands' => $brands,
            'categories' => $categories,
            'items' => $items->paginate(9),
        ]);
    }
}
