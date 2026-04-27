<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

use App\Models\ProgramStudi;


class Mahasiswa extends Model
{
    protected $guarded = [];

    public function user() { return $this->belongsTo(User::class); }

    // Relasi ke Program Studi
    public function program_studi(): BelongsTo
    {
        return $this->belongsTo(ProgramStudi::class);
    }

    // Riwayat KRS
    public function krs(): HasMany
    {
        return $this->hasMany(Krs::class);
    }

    // Riwayat KHS
    public function khs(): HasMany
    {
        return $this->hasMany(Khs::class);
    }

    public function pembayaran(): HasMany
    {
        // Pastikan nama modelnya PembayaranPmb dan foreign key-nya mahasiswa_id
        return $this->hasMany(PembayaranPmb::class, 'mahasiswa_id');
    }

    // Riwayat Tagihan Pembayaran
    public function tagihans(): HasMany
    {
        return $this->hasMany(TagihanKuliah::class);
    }

    public function generateNim()
    {
        $tahun = date('y'); // Mengambil 2 digit tahun sekarang (misal: 26)
        $prodi = ProgramStudi::find($this->program_studi_id);
        $kodeProdi = $prodi ? str_pad($prodi->kode_prodi, 3, '0', STR_PAD_LEFT) : '000';

        $lastMahasiswa = self::where('nim', 'like', $tahun . $kodeProdi . '%')
            ->orderBy('nim', 'desc')
            ->first();

        $lastNumber = $lastMahasiswa ? intval(substr($lastMahasiswa->nim, -3)) : 0;
        $newNumber = str_pad($lastNumber + 1, 3, '0', STR_PAD_LEFT);

        return $tahun . $kodeProdi . $newNumber;
    }
    public function skripsi()
    {
        return $this->hasOne(Skripsi::class);
    }

    

}
