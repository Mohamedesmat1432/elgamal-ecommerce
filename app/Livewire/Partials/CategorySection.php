<?php

namespace App\Livewire\Partials;

use App\Models\Category;
use Livewire\Component;

class CategorySection extends Component
{
    public function render()
    {
        $categories = Category::isActive(1)->get();

        return view('livewire.partials.category-section', [
            'categories' => $categories,
        ]);
    }
}
