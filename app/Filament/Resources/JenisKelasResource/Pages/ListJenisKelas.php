<?php

namespace App\Filament\Resources\JenisKelasResource\Pages;

use App\Filament\Resources\JenisKelasResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListJenisKelas extends ListRecords
{
    protected static string $resource = JenisKelasResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
