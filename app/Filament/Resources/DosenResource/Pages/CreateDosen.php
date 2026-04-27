<?php

namespace App\Filament\Resources\DosenResource\Pages;

use App\Filament\Resources\DosenResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateDosen extends CreateRecord
{
    protected static string $resource = DosenResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
{
    $user = \App\Models\User::create([
        'name' => $data['name'],
        'email' => $data['email'],
        'password' => $data['password'],
    ]);

    // Berikan role Dosen secara otomatis
    $user->assignRole('Dosen');

    $data['user_id'] = $user->id;

    // Hapus data yang tidak ada di tabel dosens
    unset($data['name'], $data['email'], $data['password']);

    return $data;
}
}


