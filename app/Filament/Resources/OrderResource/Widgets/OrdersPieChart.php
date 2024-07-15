<?php

namespace App\Filament\Resources\OrderResource\Widgets;

use App\Models\Order;
use BezhanSalleh\FilamentShield\Traits\HasWidgetShield;
use Filament\Widgets\ChartWidget;
use Illuminate\Contracts\Support\Htmlable;
use Illuminate\Support\Facades\DB;

class OrdersPieChart extends ChartWidget
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
        $data = Order::select('status', DB::raw('count(*) as count'))
            ->groupBy('status')->orderBy('count', 'desc')
            ->pluck('count','status')->toArray();

        return [
           'datasets' => [
                [
                    'label' => 'Blog posts created',
                    'data' => array_values($data),
                    'backgroundColor' => [
                        'rgb(54, 162, 235)',
                        'rgb(252, 165, 3)',
                        'rgb(255, 99, 132)',
                      ],
                    'borderColor' => '#9BD0F5',
                ],
            ],
            'labels' => array_keys($data),
        ];
    }

    protected function getType(): string
    {
        return 'pie';
    }
}
