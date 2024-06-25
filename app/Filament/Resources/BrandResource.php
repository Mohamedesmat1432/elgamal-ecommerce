<?php

namespace App\Filament\Resources;

use App\Filament\Resources\BrandResource\Pages\ManageBrands;
use App\Filament\Resources\BrandResource\RelationManagers;
use App\Models\Brand;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Form;
use Filament\Forms\Set;
use Filament\Resources\Resource;
use Filament\Tables\Actions\BulkActionGroup;
use Filament\Tables\Actions\DeleteBulkAction;
use Filament\Tables\Actions\ActionGroup;
use Filament\Tables\Actions\ViewAction;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Actions\DeleteAction;
use Filament\Tables\Actions\ForceDeleteAction;
use Filament\Tables\Actions\ForceDeleteBulkAction;
use Filament\Tables\Actions\RestoreAction;
use Filament\Tables\Actions\RestoreBulkAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\TrashedFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class BrandResource extends Resource
{
    protected static ?string $model = Brand::class;

    protected static ?string $navigationIcon = 'heroicon-o-bookmark';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('name')
                    ->maxLength(255)
                    ->required()
                    ->live(onBlur: true)
                    ->afterStateUpdated(fn(Set $set, $state) =>  $set('slug', Str::slug($state)))
                    ->placeholder('Name'),

                TextInput::make('slug')
                    ->maxLength(255)
                    ->disabled()
                    ->required()
                    ->dehydrated()
                    ->unique(Brand::class, 'slug', ignoreRecord: true)
                    ->placeholder('Slug'),

                FileUpload::make('image')
                    ->image()
                    ->imageEditor()
                    ->minSize(1)
                    ->maxSize(1024)
                    ->directory('brands')
                    ->columnSpanFull(),

                Toggle::make('is_active')
                    ->required()
                    ->default(true),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
                    ->searchable()
                    ->sortable()
                    ->toggleable(),

                TextColumn::make('slug')
                    ->searchable()
                    ->sortable()
                    ->toggleable(),

                ImageColumn::make('image')
                    ->toggleable(),

                IconColumn::make('is_active')
                    ->boolean()
                    ->toggleable(),

                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),

                TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                TrashedFilter::make(),
            ])
            ->actions([
                ActionGroup::make([
                    ViewAction::make(),
                    EditAction::make()->before(function ($record, $data) {
                        if ($record->image && $record->image !== $data['image']) {
                            Storage::disk('public')->delete($record->image);
                        }

                        $data['image'] = $record->image;
                    }),
                    DeleteAction::make(),
                    RestoreAction::make(),
                    ForceDeleteAction::make()->after(function ($record) {
                        if ($record->image) {
                            Storage::disk('public')->delete($record->image);
                        }
                    }),
                ])
            ])
            ->bulkActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                    RestoreBulkAction::make(),
                    ForceDeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => ManageBrands::route('/'),
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
        return __('site.brands');
    }

    public static function getNavigationBadge(): ?string
    {
        return static::getEloquentQuery()->count();
    }

    public static function getLabel(): string
    {
        return __('site.brands');
    }

    public static function getModelLabel(): string
    {
        return __('site.brand');
    }

    public static function getPluralModelLabel(): string
    {
        return __('site.brands');
    }
}
