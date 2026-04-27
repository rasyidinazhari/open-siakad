<?php

namespace App\Filament\Resources\SyaratPendaftaranResource\Pages;

use App\Filament\Resources\SyaratPendaftaranResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditSyaratPendaftaran extends EditRecord
{
    protected static string $resource = SyaratPendaftaranResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
