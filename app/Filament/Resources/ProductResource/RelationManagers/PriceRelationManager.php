<?php

namespace App\Filament\Resources\ProductResource\RelationManagers;

use App\Models\ProductProperty;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Actions\AttachAction;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class PriceRelationManager extends RelationManager
{
    protected static string $relationship = 'lowerPrice';

    protected static ?string $title ='Дополнительные цены';

    protected static ?string $pluralLabel = 'Цены';
    protected static ?string $pluralModelLabel = 'Цены';
    protected static ?string $modelLabel = 'Цены';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('products_price_type_id')
                    ->label('Тип цен')
                    ->placeholder('Выберите тип цен')
                    ->relationship('productsPriceType', 'name')
                    ->searchable()
                    ->unique()
                    ->preload()
                    ->default(1)
                    ->required(),
                Forms\Components\TextInput::make('value')
                    ->label('Цена')
                    ->numeric()
                    ->required(),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('name')
            ->columns([
                Tables\Columns\TextColumn::make('productsPriceType.name')
                    ->label('Тип цен')
                    ->sortable()
                    ->disabledClick(),
                Tables\Columns\TextColumn::make('value'),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make(),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ])
            ->emptyStateActions([
                Tables\Actions\CreateAction::make(),
            ]);
    }
}
