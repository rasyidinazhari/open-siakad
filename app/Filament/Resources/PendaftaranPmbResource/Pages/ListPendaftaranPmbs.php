<?php

namespace App\Filament\Resources\PendaftaranPmbResource\Pages;

use App\Filament\Resources\PendaftaranPmbResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListPendaftaranPmbs extends ListRecords
{
    protected static string $resource = PendaftaranPmbResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
