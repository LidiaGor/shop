<?php

namespace App\Filament\Resources;

use App\Filament\Resources\BannerResource\Pages;
use App\Models\Banner;
use Filament\Tables\Actions\DeleteAction;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Model;

class BannerResource extends Resource
{
    protected static ?string $model = Banner::class;
    protected static ?int $navigationSort = -2;

    protected static ?string $navigationIcon = 'heroicon-o-photo';

    protected static ?string $navigationGroup = 'Marketing';
    protected static ?string $pluralModelLabel = 'Баннеры';
    protected static ?string $navigationLabel = 'Баннеры';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')
                    ->label('Наименование')
                    ->maxLength(255)
                    ->required(),
                Forms\Components\TextInput::make('sort')
                    ->label('Сортировка')
                    ->default(5000),
                Forms\Components\TextInput::make('link')
                    ->label('Ссылка с баннера')
                    ->maxLength(255),
                Forms\Components\Select::make('type')
                    ->options([
                        '1' => 'Горизонтальный',
                        '2' => 'Прямоугольный',
                    ])
                    ->label('Тип баннера'),
                Forms\Components\Textarea::make('description')
                    ->label('Текст'),
                Forms\Components\FileUpload::make('image')
                    ->label('Изображение')
                    ->imagePreviewHeight('250')
                    ->image()
                    ->directory('banners')
                    ->openable(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('id'),
                TextColumn::make('sort')
                ->label('Сортировка'),
                TextColumn::make('name')
                    ->label('Наименование'),
                ImageColumn::make('image')
                    ->label('Изображение'),
                Tables\Columns\TextColumn::make('type')
                    ->getStateUsing(fn(Model $record) => match ($record->type) {
                        1 => 'Горизонтальный',
                        2 => 'Прямоугольный',
                    })
                    ->label('Тип баннера'),
                TextColumn::make('link')
                    ->label('Ссылка'),
                TextColumn::make('created_at')
                    ->label('Дата создания'),
            ])
            ->filters([
                //
            ])
            ->actions([
                EditAction::make(),
//                DeleteAction::make()
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
//                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ])
            ->emptyStateActions([
//                Tables\Actions\CreateAction::make(),
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
            'index' => Pages\ListBanners::route('/'),
//            'create' => Pages\CreateBanner::route('/create'),
            'edit' => Pages\EditBanner::route('/{record}/edit'),
        ];
    }
}
