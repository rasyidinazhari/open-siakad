<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class RolePermissionSeeder extends Seeder
{
    public function run(): void
    {
        // Reset cached roles and permissions
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // 1. Buat Daftar Permissions Sesuai Modul Akses di Dokumen
        $permissions = [
            'akses_admin_panel',
            'akses_akademik',       // Akses semua halaman akademik
            'akses_keuangan',       // Akses semua halaman keuangan
            'akses_kemahasiswaan',  // Akses semua halaman kemahasiswaan
            'akses_publikasi',      // Akses semua halaman publikasi (Perpustakaan)
            'akses_infrastruktur',  // Akses semua halaman infrastruktur
            'akses_admisi',         // Akses halaman PTB/PMB
            'akses_data_dosen',     // Akses data pengguna dosen (untuk Umum)
        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission]);
        }

        // 2. Buat Roles & Assign Permissions
        
        // A. Role Staff (Sub-role berdasarkan Departemen)
        $roleWebAdmin = Role::firstOrCreate(['name' => 'Web Administrator']);
        // Web Admin punya akses ke semuanya secara default (bisa di-handle via Gate SuperAdmin nanti, tapi kita beri full permission dulu)
        $roleWebAdmin->givePermissionTo(Permission::all());

        $roleAkademik = Role::firstOrCreate(['name' => 'Akademik']);
        $roleAkademik->givePermissionTo(['akses_admin_panel', 'akses_akademik']);

        $roleKeuangan = Role::firstOrCreate(['name' => 'Keuangan']);
        $roleKeuangan->givePermissionTo(['akses_admin_panel', 'akses_keuangan']);

        $roleKemahasiswaan = Role::firstOrCreate(['name' => 'Kemahasiswaan']);
        $roleKemahasiswaan->givePermissionTo(['akses_admin_panel', 'akses_kemahasiswaan']);

        $rolePerpustakaan = Role::firstOrCreate(['name' => 'Perpustakaan']);
        $rolePerpustakaan->givePermissionTo(['akses_admin_panel', 'akses_publikasi']);

        $roleInfrastruktur = Role::firstOrCreate(['name' => 'Infrastruktur & IT']);
        $roleInfrastruktur->givePermissionTo(['akses_admin_panel', 'akses_infrastruktur']);

        $roleAdmisi = Role::firstOrCreate(['name' => 'Admisi']);
        $roleAdmisi->givePermissionTo(['akses_admin_panel', 'akses_admisi']);

        $roleUmum = Role::firstOrCreate(['name' => 'Umum']);
        $roleUmum->givePermissionTo(['akses_admin_panel', 'akses_infrastruktur', 'akses_data_dosen']);

        // B. Role Dosen
        Role::firstOrCreate(['name' => 'Dosen']); // Izin spesifiknya akan diatur via logic di portal Vue

        // C. Role Mahasiswa & Calon Mahasiswa
        Role::firstOrCreate(['name' => 'Mahasiswa']); 
        Role::firstOrCreate(['name' => 'Calon Mahasiswa']);

        // 3. (Opsional tapi Penting) Buat 1 Akun Super Admin untuk Testing Awal
        $adminUser = User::firstOrCreate([
            'email' => 'admin@siakad.com',
        ], [
            'name' => 'Super Administrator',
            'password' => Hash::make('password123'),
        ]);

        $adminUser->assignRole('Web Administrator');
    }
}