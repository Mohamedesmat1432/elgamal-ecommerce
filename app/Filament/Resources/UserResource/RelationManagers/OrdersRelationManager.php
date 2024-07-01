<?php

namespace App\Filament\Resources\UserResource\RelationManagers;

use App\Filament\Resources\OrderResource;
use App\Models\Order;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables\Actions\Action;
use Filament\Tables\Actions\BulkActionGroup;
use Filament\Tables\Actions\CreateAction;
use Filament\Tables\Actions\DeleteAction;
use Filament\Tables\Actions\DeleteBulkAction;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class OrdersRelationManager extends RelationManager
{
    protected static string $relationship = 'orders';

    protected static ?string $recordTitleAttribute = 'id';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('grand_total')
                    ->required()
                    ->maxLength(255),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
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
            ->filters([
                //
            ])
            ->headerActions([
                // CreateAction::make(),
            ])
            ->actions([
                Action::make(__('site.view'))
                    ->icon('heroicon-o-eye')
                    ->url(fn (Order $record): string => OrderResource::getUrl('view', ['record' => $record])),

                Action::make(__('site.edit'))
                    ->icon('heroicon-o-pencil-square')
                    ->color('info')
                    ->url(fn (Order $record): string => OrderResource::getUrl('edit', ['record' => $record])),

                DeleteAction::make(),
            ])
            ->bulkActions([
                // BulkActionGroup::make([
                //     DeleteBulkAction::make(),
                // ]),
            ]);
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->withoutGlobalScopes([
                SoftDeletingScope::class,
            ]);
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

    public function getTableHeading(): string
    {
        return __('site.orders');
    }
}
