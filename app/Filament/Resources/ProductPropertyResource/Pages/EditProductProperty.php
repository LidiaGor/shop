<?php

namespace App\Filament\Resources\ProductPropertyResource\Pages;

use App\Filament\Resources\ProductPropertyResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditProductProperty extends EditRecord
{
    protected static string $resource = ProductPropertyResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
