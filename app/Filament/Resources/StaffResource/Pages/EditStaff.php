<?php

namespace App\Filament\Resources\StaffResource\Pages;

use App\Filament\Resources\StaffResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Support\Facades\DB;

class EditStaff extends EditRecord
{
    protected static string $resource = StaffResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }

    /**
     * Mengambil data dari tabel User sebelum form ditampilkan
     */
    protected function mutateFormDataBeforeFill(array $data): array
    {
        $user = $this->record->user;

        if ($user) {
            $data['name'] = $user->name;
            $data['email'] = $user->email;
        }

        return $data;
    }

    /**
     * Menyimpan perubahan ke tabel User dan Staff secara bersamaan
     */
    protected function mutateFormDataBeforeSave(array $data): array
    {
        return DB::transaction(function () use ($data) {
            $user = $this->record->user;

            // 1. Update data dasar User
            $userData = [
                'name' => $data['name'],
                'email' => $data['email'],
            ];

            // Hanya update password jika diisi di form
            if (!empty($data['password'])) {
                $userData['password'] = $data['password'];
            }

            $user->update($userData);

            // 2. Sync Role Spatie (jika departemen berubah)
            // Ini akan menghapus role lama dan memberikan role departemen yang baru
            $user->syncRoles([$data['departement']]);

            // 3. Hapus field yang bukan milik tabel staffs agar tidak error SQL
            unset($data['name'], $data['email'], $data['password']);

            return $data;
        });
    }

    /**
     * Redirect kembali ke daftar staff setelah berhasil edit
     */
    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
