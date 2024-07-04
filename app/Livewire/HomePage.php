<?php

namespace App\Livewire;

use App\Models\Brand;
use App\Models\Category;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Title('Home')]
class HomePage extends Component
{
    public function render()
    {
        $brands = Brand::isActive(1)->get();
        $categories = Category::isActive(1)->get();

        return view('livewire.home-page', [
            'brands' => $brands,
            'categories' => $categories,
        ]);
    }
}
