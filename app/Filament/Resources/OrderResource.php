<?php

namespace App\Filament\Resources;

use App\Filament\Resources\OrderResource\Pages\ManageOrders;
use App\Filament\Resources\OrderResource\RelationManagers\AddressRelationManager;
use App\Models\Item;
use App\Models\Order;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\Placeholder;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\ToggleButtons;
use Filament\Forms\Form;
use Filament\Forms\Set;
use Filament\Forms\Get;
use Filament\Resources\Resource;
use Filament\Tables\Actions\BulkActionGroup;
use Filament\Tables\Actions\DeleteAction;
use Filament\Tables\Actions\DeleteBulkAction;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Actions\ForceDeleteAction;
use Filament\Tables\Actions\ForceDeleteBulkAction;
use Filament\Tables\Actions\RestoreAction;
use Filament\Tables\Actions\RestoreBulkAction;
use Filament\Tables\Actions\ViewAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\TrashedFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Number;

class OrderResource extends Resource
{
    protected static ?string $model = Order::class;

    protected static ?string $navigationIcon = 'heroicon-o-shopping-bag';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make(__('site.order_info'))->schema([
                    Select::make('user_id')
                        ->label(__('site.customer'))
                        ->relationship('user', 'name')
                        ->preload()
                        ->columnSpan(6)
                        ->required()
                        ->searchable(),

                    Select::make('payment_method')
                        ->label(__('site.payment_method'))
                        ->options([
                            'stripe' => __('site.stripe'),
                            'cod' => __('site.cod'),
                        ])
                        ->columnSpan(6)
                        ->default('cod')
                        ->required()
                        ->searchable(),

                    Select::make('payment_status')
                        ->label(__('site.payment_status'))
                        ->options([
                            'pending' => __('site.pending'),
                            'paid' => __('site.paid'),
                            'faild' => __('site.faild'),
                        ])
                        ->columnSpan(6)
                        ->default('pending')
                        ->required()
                        ->searchable(),
                    
                    
                    Select::make('currency')
                        ->label(__('site.currency'))
                        ->options([
                            'inr' => 'INR',
                            'usd' => 'USD',
                            'eg' => 'EG',
                            'eur' => 'EUR',
                        ])
                        ->columnSpan(6)
                        ->default('usd')
                        ->required(),

                    Select::make('shipping_method')
                        ->label(__('site.shipping_method'))
                        ->options([
                            'fedex' => 'FedEx',
                            'ups' =>'UPS',
                            'usps' =>'USPS',
                            'hdl' => 'HDL',
                        ])
                        ->columnSpan(6)
                        ->default('fedex')
                        ->required()
                        ->searchable(),

                    ToggleButtons::make('status')
                        ->label(__('site.status'))
                        ->options([
                            'new' => __('site.new'),
                            'processing' => __('site.processing'),
                            'shipped' => __('site.shipped'),
                            'delivered' => __('site.delivered'),
                            'cancelled' => __('site.cancelled'),
                        ])
                        ->colors([
                            'new' => 'info',
                            'processing' => 'warning',
                            'shipped' =>'success',
                            'delivered' =>'success',
                            'cancelled' =>'danger',
                        ])
                        ->icons([
                            'new' => 'heroicon-m-sparkles',
                            'processing' => 'heroicon-m-arrow-path',
                            'shipped' => 'heroicon-m-truck',
                            'delivered' => 'heroicon-m-check-circle',
                            'cancelled' => 'heroicon-m-x-circle',
                        ])
                        ->default('new')
                        ->inline()
                        ->columnSpan(6)
                        ->required(),

                    Textarea::make('notes')
                        ->columnSpan(6)
                ])->columns(12)->columnSpan(12),
                
                Repeater::make('orderItems')
                    ->label(__('site.order_items'))
                    ->relationship()->schema([
                        Select::make('item_id')
                            ->label(__('site.item'))
                            ->relationship('item', 'name')
                            ->required()
                            ->preload()
                            ->searchable()
                            ->distinct() 
                            ->disableOptionsWhenSelectedInSiblingRepeaterItems()
                            ->columnSpan(4)
                            ->reactive()
                            ->dehydrated()
                            ->afterStateUpdated(fn ($state, $set) => $set('unit_amount', Item::find($state)?->price ?? 0))
                            ->afterStateUpdated(fn ($state, $set) => $set('total_amount', Item::find($state)?->price ?? 0)),

                        TextInput::make('quantity')
                            ->label(__('site.quantity'))
                            ->numeric()
                            ->required()
                            ->default(1)
                            ->minValue(1)
                            ->columnSpan(2)
                            ->reactive()
                            ->dehydrated()
                            ->afterStateUpdated(fn ($state, Set $set, Get $get) => $set('total_amount', $state * $get('unit_amount'))),

                        TextInput::make('unit_amount')
                            ->label(__('site.unit_amount'))
                            ->numeric()
                            ->required()
                            ->disabled()
                            ->dehydrated()
                            ->columnSpan(3),

                        TextInput::make('total_amount')
                            ->label(__('site.total_amount'))
                            ->numeric()
                            ->required()
                            ->dehydrated()
                            ->columnSpan(3),                               
                    ])->columns(12)->columnSpan(12),

                Placeholder::make('grand_total_placeholder')
                    ->label(__('site.grand_total'))
                    ->content(function(Get $get, Set $set) {
                        $total = 0;

                        if(!$repeaters = $get('orderItems')) {
                            return $total;
                        }

                        foreach($repeaters as $key => $repeator) {
                            $total += $get("orderItems.{$key}.total_amount");
                        }

                        $set('grand_total', $total);

                        // return $total;
                        return Number::currency($total, 'USD');
                    })->columnSpan(12),

                    Hidden::make('grand_total')
                        ->default(0),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
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
                TrashedFilter::make(),
            ])
            ->actions([
                ViewAction::make(),
                EditAction::make()
                    ->color('primary')
                    ->visible(function ($record) {
                        return !$record->trashed();
                    }),
                DeleteAction::make(),
                RestoreAction::make(),
                ForceDeleteAction::make(),
            ])
            ->bulkActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                    RestoreBulkAction::make(),
                    ForceDeleteBulkAction::make(),
                ]),
            ]);
    }
    
    public static function getRelations(): array
    {
        return [
            AddressRelationManager::class
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ManageOrders::route('/'),
        ];
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->withoutGlobalScopes([
                SoftDeletingScope::class,
            ]);
    }

    public static function getNavigationLabel(): string
    {
        return __('site.orders');
    }

    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::count();
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
