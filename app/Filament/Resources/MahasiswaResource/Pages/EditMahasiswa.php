<?php

namespace App\Filament\Resources\MahasiswaResource\Pages;

use App\Filament\Resources\MahasiswaResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Support\Facades\DB;

class EditMahasiswa extends EditRecord
{
    protected static string $resource = MahasiswaResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }

    /**
     * Menarik data 'name' dan 'email' dari tabel users agar tampil di form edit
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
     * Menyimpan perubahan ke tabel users dan mahasiswas secara sinkron
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

            // Update password hanya jika diisi (opsional saat edit)
            if (!empty($data['password'])) {
                $userData['password'] = $data['password'];
            }

            $user->update($userData);

            // 2. Sinkronisasi Role berdasarkan status (opsional jika dibutuhkan)
            if ($data['status'] === 'Mahasiswa Aktif') {
                $user->syncRoles(['Mahasiswa']);
            } elseif ($data['status'] === 'Calon Mahasiswa Baru') {
                $user->syncRoles(['Calon Mahasiswa']);
            }

            // 3. Bersihkan field yang tidak ada di tabel mahasiswas agar tidak error SQL
            unset($data['name'], $data['email'], $data['password']);

            return $data;
        });
    }

    /**
     * Redirect kembali ke daftar mahasiswa setelah simpan
     */
    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
