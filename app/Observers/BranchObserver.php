<?php

namespace App\Observers;

use App\Models\Branch;
use Illuminate\Support\Facades\Storage;

class BranchObserver
{
    /**
     * Handle the Branch "created" event.
     */
    public function created(Branch $branch): void
    {
        //
    }

    /**
     * Handle the Branch "updated" event.
     */
    public function updated(Branch $branch): void
    {
        if ($branch->wasChanged('image')) {
            $this->deleteOldImage($branch);
        }
    }

    /**
     * Handle the Branch "deleted" event.
     */
    public function deleted(Branch $branch): void
    {
        //
    }

    /**
     * Handle the Branch "restored" event.
     */
    public function restored(Branch $branch): void
    {
        //
    }

    /**
     * Handle the Branch "force deleted" event.
     */
    public function forceDeleted(Branch $branch): void
    {
        $this->deleteImage($branch);
    }

    public function forceDeletedBulk(Branch $branchs): void
    {
        foreach($branchs as $branch) $this->deleteImage($branch);
    }

    private function deleteOldImage(Branch $branch)
    {
        if ($branch->getOriginal('image')) {
            Storage::disk('public')->delete($branch->getOriginal('image'));
        }
    }

    private function deleteImage(Branch $branch)
    {
        if ($branch->image) {
            Storage::disk('public')->delete($branch->image);
        }
    }
}
