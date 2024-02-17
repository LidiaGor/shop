<?php

namespace App\Filament\Resources\ProductsGroupsResource\Pages;

use App\Filament\Resources\ProductsGroupsResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListProductsGroups extends ListRecords
{
    protected static string $resource = ProductsGroupsResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
