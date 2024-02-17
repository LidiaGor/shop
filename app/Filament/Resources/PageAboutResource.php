<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PageAboutResource\Pages;
use App\Filament\Resources\PageAboutResource\RelationManagers;
use App\Models\PageAbout;
use Filament\Forms;
use Filament\Forms\Components\Grid;
use Filament\Forms\Form;
use Filament\Forms\Set;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Enums\ActionsPosition;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class PageAboutResource extends Resource
{
    protected static ?string $model = PageAbout::class;
    protected static ?string $navigationGroup = 'Страницы';
    protected static ?string $navigationLabel = 'О нас';
    protected static ?string $modelLabel = '';
    protected static ?string $pluralModelLabel = 'О нас';
    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Grid::make(1)
                    ->schema([
                        Forms\Components\TextInput::make('title')
                            ->label('Заголовок')
                            ->required()
                    ]),
                Grid::make(1)
                    ->schema([
                        Forms\Components\TextInput::make('slug')
                            ->required(),
                    ]),
                Grid::make(1)
                    ->schema([
                        Forms\Components\TextInput::make('phone')
                            ->label('Телефон для связи')
                    ]),
                Grid::make(1)
                    ->schema([
                        Forms\Components\TextInput::make('address')
                            ->label('Адрес')
                    ]),
                Grid::make(1)
                    ->schema([
                        Forms\Components\FileUpload::make('image')
                            ->imagePreviewHeight('250')
                            ->image()
                            ->imageEditor()
                            ->label('Изображение страницы')
                            ->openable(),
                    ]),
                Grid::make(1)
                    ->schema([
                        Forms\Components\RichEditor::make('description')
                            ->label('Описание'),
                    ]),
                Grid::make(1)
                    ->schema([
                        Forms\Components\TextInput::make('meta_title')
                        ->maxLength(255),
                    ]),
                Grid::make(1)
                    ->schema([
                        Forms\Components\TextInput::make('meta_description')
                            ->maxLength(1000),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('title')
                    ->label('Заголовок'),
                Tables\Columns\TextColumn::make('phone')
                    ->label('Телефон для связи'),
                Tables\Columns\TextColumn::make('address')
                    ->label('Адрес'),
                Tables\Columns\ImageColumn::make('image')
                    ->height(100)
                    ->width(200),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make()->iconSize('xs'),
//                Tables\Actions\DeleteAction::make(),
            ]/*, position: ActionsPosition::BeforeColumns*/)
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
//                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ])
            ->emptyStateActions([
                Tables\Actions\CreateAction::make(),
            ])
            ->paginated(false);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ManagePageAbouts::route('/'),
        ];
    }
}
