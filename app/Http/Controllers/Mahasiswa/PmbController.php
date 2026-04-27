<?php

namespace App\Http\Controllers\Mahasiswa;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\RedirectResponse;
use App\Models\BerkasPendaftaran;
use Illuminate\Support\Facades\Storage;

class PmbController extends Controller
{
    /**
     * Menyimpan data pendaftaran calon mahasiswa.
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'nik' => 'required|string|size:16',
            'nomor_telepon' => 'required|string',
            'jenis_kelamin' => 'required|in:Laki laki,Perempuan',
            'agama' => 'required|in:Islam,Katholik,Kristen,Hindu,Budha,Konghucu',
            'tempat_lahir' => 'required|string',
            'tanggal_lahir' => 'required|date',
            'alamat_lengkap' => 'required|string',
            'rt' => 'nullable|string',
            'rw' => 'nullable|string',
            'desa_kelurahan' => 'nullable|string',
            'kecamatan' => 'nullable|string',
            'kota_kabupaten' => 'nullable|string',
            'provinsi' => 'nullable|string',
            'kode_pos' => 'nullable|string',
            'jalur_pendaftaran_id' => 'required|exists:jalur_pendaftarans,id',
            'gelombang_id' => 'required|exists:gelombangs,id',
            'jenis_kelas_id' => 'required|exists:jenis_kelas,id',
            'prodi_pilihan_1' => 'required|exists:program_studis,id',
            'prodi_pilihan_2' => 'nullable|exists:program_studis,id',
        ]);

        $mahasiswa = Auth::user()->mahasiswa;

        // Kemas kini profil mahasiswa dengan data dari form
        $mahasiswa->update($request->all());

        return redirect()->back()->with('success', 'Data pendaftaran anda berjaya disimpan. Sila teruskan ke langkah muat naik berkas.');
    }
    public function uploadBerkas(Request $request)
    {
        $request->validate([
            'syarat_id' => 'required|exists:syarat_pendaftarans,id',
            'file' => 'required|file|mimes:pdf,jpg,jpeg,png|max:2048', // Batas 2MB
        ]);
        $user = Auth::user();
        $mahasiswa = $user->mahasiswa;
        $file = $request->file('file');
        
        // Nama file: [NAMA]_[SYARAT_ID]_[TIME].[EXT]
        $fileName = str_replace(' ', '_', $user->name) . '_' . $request->syarat_id . '_' . time() . '.' . $file->getClientOriginalExtension();
        $path = $file->storeAs('berkas_pmb', $fileName, 'public');

        // Simpan atau Update rekaman berkas
        BerkasPendaftaran::updateOrCreate(
            [
                'mahasiswa_id' => $mahasiswa->id,
                'syarat_pendaftaran_id' => $request->syarat_id,
            ],
            [
                'file_path' => $path,
                'status' => 'Pending',
            ]
        );

        return redirect()->back()->with('success', 'Berkas berhasil diunggah.');
    }
}