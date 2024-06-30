<?php

namespace App\Filament\Resources\ItemResource\Widgets;

use App\Models\Item;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class ItemsOverview extends BaseWidget
{
    protected function getStats(): array
    {
        return [
            Stat::make(__('site.items'), Item::count())
                ->description(__('site.items'))
                ->url(route('filament.admin.resources.items.index'))
                ->descriptionIcon('heroicon-o-squares-2x2')
                ->chart([7, 2, 10, 3, 15, 4, 17])
                ->color('success'),
        ];
    }
}
