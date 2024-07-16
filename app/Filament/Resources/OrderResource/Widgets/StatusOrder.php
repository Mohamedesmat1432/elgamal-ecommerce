<?php

namespace App\Filament\Resources\OrderResource\Widgets;

use App\Models\Order;
use BezhanSalleh\FilamentShield\Traits\HasWidgetShield;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Illuminate\Contracts\Support\Htmlable;

class StatusOrder extends BaseWidget
{
    use HasWidgetShield;

    protected static ?int $sort = -4;

    public function getHeading(): string | Htmlable | null
    {
        return __('site.orders_status');
    }

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
                ->color('warning'),

            Stat::make(__('site.shipped_order'), Order::query()->status('shipped')->count())
                ->description(__('site.shipped'))
                ->url(route('filament.admin.resources.orders.index'))
                ->descriptionIcon('heroicon-o-truck')
                ->chart(Order::query()->status('shipped')->pluck('id')->toArray())
                ->color('success'),

            Stat::make(__('site.canceled_order'), Order::query()->status('canceled')->count())
                ->description(__('site.canceled'))
                ->url(route('filament.admin.resources.orders.index'))
                ->descriptionIcon('heroicon-o-x-circle')
                ->chart(Order::query()->status('canceled')->pluck('id')->toArray())
                ->color('danger'),
        ];
    }
}
