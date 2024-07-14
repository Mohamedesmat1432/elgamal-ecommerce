<?php

namespace App\Observers;

use App\Models\Item;
use Illuminate\Support\Facades\Storage;

class ItemObserver
{
    /**
     * Handle the Item "created" event.
     */
    public function created(Item $item): void
    {
        //
    }

    /**
     * Handle the Item "updated" event.
     */
    public function updated(Item $item): void
    {
        if ($item->wasChanged('images')) {
            $this->deleteOldImages($item);
        }
    }

    /**
     * Handle the Item "deleted" event.
     */
    public function deleted(Item $item): void
    {
        //
    }

    /**
     * Handle the Item "restored" event.
     */
    public function restored(Item $item): void
    {
        //
    }

    /**
     * Handle the Item "force deleted" event.
     */
    public function forceDeleted(Item $item): void
    {
        $this->deleteImages($item);
    }

    public function forceDeletedBulk(Item $items): void
    {
        foreach ($items as $item) $this->deleteImages($item);
    }

    private function deleteOldImages(Item $item)
    {
        $imagesToRemove = array_diff($item->getOriginal('images'), $item->images);
        foreach ($imagesToRemove as $image) Storage::disk('public')->delete($image);
    }

    private function deleteImages(Item $item)
    {
        if ($item->images) {
            foreach ($item->images as $image) Storage::disk('public')->delete($image);
        }
    }
}
