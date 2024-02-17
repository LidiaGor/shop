<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ProductsGroupsResource\Pages;
use App\Filament\Resources\ProductsGroupsResource\RelationManagers;
use App\Models\ProductsGroups;
use Filament\Forms;
use Filament\Forms\Components\Grid;
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

class ProductsGroupsResource extends Resource
{
    protected static ?string $model = ProductsGroups::class;
    protected static ?string $navigationIcon = 'heroicon-o-rectangle-group';
    protected static ?string $navigationGroup='Catalog';
    protected static ?string $navigationLabel = 'Группы товаров';
    protected static ?string $modelLabel = '';
    protected static ?string $pluralModelLabel = 'Группы товаров';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Grid::make(7)
                    ->schema([
                        Forms\Components\Checkbox::make('active')
                            ->label('Активность')
                            ->inline(false)
                            ->default(1),
                        Forms\Components\TextInput::make('sort')
                            ->label('Сортировка')
                            ->required()
                            ->default(5000),
                        Forms\Components\TextInput::make('name')
                            ->columnSpan(3)
                            ->label('Наименование')
                            ->maxLength(255)
                            ->debounce(600)
                            ->afterStateUpdated(function (Set $set, ?string $state) {
                                $set('slug', Str::slug($state));
                            })
                            ->required(),
                        Forms\Components\TextInput::make('slug')
                            ->columnSpan(2)
                            ->unique('products_groups', ignoreRecord: true)
                            ->required(),
                        ]),
                Grid::make(2)
                    ->schema([
                        Forms\Components\Select::make('products_group_id')
                            ->relationship('parentGroup' ,'name')
                            ->label('Родительская группа')
                            ->searchable()
                            ->preload(),
                        Forms\Components\Select::make('Товары группы')
                            ->multiple()
                            ->relationship('product_products_groups','name')
        //                    ->label('Товары группы')
                            ->searchable()
                            ->preload(),
                    ])
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('index')->label('№ п/п')
                    ->rowIndex()
                    ->disabledClick(),
                Tables\Columns\TextColumn::make('id')
                    ->label('id')
                    ->sortable()
                    ->hidden(!Auth::user()->can('can_change_status'))
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
                Tables\Columns\TextColumn::make('parentGroup.name')
                    ->label('Родительская группа')
                    ->sortable()
                    ->disabledClick(),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make()->button()->size('xs')->iconSize('xs'),
                Tables\Actions\DeleteAction::make()->button()->size('xs')->iconSize('xs'),
                Tables\Actions\RestoreAction::make()->button()->size('xs')->iconSize('xs'),
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
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListProductsGroups::route('/'),
            'create' => Pages\CreateProductsGroups::route('/create'),
            'edit' => Pages\EditProductsGroups::route('/{record}/edit'),
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
