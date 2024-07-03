<?php

namespace App\Livewire;

use App\Models\Category;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Title('categories')]
class CategoriesPage extends Component
{
    public function render()
    {
        $categories = Category::isActive(1)->get();

        return view('livewire.categories-page', [
            'categories' => $categories,
        ]);
    }
}
