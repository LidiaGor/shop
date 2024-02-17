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

class PropertyRelationManager extends RelationManager
{
    protected static string $relationship = 'properties';
    protected static ?string $title= 'Свойства';

    protected static ?string $pluralLabel = 'Свойства';
    protected static ?string $pluralModelLabel = 'Свойства';
    protected static ?string $modelLabel = 'Свойства';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')
                    ->label('Имя свойства')
                    ->maxLength(255)
                    ->required(),
                Forms\Components\TextInput::make('value')
                    ->label('Значение свойства')
                    ->nullable()
                    ->maxLength(255),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('name')
            ->columns([
                Tables\Columns\TextColumn::make('name'),
                Tables\Columns\TextColumn::make('value'),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make(),
                Tables\Actions\AttachAction::make()
                    ->preloadRecordSelect()
                    ->form(fn (AttachAction $action): array => [
                        $action->getRecordSelect()
//                            ->createOptionForm([
//                                Forms\Components\TextInput::make('name')
//                                    ->label('Имя свойства')
//                                    ->required(),
//                            ])
                        ,
                        Forms\Components\TextInput::make('value'),
                    ])
                ,
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
