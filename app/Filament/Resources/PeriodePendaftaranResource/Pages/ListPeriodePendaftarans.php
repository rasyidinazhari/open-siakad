<?php

namespace App\Filament\Resources\PeriodePendaftaranResource\Pages;

use App\Filament\Resources\PeriodePendaftaranResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListPeriodePendaftarans extends ListRecords
{
    protected static string $resource = PeriodePendaftaranResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
