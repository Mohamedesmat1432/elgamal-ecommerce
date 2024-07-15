<?php

namespace App\Filament\Resources\OrderResource\Widgets;

use App\Filament\Resources\OrderResource;
use App\Models\Order;
use BezhanSalleh\FilamentShield\Traits\HasWidgetShield;
use Filament\Tables\Actions\Action;
use Filament\Tables\Actions\ActionGroup;
use Filament\Tables\Actions\DeleteAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;

class LatestOrder extends BaseWidget
{
    use HasWidgetShield;

    protected static ?int $sort = -3;

    protected int | array | string $columnSpan = 'full';

    public function table(Table $table): Table
    {
        return $table
            ->query(OrderResource::getEloquentQuery())
            ->defaultPaginationPageOption(5)
            ->defaultSort('created_at', 'desc')
            ->columns([
                TextColumn::make('id')
                    ->label(__('site.id'))
                    ->searchable()
                    ->sortable()
                    ->toggleable(),

                TextColumn::make('user.name')
                    ->label(__('site.customer'))
                    ->searchable()
                    ->sortable()
                    ->toggleable(),

                TextColumn::make('grand_total')
                    ->label(__('site.grand_total'))
                    ->searchable()
                    ->sortable()
                    ->toggleable(),

                TextColumn::make('payment_method')
                    ->label(__('site.payment_method'))
                    ->searchable()
                    ->sortable()
                    ->toggleable(),

                TextColumn::make('payment_status')
                    ->label(__('site.payment_status'))
                    ->searchable()
                    ->sortable()
                    ->toggleable(),

                TextColumn::make('shipping_method')
                    ->label(__('site.shipping_method'))
                    ->searchable()
                    ->sortable()
                    ->toggleable(),

                TextColumn::make('currency')
                    ->label(__('site.currency'))
                    ->searchable()
                    ->sortable()
                    ->toggleable(),

                TextColumn::make('status')
                    ->label(__('site.status'))
                    ->badge()
                    ->color(fn (string $state): string =>  match($state) {
                        'new' => 'info',
                        'processing' => 'warning',
                        'shipped' =>'success',
                        'delivered' =>'success',
                        'cancelled' =>'danger',
                    })
                    ->icon(fn (string $state): string => match($state) {
                        'new' => 'heroicon-m-sparkles',
                        'processing' => 'heroicon-m-arrow-path',
                        'shipped' => 'heroicon-m-truck',
                        'delivered' => 'heroicon-m-check-circle',
                        'cancelled' => 'heroicon-m-x-circle',
                    })
                    ->searchable()
                    ->sortable()
                    ->toggleable(),

                TextColumn::make('created_at')
                    ->label(__('site.created_at'))
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),

                TextColumn::make('updated_at')
                    ->label(__('site.updated_at'))
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->actions([
                ActionGroup::make([
                    Action::make(__('site.view'))
                        ->icon('heroicon-o-eye')
                        ->color('warning')
                        ->url(fn (Order $record): string => OrderResource::getUrl('view', ['record' => $record])),

                    Action::make(__('site.edit'))
                        ->icon('heroicon-o-pencil-square')
                        ->color('info')
                        ->url(fn (Order $record): string => OrderResource::getUrl('edit', ['record' => $record])),

                    DeleteAction::make(),
                ]),
            ]);
    }

    public function getTableHeading(): string
    {
        return __('site.latest_orders');
    }

    public static function getLabel(): ?string
    {
        return __('site.orders');
    }

    public static function getModelLabel(): string
    {
        return __('site.order');
    }

    public static function getPluralModelLabel(): string
    {
        return __('site.orders');
    }
}
