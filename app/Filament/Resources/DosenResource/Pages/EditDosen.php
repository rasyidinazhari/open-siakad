<?php

namespace App\Filament\Resources\DosenResource\Pages;

use App\Filament\Resources\DosenResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditDosen extends EditRecord
{
    protected static string $resource = DosenResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }

    protected function mutateFormDataBeforeFill(array $data): array
    {
        // Mengambil data dari tabel users untuk ditampilkan di form edit
        $user = $this->record->user;
        
        if ($user) {
            $data['name'] = $user->name;
            $data['email'] = $user->email;
        }

        return $data;
    }

    protected function mutateFormDataBeforeSave(array $data): array
    {
        // 1. Update data di tabel users
        $user = $this->record->user;
        $user->update([
            'name' => $data['name'],
            'email' => $data['email'],
        ]);

        // Jika password diisi, update passwordnya
        if (!empty($data['password'])) {
            $user->update([
                'password' => $data['password'],
            ]);
        }

        // 2. Hapus data yang bukan milik tabel dosens agar tidak error SQL
        unset($data['name'], $data['email'], $data['password']);

        return $data;
    }
}
