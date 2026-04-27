<?php

namespace App\Http\Controllers\Mahasiswa;

use App\Http\Controllers\Controller;
use App\Models\Krs;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;
use Illuminate\Support\Facades\Auth;

class KhsController extends Controller
{
    public function index()
    {
        $mahasiswa = Auth::user()->mahasiswa;

        // Ambil semua KRS yang sudah diajukan (untuk navigasi per semester)
        $daftarKrs = Krs::with('tahun_akademik')
            ->where('mahasiswa_id', $mahasiswa->id)
            ->where('status', 'Approved')
            ->get();

        return Inertia::render('Mahasiswa/Khs/Index', [
            'daftarKrs' => $daftarKrs,
        ]);
    }

    public function show($id)
    {
        $mahasiswa = Auth::user()->mahasiswa;
        
        // Ambil detail KRS dan nilai per mata kuliah
        $krs = Krs::with(['tahun_akademik', 'jadwal_kuliahs.mata_kuliah'])
            ->where('mahasiswa_id', $mahasiswa->id)
            ->findOrFail($id);

        // Ambil nilai dari krs_details
        $nilai = DB::table('krs_details')
            ->where('krs_id', $krs->id)
            ->get();

        // Logika perhitungan IPS (Sederhana)
        $totalBobot = 0;
        $totalSks = 0;

        foreach ($krs->jadwal_kuliahs as $jadwal) {
            $n = $nilai->where('jadwal_kuliah_id', $jadwal->id)->first();
            $bobot = match($n?->nilai_huruf) {
                'A' => 4,
                'B' => 3,
                'C' => 2,
                'D' => 1,
                default => 0
            };
            
            $totalBobot += ($bobot * $jadwal->beban_sks);
            $totalSks += $jadwal->beban_sks;
        }

        $ips = $totalSks > 0 ? round($totalBobot / $totalSks, 2) : 0;

        return Inertia::render('Mahasiswa/Khs/Show', [
            'krs' => $krs,
            'nilai' => $nilai,
            'ips' => $ips
        ]);
    }
}