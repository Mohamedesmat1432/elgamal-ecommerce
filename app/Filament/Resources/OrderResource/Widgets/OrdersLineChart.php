<?php

namespace App\Filament\Resources\OrderResource\Widgets;

use App\Models\Order;
use BezhanSalleh\FilamentShield\Traits\HasWidgetShield;
use Filament\Widgets\ChartWidget;
use Illuminate\Contracts\Support\Htmlable;
use Flowframe\Trend\Trend;
use Flowframe\Trend\TrendValue;

class OrdersLineChart extends ChartWidget
{
    use HasWidgetShield;

    protected static ?string $pollingInterval = '10s';

    protected static ?int $sort = -2;

    public function getHeading(): string | Htmlable | null
    {
        return __('site.orders_chart');
    }

    protected function getData(): array
    {
        $data = Trend::model(Order::class)
            ->between(
                start: now()->startOfYear(),
                end: now()->endOfYear(),
            )
            ->perMonth()
            ->sum('grand_total');

        return [
            'datasets' => [
                [
                    'label' => 'Blog posts',
                    'data' => $data->map(fn (TrendValue $value) => $value->aggregate),
                ],
            ],
            'labels' => $data->map(fn (TrendValue $value) => $value->date),
        ];
    }

    protected function getType(): string
    {
        return 'line';
    }
}
