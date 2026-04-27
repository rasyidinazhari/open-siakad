<?php

namespace App\Filament\Resources\MahasiswaResource\Pages;

use App\Filament\Resources\MahasiswaResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateMahasiswa extends CreateRecord
{
    protected static string $resource = MahasiswaResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
{
    // Logika Default Password = NIM jika password kosong saat generate by system
    if (empty($data['password']) && !empty($data['nim'])) {
        $data['password'] = \Illuminate\Support\Facades\Hash::make($data['nim']);
    }

    $user = \App\Models\User::create([
        'name' => $data['name'],
        'email' => $data['email'],
        'password' => $data['password'],
    ]);

    // Dinamis: Assign Role berdasarkan status yang dipilih
    $roleName = $data['status'] === 'Calon Mahasiswa Baru' ? 'Calon Mahasiswa' : 'Mahasiswa';
    $user->assignRole($roleName);

    $data['user_id'] = $user->id;

    unset($data['name'], $data['email'], $data['password']);

    return $data;
}
}
