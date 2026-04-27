<?php

namespace App\Filament\Resources\TagihanKuliahResource\Pages;

use App\Filament\Resources\TagihanKuliahResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListTagihanKuliahs extends ListRecords
{
    protected static string $resource = TagihanKuliahResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
