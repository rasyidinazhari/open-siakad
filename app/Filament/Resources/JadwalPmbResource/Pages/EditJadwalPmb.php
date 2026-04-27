<?php

namespace App\Filament\Resources\JadwalPmbResource\Pages;

use App\Filament\Resources\JadwalPmbResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditJadwalPmb extends EditRecord
{
    protected static string $resource = JadwalPmbResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
