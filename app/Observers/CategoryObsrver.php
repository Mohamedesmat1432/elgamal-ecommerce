<?php

namespace App\Observers;

use App\Models\Category;
use Illuminate\Support\Facades\Storage;

class CategoryObsrver
{
    /**
     * Handle the Category "created" event.
     */
    public function created(Category $category): void
    {
        //
    }

    /**
     * Handle the Category "updated" event.
     */
    public function updated(Category $category): void
    {
        if ($category->wasChanged('image')) {
            $this->deleteOldImage($category);
        }
    }

    /**
     * Handle the Category "deleted" event.
     */
    public function deleted(Category $category): void
    {
        //
    }

    /**
     * Handle the Category "restored" event.
     */
    public function restored(Category $category): void
    {
        //
    }

    /**
     * Handle the Category "force deleted" event.
     */

    public function forceDeleted(Category $category): void
    {
        $this->deleteImage($category);
    }

    public function forceDeletedBulk(Category $categories): void
    {
        foreach($categories as $category) $this->deleteImage($category);
    }

    private function deleteOldImage(Category $category)
    {
        if ($category->getOriginal('image')) {
            Storage::disk('public')->delete($category->getOriginal('image'));
        }
    }

    private function deleteImage(Category $category)
    {
        if ($category->image) {
            Storage::disk('public')->delete($category->image);
        }
    }
}
