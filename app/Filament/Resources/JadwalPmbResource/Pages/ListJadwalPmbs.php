<?php

namespace App\Filament\Resources\JadwalPmbResource\Pages;

use App\Filament\Resources\JadwalPmbResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListJadwalPmbs extends ListRecords
{
    protected static string $resource = JadwalPmbResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
