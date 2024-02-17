<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ProductResource\Pages;
use App\Filament\Resources\ProductResource\RelationManagers;
use App\Filament\Resources\ProductResource\RelationManagers\PropertyRelationManager;
use App\Models\Product;
use Filament\Forms;
use Filament\Forms\Components\Fieldset;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Section;
use Filament\Forms\Form;
use Filament\Forms\Set;
use Filament\Resources\Resource;
use Filament\Support\Enums\FontWeight;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class ProductResource extends Resource
{
    protected static ?string $model = Product::class;
    protected static ?string $navigationIcon = 'heroicon-o-shopping-bag';
    protected static ?string $navigationGroup = 'Catalog';
    protected static ?string $navigationLabel = 'Товары';
    protected static ?string $modelLabel = '';
    protected static ?string $pluralModelLabel = 'Товары';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Grid::make(2)
                    ->schema([
                        Grid::make(1)
                            ->columnSpan(1)
                            ->schema([

                                Grid::make(6)
                                    ->columnSpan(1)
                                    ->schema([
                                        Forms\Components\Toggle::make('active')
                                            ->label('Активен')
                                            ->inline(false)
                                            ->default(1),
                                        Forms\Components\TextInput::make('article')
                                            ->label('Артикул')
                                            ->columnSpan(2)
                                            ->maxLength(255)
                                            ->required(),
                                        Forms\Components\TextInput::make('sort')
                                            ->label('Сортировка')
                                            ->numeric()
                                            ->columnSpan(1)
                                            ->required()
                                            ->default(5000),
                                        Forms\Components\TextInput::make('price')
                                            ->label('Базовая цена')
                                            ->numeric()
                                            ->columnSpan(2)
                                            ->required()
                                            ->default(5000),
                                    ]),
                                Forms\Components\TextInput::make('name')
                                    ->label('Наименование')
                                    ->maxLength(255)
                                    ->afterStateUpdated(function (Set $set, ?string $state) {
                                        $set('slug', Str::slug($state));
                                    })
                                    ->live(true, 600)
                                    ->required(),
                                Forms\Components\TextInput::make('slug')
                                    ->unique(ignoreRecord: true)
                                    ->required(),

                                Forms\Components\Select::make('products_groups')
                                    ->multiple()
                                    ->relationship('products_groups', 'name')
                                    ->label('Группы товара')
                                    ->searchable()
                                    ->preload(),
                            ]),

                        Grid::make(1)
                            ->columnSpan(1)
                            ->schema([
                                Forms\Components\FileUpload::make('gallery')
                                    ->imagePreviewHeight('150')
                                    ->panelLayout('compact')
                                    ->image()
                                    ->imageEditor()
                                    ->label('Галерея изображений товара')
                                    ->multiple()
                                    ->reorderable()
                                    ->disk('product')
                                    ->openable()
                            ]),
                    ]),

            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
//                Tables\Columns\TextColumn::make('index')->label('№ п/п')
//                    ->rowIndex()
//                    ->disabledClick(),
                Tables\Columns\TextColumn::make('id')
                    ->label('id')
                    ->sortable()
//                    ->hidden(!Auth::user()->can('can_change_status'))
                    ->disabledClick(),
                Tables\Columns\TextColumn::make('sort')
                    ->label('Сортировка')
                    ->sortable()
                    ->disabledClick(),
                Tables\Columns\ToggleColumn::make('active')
                    ->label('Активеность')
                    ->disabledClick(),
                Tables\Columns\TextColumn::make('name')
                    ->label('Наименование')
                    ->weight(FontWeight::Bold)
                    ->sortable()
                    ->disabledClick(),
                Tables\Columns\TextColumn::make('price')
                    ->label('Цена')
                    ->sortable()
                    ->disabledClick(),
                Tables\Columns\TextColumn::make('lowprice')
                    ->label('Дискаунт')
                    ->sortable()
                    ->disabledClick(),
                Tables\Columns\TextColumn::make('oldprice')
                    ->label('Старая цена')
                    ->sortable()
                    ->disabledClick(),
//                Tables\Columns\ImageColumn::make('gallery')
//                    ->limit(3)
//                    ->height(60)
//                    ->width(80)
//                    ->disk('product')
//                    ->disabledClick(),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make()
                    ->button()
                    ->size('xs')
                    ->iconSize('xs'),
                Tables\Actions\DeleteAction::make()
                    ->button()
                    ->size('xs')
                    ->iconSize('xs'),
                Tables\Actions\RestoreAction::make()
                    ->button()
                    ->size('xs')
                    ->iconSize('xs'),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ])
            ->emptyStateActions([
                Tables\Actions\CreateAction::make(),
            ])
            ->defaultSort('id', 'desc');
    }

    public static function getRelations(): array
    {
        return [
            RelationManagers\PriceRelationManager::class,
            PropertyRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListProducts::route('/'),
            'create' => Pages\CreateProduct::route('/create'),
            'edit' => Pages\EditProduct::route('/{record}/edit'),
        ];
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->withoutGlobalScopes([
                SoftDeletingScope::class,
            ]);
    }
}
