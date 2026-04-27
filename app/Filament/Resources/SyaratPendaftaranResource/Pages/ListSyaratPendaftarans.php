<?php

namespace App\Filament\Resources\SyaratPendaftaranResource\Pages;

use App\Filament\Resources\SyaratPendaftaranResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListSyaratPendaftarans extends ListRecords
{
    protected static string $resource = SyaratPendaftaranResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
