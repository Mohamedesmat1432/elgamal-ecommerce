<?php

namespace App\Observers;

use App\Models\Brand;
use Illuminate\Support\Facades\Storage;

class BrandObserver
{
    /**
     * Handle the Brand "created" event.
     */
    public function created(Brand $brand): void
    {
        //
    }

    /**
     * Handle the Brand "updated" event.
     */
    public function updated(Brand $brand): void
    {
        if ($brand->wasChanged('image')) {
            $this->deleteOldImage($brand);
        }
    }

    /**
     * Handle the Brand "deleted" event.
     */
    public function deleted(Brand $brand): void
    {
        //
    }

    /**
     * Handle the Brand "restored" event.
     */
    public function restored(Brand $brand): void
    {
        //
    }

    /**
     * Handle the Brand "force deleted" event.
     */
    public function forceDeleted(Brand $brand): void
    {
        $this->deleteImage($brand);
    }

    public function forceDeletedBulk(Brand $brands): void
    {
        foreach($brands as $brand) $this->deleteImage($brand);
    }

    private function deleteOldImage(Brand $brand)
    {
        if ($brand->getOriginal('image')) {
            Storage::disk('public')->delete($brand->getOriginal('image'));
        }
    }

    private function deleteImage(Brand $brand)
    {
        if ($brand->image) {
            Storage::disk('public')->delete($brand->image);
        }
    }
}
