<?php

namespace App\Filament\Resources\OrderResource\Widgets;

use App\Models\Order;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class StatusOrder extends BaseWidget
{
    protected function getStats(): array
    {
        return [
            Stat::make(__('site.new_order'), Order::query()->status('new')->count())
                ->description(__('site.new'))
                ->url(route('filament.admin.resources.orders.index'))
                ->descriptionIcon('heroicon-o-sparkles')
                ->chart(Order::query()->status('new')->pluck('id')->toArray())
                ->color('info'),

            Stat::make(__('site.processing_order'), Order::query()->status('processing')->count())
                ->description(__('site.processing'))
                ->url(route('filament.admin.resources.orders.index'))
                ->descriptionIcon('heroicon-o-arrow-path')
                ->chart(Order::query()->status('processing')->pluck('id')->toArray())
                ->color('primary'),

            Stat::make(__('site.shipped_order'), Order::query()->status('shipped')->count())
                ->description(__('site.shipped'))
                ->url(route('filament.admin.resources.orders.index'))
                ->descriptionIcon('heroicon-o-truck')
                ->chart(Order::query()->status('shipped')->pluck('id')->toArray())
                ->color('success'),

            Stat::make(__('site.cancelled_order'), Order::query()->status('cancelled')->count())
                ->description(__('site.cancelled'))
                ->url(route('filament.admin.resources.orders.index'))
                ->descriptionIcon('heroicon-o-x-circle')
                ->chart(Order::query()->status('cancelled')->pluck('id')->toArray())
                ->color('danger'),
        ];
    }
}
