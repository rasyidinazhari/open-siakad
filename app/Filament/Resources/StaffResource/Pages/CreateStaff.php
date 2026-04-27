<?php

namespace App\Filament\Resources\StaffResource\Pages;

use App\Filament\Resources\StaffResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateStaff extends CreateRecord
{
    protected static string $resource = StaffResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
{
    // 1. Create User terlebih dahulu
    $user = \App\Models\User::create([
        'name' => $data['name'],
        'email' => $data['email'],
        'password' => $data['password'],
    ]);

    // 2. Assign Role Spatie berdasarkan Departemen 
    $user->assignRole($data['departement']);

    // 3. Masukkan user_id ke data Staff yang akan disimpan
    $data['user_id'] = $user->id;

    // 4. Hapus data yang bukan milik tabel staffs agar tidak error saat insert
    unset($data['name'], $data['email'], $data['password']);

    return $data;
}
}
