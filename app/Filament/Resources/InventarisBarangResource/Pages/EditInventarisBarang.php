<?php

namespace App\Filament\Resources\InventarisBarangResource\Pages;

use App\Filament\Resources\InventarisBarangResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditInventarisBarang extends EditRecord
{
    protected static string $resource = InventarisBarangResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
