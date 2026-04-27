<?php

namespace App\Http\Controllers\Pmb;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Illuminate\Support\Facades\Auth;
// Gunakan model yang sesuai dengan struktur database kamu (misal PendaftaranPmb atau Mahasiswa)
// use App\Models\PendaftaranPmb; 

class BiodataController extends Controller
{
    public function index()
    {
        // Ambil data pendaftaran milik user yang sedang login
        $pendaftaran = \App\Models\PendaftaranPmb::where('user_id', Auth::id())->first();

        // Kirim data tersebut ke Vue sebagai props
        return Inertia::render('PMB/Biodata/Index', [
            'pendaftaran' => $pendaftaran
        ]);
    }

    public function store(Request $request)
    {
        // Validasi dan simpan biodata
        $request->validate([
            'nik' => 'required|string|max:16',
            'tempat_lahir' => 'required|string',
            'tanggal_lahir' => 'required|date',
            'jenis_kelamin' => 'required|in:Laki-laki,Perempuan',
            'alamat_lengkap' => 'required|string',
            'asal_sekolah' => 'required|string',
        ]);

        \App\Models\PendaftaranPmb::updateOrCreate(
            ['user_id' => Auth::id()], // Cari berdasarkan user_id
            $request->all()              // Simpan data dari form
        );

        // Proses simpan ke database (sesuaikan dengan nama tabelmu)
        // PendaftaranPmb::updateOrCreate(
        //     ['user_id' => auth()->id()],
        //     $request->all()
        // );

        return redirect()->back()->with('success', 'Biodata berhasil diperbarui.');
    }
}