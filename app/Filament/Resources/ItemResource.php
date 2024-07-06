<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ItemResource\Pages\CreateItem;
use App\Filament\Resources\ItemResource\Pages\EditItem;
use App\Filament\Resources\ItemResource\Pages\ListItems;
use App\Filament\Resources\ItemResource\Pages\ViewItem;
use App\Filament\Resources\ItemResource\RelationManagers;
use App\Models\Item;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Group;
use Filament\Forms\Components\MarkdownEditor;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Form;
use Filament\Forms\Set;
use Filament\Resources\Resource;
use Filament\Tables\Actions\ActionGroup;
use Filament\Tables\Actions\BulkActionGroup;
use Filament\Tables\Actions\DeleteAction;
use Filament\Tables\Actions\DeleteBulkAction;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Actions\ForceDeleteAction;
use Filament\Tables\Actions\ForceDeleteBulkAction;
use Filament\Tables\Actions\RestoreAction;
use Filament\Tables\Actions\RestoreBulkAction;
use Filament\Tables\Actions\ViewAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Filters\TrashedFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ItemResource extends Resource
{
    protected static ?string $model = Item::class;

    protected static ?string $navigationIcon = 'heroicon-o-squares-2x2';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make(__('site.item_info'))->schema([
                    TextInput::make('name')
                        ->label(__('site.name'))
                        ->placeholder(__('site.name'))
                        ->maxLength(255)
                        ->required()
                        ->live(onBlur: true)
                        ->afterStateUpdated(fn(Set $set, $state) =>  $set('slug', Str::slug($state))),

                    TextInput::make('slug')
                        ->label(__('site.slug'))
                        ->placeholder(__('site.slug'))
                        ->maxLength(255)
                        ->disabled()
                        ->required()
                        ->dehydrated()
                        ->unique(Item::class, 'slug', ignoreRecord: true),

                    TextInput::make('price')
                        ->label(__('site.price'))
                        ->placeholder(__('site.price'))
                        ->numeric()
                        ->minValue(1)
                        ->prefix('EG')
                        ->required(),
                ])->columnSpan(6),

                Section::make(__('site.item_relational'))->schema([
                    Select::make('category_id')
                        ->label(__('site.category'))
                        ->relationship('category', 'name')
                        ->required()
                        ->preload()
                        ->searchable(),

                    Select::make('brand_id')
                        ->label(__('site.brand'))
                        ->relationship('brand', 'name')
                        ->required()
                        ->preload()
                        ->searchable(),

                    Group::make([
                        Toggle::make('is_active')
                        ->label(__('site.is_active'))
                        ->required()
                        ->default(true),

                    Toggle::make('in_stock')
                        ->label(__('site.in_stock'))
                        ->required()
                        ->default(true),

                    Toggle::make('is_featured')
                        ->label(__('site.is_featured'))
                        ->required()
                        ->default(false),

                    Toggle::make('on_sale')
                        ->label(__('site.on_sale'))
                        ->required()
                        ->default(false),
                    ])->columns(2)
                ])->columnSpan(6),

                Section::make(__('site.item_content'))->schema([
                    MarkdownEditor::make('description')
                        ->label(__('site.description'))
                        ->required()
                        ->fileAttachmentsDirectory('items'),

                    FileUpload::make('images')
                        ->label(__('site.images'))
                        ->multiple()
                        ->image()
                        ->reorderable()
                        ->imageEditor()
                        ->directory('items')
                        ->minSize(1)
                        ->maxSize(2024)
                        ->maxFiles(5),
                ])->columns(2)->columnSpan(12),

            ])->columns(12);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('id')
                    ->label(__('site.id'))
                    ->searchable()
                    ->sortable()
                    ->toggleable(),

                TextColumn::make('name')
                    ->label(__('site.name'))
                    ->searchable()
                    ->sortable()
                    ->toggleable(),

                TextColumn::make('slug')
                    ->label(__('site.slug'))
                    ->searchable()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),

                ImageColumn::make('images')
                    ->label(__('site.images'))
                    ->circular()
                    ->stacked()
                    ->sortable()
                    ->toggleable(),

                TextColumn::make('price')
                    ->label(__('site.price'))
                    ->searchable()
                    ->sortable()
                    ->toggleable(),

                TextColumn::make('category.name')
                    ->label(__('site.category'))
                    ->searchable()
                    ->sortable()
                    ->toggleable(),

                TextColumn::make('brand.name')
                    ->label(__('site.brand'))
                    ->searchable()
                    ->sortable()
                    ->toggleable(),

                IconColumn::make('is_active')
                    ->label(__('site.is_active'))
                    ->boolean()
                    ->sortable()
                    ->toggleable(),

                IconColumn::make('in_stock')
                    ->label(__('site.in_stock'))
                    ->boolean()
                    ->sortable()
                    ->toggleable(),

                IconColumn::make('is_featured')
                    ->label(__('site.is_featured'))
                    ->boolean()
                    ->sortable()
                    ->toggleable(),

                IconColumn::make('on_sale')
                    ->label(__('site.on_sale'))
                    ->boolean()
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

                SelectFilter::make('category_id')
                    ->label(__('site.category'))
                    ->relationship('category', 'name')
                    ->preload()
                    ->searchable(),

                SelectFilter::make('brand_id')
                    ->label(__('site.brand'))
                    ->relationship('brand', 'name')
                    ->preload()
                    ->searchable(),
            ])
            ->actions([
                // ActionGroup::make([
                    ViewAction::make(),
                    EditAction::make()->color('info')
                        ->visible(function ($record) {
                            return !$record->trashed();
                        })
                        ->before(function ($record, $data) {
                            dd($record->images);
                            $imagesToRemove = array_diff($record->images, $data['images']);
                            foreach ($imagesToRemove as $image) Storage::disk('public')->delete($image);
                        }),
                    DeleteAction::make(),
                    RestoreAction::make(),
                    ForceDeleteAction::make()
                        ->after(function ($record) {
                            if ($record->images) {
                                foreach ($record->images as $image) Storage::disk('public')->delete($image);
                            }
                        }),
                // ])
            ])
            ->bulkActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                    RestoreBulkAction::make(),
                    ForceDeleteBulkAction::make()
                        ->after(function ($records) {
                            foreach ($records as $record) {
                                if($record->images) {
                                    foreach ($record->images as $image) Storage::disk('public')->delete($image);
                                }
                            }
                        }),
                ]),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => ListItems::route('/'),
            'create' => CreateItem::route('/create'),
            'view' => ViewItem::route('/{record}'),
            'edit' => EditItem::route('/{record}/edit'),
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
        return __('site.items');
    }

    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::count();
    }

    public static function getLabel(): ?string
    {
        return __('site.items');
    }

    public static function getModelLabel(): string
    {
        return __('site.item');
    }

    public static function getPluralModelLabel(): string
    {
        return __('site.items');
    }
}
