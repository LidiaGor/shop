<?php

namespace App\Filament\Resources\PageAboutResource\Pages;

use App\Filament\Resources\PageAboutResource;
use Filament\Actions;
use Filament\Resources\Pages\ManageRecords;

class ManagePageAbouts extends ManageRecords
{
    protected static string $resource = PageAboutResource::class;

    protected function getHeaderActions(): array
    {
        return [
//            Actions\CreateAction::make(),
        ];
    }
}
