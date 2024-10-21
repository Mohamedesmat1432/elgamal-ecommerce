<?php

namespace App\Livewire\Partials;

use App\Models\Brand;
use Livewire\Component;

class BrandSection extends Component
{
    public function render()
    {
        $brands = Brand::isActive(1)->get();

        return view('livewire.partials.brand-section', [
            'brands' => $brands
        ]);
    }
}
