<?php

namespace App\Filament\Resources\PeriodePendaftaranResource\Pages;

use App\Filament\Resources\PeriodePendaftaranResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditPeriodePendaftaran extends EditRecord
{
    protected static string $resource = PeriodePendaftaranResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
