<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Dosen extends Model
{
    protected $guarded = [];

    public function user() { return $this->belongsTo(User::class); }

    // Relasi sebagai Dekan di Fakultas
    public function fakultas_dekan(): HasMany
    {
        return $this->hasMany(Fakultas::class, 'dekan_id');
    }

    // Relasi sebagai Kaprodi di Program Studi
    public function prodi_kaprodi(): HasMany
    {
        return $this->hasMany(ProgramStudi::class, 'kaprodi_id');
    }

    // Relasi sebagai pengampu Mata Kuliah
    public function mata_kuliahs(): HasMany
    {
        return $this->hasMany(MataKuliah::class, 'dosen_1_id');
    }

    // Relasi sebagai Dosen Wali mahasiswa saat KRS
    public function mahasiswa_perwalian(): HasMany
    {
        return $this->hasMany(Krs::class, 'dosen_wali_id');
    }

    public function bimbingan_skripsi()
    {
        return $this->hasMany(Skripsi::class, 'dosen_pembimbing_id');
    }
}
