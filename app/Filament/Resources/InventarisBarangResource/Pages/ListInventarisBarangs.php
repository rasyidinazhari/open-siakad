<?php

namespace App\Filament\Resources\InventarisBarangResource\Pages;

use App\Filament\Resources\InventarisBarangResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListInventarisBarangs extends ListRecords
{
    protected static string $resource = InventarisBarangResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
