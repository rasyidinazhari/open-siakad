<?php

namespace App\Filament\Resources\WaktuKuliahResource\Pages;

use App\Filament\Resources\WaktuKuliahResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListWaktuKuliahs extends ListRecords
{
    protected static string $resource = WaktuKuliahResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
