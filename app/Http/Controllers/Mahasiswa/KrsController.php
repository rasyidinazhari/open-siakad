<?php

namespace App\Http\Controllers\Mahasiswa;

use App\Http\Controllers\Controller;
use App\Models\TagihanKuliah;
use App\Models\JadwalKuliah;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Illuminate\Support\Facades\Auth;
use App\Models\Krs;
use App\Models\TahunAkademik;

class KrsController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $mahasiswa = $user->mahasiswa;

        // 1. Cek Tagihan Kuliah (Blocking Logic) [cite: 69]
        $tagihanPending = TagihanKuliah::where('mahasiswa_id', $mahasiswa->id)
            ->where('status', 'Belum Lunas')
            ->exists();

        if ($tagihanPending) {
            return Inertia::render('Mahasiswa/Krs/Blocked', [
                'message' => 'Anda memiliki tagihan yang belum dilunasi. Silakan hubungi bagian keuangan untuk dapat mengisi KRS.'
            ]);
        }

        // 2. Ambil Jadwal Kuliah yang tersedia untuk semester aktif [cite: 30, 31]
        $jadwals = JadwalKuliah::with(['mata_kuliah', 'dosen.user', 'ruang', 'waktu_kuliah'])
            ->get();

        return Inertia::render('Mahasiswa/Krs/Index', [
            'mahasiswa' => $mahasiswa,
            'jadwals' => $jadwals,
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'jadwal_ids' => 'required|array|min:1',
            'jadwal_ids.*' => 'exists:jadwal_kuliahs,id'
        ]);

        $mahasiswa = Auth::user()->mahasiswa;
        
        // Ambil Tahun Akademik yang sedang aktif
        $tahunAkademik = TahunAkademik::where('status', 'Aktif')->first();
        
        if (!$tahunAkademik) {
            return back()->with('error', 'Tahun Akademik aktif belum diatur oleh Admin.');
        }

        // Hitung total SKS berdasarkan jadwal yang dipilih
        $jadwals = JadwalKuliah::whereIn('id', $request->jadwal_ids)->get();
        $totalSks = $jadwals->sum('beban_sks');

        // Buat record KRS (Header)
        $krs = Krs::create([
            'mahasiswa_id' => $mahasiswa->id,
            'tahun_akademik_id' => $tahunAkademik->id,
            'semester' => $mahasiswa->semester,
            // Asumsi: Dosen Wali di-assign oleh admin. Jika null, beri nilai fallback atau tampilkan error.
            'dosen_wali_id' => 1, // Ganti dengan logika Dosen Wali yang sebenarnya jika ada
            'total_sks' => $totalSks,
            'status' => 'Pending',
        ]);

        // Simpan detail mata kuliah yang diambil (Pivot)
        $krs->jadwal_kuliahs()->attach($request->jadwal_ids);

        return redirect()->route('mahasiswa.dashboard')->with('success', 'KRS berhasil diajukan dan sedang menunggu persetujuan Dosen Wali.');
    }
}