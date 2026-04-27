<?php

namespace App\Filament\Resources\TagihanKuliahResource\Pages;

use App\Filament\Resources\TagihanKuliahResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditTagihanKuliah extends EditRecord
{
    protected static string $resource = TagihanKuliahResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
