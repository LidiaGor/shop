<?php

namespace App\Filament\Resources\ProductsGroupsResource\Pages;

use App\Filament\Resources\ProductsGroupsResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditProductsGroups extends EditRecord
{
    protected static string $resource = ProductsGroupsResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
