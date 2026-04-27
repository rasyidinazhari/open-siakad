<?php

namespace App\Filament\Resources\WaktuKuliahResource\Pages;

use App\Filament\Resources\WaktuKuliahResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditWaktuKuliah extends EditRecord
{
    protected static string $resource = WaktuKuliahResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
