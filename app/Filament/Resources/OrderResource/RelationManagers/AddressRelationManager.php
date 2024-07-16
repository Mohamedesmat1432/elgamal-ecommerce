<?php

namespace App\Filament\Resources\OrderResource\RelationManagers;

use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Actions\ActionGroup;
use Filament\Tables\Actions\BulkActionGroup;
use Filament\Tables\Actions\CreateAction;
use Filament\Tables\Actions\DeleteAction;
use Filament\Tables\Actions\DeleteBulkAction;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class AddressRelationManager extends RelationManager
{
    protected static string $relationship = 'address';

    protected static ?string $recordTitleAttribute = 'street';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('f_name')
                    ->label(__('site.f_name'))
                    ->required()
                    ->maxLength(255),

                TextInput::make('l_name')
                    ->label(__('site.l_name'))
                    ->required()
                    ->maxLength(255),

                TextInput::make('phone')
                    ->label(__('site.phone'))
                    ->required()
                    ->maxLength(255),

                TextInput::make('email')
                    ->label(__('site.email'))
                    ->required()
                    ->maxLength(255),

                TextInput::make('street')
                    ->label(__('site.street'))
                    ->required()
                    ->maxLength(255),

                TextInput::make('city')
                    ->label(__('site.city'))
                    ->required()
                    ->maxLength(255),

                TextInput::make('country')
                    ->label(__('site.country'))
                    ->required()
                    ->maxLength(255),

                TextInput::make('zip_code')
                    ->label(__('site.zip_code'))
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

                TextColumn::make('f_name')
                    ->label(__('site.f_name'))
                    ->searchable()
                    ->sortable()
                    ->toggleable(),

                TextColumn::make('l_name')
                    ->label(__('site.l_name'))
                    ->searchable()
                    ->sortable()
                    ->toggleable(),

                TextColumn::make('phone')
                    ->label(__('site.phone'))
                    ->searchable()
                    ->sortable()
                    ->toggleable(),

                TextColumn::make('phone')
                    ->label(__('site.phone'))
                    ->searchable()
                    ->sortable()
                    ->toggleable(),

                TextColumn::make('email')
                    ->label(__('site.email'))
                    ->searchable()
                    ->sortable()
                    ->toggleable(),

                TextColumn::make('street')
                    ->label(__('site.street'))
                    ->searchable()
                    ->sortable()
                    ->toggleable(),

                    TextColumn::make('city')
                    ->label(__('site.city'))
                    ->searchable()
                    ->sortable()
                    ->toggleable(),

                TextColumn::make('country')
                    ->label(__('site.country'))
                    ->searchable()
                    ->sortable()
                    ->toggleable(),

                TextColumn::make('zip_code')
                    ->label(__('site.zip_code'))
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
                CreateAction::make(),
            ])
            ->actions([
                ActionGroup::make([
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

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->withoutGlobalScopes([
                SoftDeletingScope::class,
            ]);
    }

    public static function getLabel(): ?string
    {
        return __('site.addresses');
    }

    public static function getModelLabel(): string
    {
        return __('site.address');
    }

    public static function getPluralModelLabel(): string
    {
        return __('site.addresses');
    }

    public function getTableHeading(): string
    {
        return __('site.addresses');
    }
}
