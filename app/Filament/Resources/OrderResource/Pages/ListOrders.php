<?php

namespace App\Filament\Resources\OrderResource\Pages;

use App\Filament\Resources\OrderResource;
use App\Filament\Resources\OrderResource\Widgets\StatusOrder;
use Filament\Actions\CreateAction;
use Filament\Resources\Components\Tab;
use Filament\Resources\Pages\ListRecords;

class ListOrders extends ListRecords
{
    protected static string $resource = OrderResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }

    protected function getHeaderWidgets(): array
    {
        return [
            StatusOrder::class,
        ];
    }

    public function getTabs(): array
    {
        return [
            null => Tab::make(__('site.all')),
            __('site.new') => Tab::make()->query(fn($query) => $query->status('new')),
            __('site.processing') => Tab::make()->query(fn($query) => $query->status('processing')),
            __('site.shipped') => Tab::make()->query(fn($query) => $query->status('shipped')),
            __('site.delivered') => Tab::make()->query(fn($query) => $query->status('delivered')),
            __('site.canceled') => Tab::make()->query(fn($query) => $query->status('canceled')),
        ];
    }
}
