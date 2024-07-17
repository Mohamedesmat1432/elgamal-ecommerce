<?php

namespace App\Filament\Resources;

use App\Filament\Resources\AttributeValueResource\Pages;
use App\Filament\Resources\AttributeValueResource\Pages\CreateAttributeValue;
use App\Filament\Resources\AttributeValueResource\Pages\EditAttributeValue;
use App\Filament\Resources\AttributeValueResource\Pages\ListAttributeValues;
use App\Filament\Resources\AttributeValueResource\Pages\ViewAttributeValue;
use App\Filament\Resources\AttributeValueResource\RelationManagers;
use App\Models\AttributeValue;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Actions\ActionGroup;
use Filament\Tables\Actions\BulkActionGroup;
use Filament\Tables\Actions\DeleteAction;
use Filament\Tables\Actions\DeleteBulkAction;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Actions\ViewAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class AttributeValueResource extends Resource
{
    protected static ?string $model = AttributeValue::class;

    protected static ?string $navigationIcon = 'heroicon-o-squares-plus';

    protected static ?int $navigationSort = 2;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Select::make('attribute_id')
                    ->label(__('site.attribute'))
                    ->relationship('attribute', 'name')
                    ->required()
                    ->preload()
                    ->searchable(),

                TextInput::make('value')
                    ->label(__('site.value'))
                    ->required()
                    ->maxLength(255),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('attribute.name')
                    ->label(__('site.attribute'))
                    ->searchable()
                    ->sortable()
                    ->toggleable(),

                TextColumn::make('value')
                    ->label(__('site.value'))
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
            ->actions([
                ActionGroup::make([
                    ViewAction::make()->color('warning'),
                    EditAction::make()->color('primary'),
                    DeleteAction::make(),
                ])
            ])
            ->bulkActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListAttributeValues::route('/'),
            'create' => CreateAttributeValue::route('/create'),
            'view' => ViewAttributeValue::route('/{record}'),
            'edit' => EditAttributeValue::route('/{record}/edit'),
        ];
    }

    public static function getNavigationGroup(): ?string
    {
        return __('site.items');
    }

    public static function getNavigationLabel(): string
    {
        return __('site.attribute_values');
    }

    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::count();
    }

    public static function getLabel(): ?string
    {
        return __('site.attribute_values');
    }

    public static function getModelLabel(): string
    {
        return __('site.attribute_value');
    }

    public static function getPluralModelLabel(): string
    {
        return __('site.attribute_values');
    }
}
