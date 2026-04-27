<?php

namespace App\Http\Controllers\Dosen;

use App\Http\Controllers\Controller;
use App\Models\JadwalKuliah;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;
use Illuminate\Support\Facades\Auth;

class PenilaianController extends Controller
{
    // 1. Menampilkan daftar kelas yang diampu Dosen
    public function index()
    {
        $dosen = Auth::user()->dosen;

        $jadwals = JadwalKuliah::with(['mata_kuliah', 'ruang', 'waktu_kuliah'])
            ->where('dosen_id', $dosen->id)
            ->get();

        return Inertia::render('Dosen/Penilaian/Index', [
            'jadwals' => $jadwals
        ]);
    }

    // 2. Menampilkan daftar mahasiswa di dalam kelas tersebut untuk diinput nilainya
    public function show(JadwalKuliah $jadwal)
    {
        $jadwal->load(['mata_kuliah']);

        // Ambil data krs_details (mahasiswa yang mengambil jadwal ini dan KRS-nya sudah di-Approve)
        $peserta = DB::table('krs_details')
            ->join('krs', 'krs_details.krs_id', '=', 'krs.id')
            ->join('mahasiswas', 'krs.mahasiswa_id', '=', 'mahasiswas.id')
            ->join('users', 'mahasiswas.user_id', '=', 'users.id')
            ->where('krs_details.jadwal_kuliah_id', $jadwal->id)
            ->where('krs.status', 'Approved')
            ->select(
                'krs_details.id as krs_detail_id',
                'users.name as nama_mahasiswa',
                'mahasiswas.nim',
                'krs_details.nilai_angka',
                'krs_details.nilai_huruf'
            )
            ->get();

        return Inertia::render('Dosen/Penilaian/Show', [
            'jadwal' => $jadwal,
            'peserta' => $peserta
        ]);
    }

    // 3. Menyimpan nilai yang diinput oleh Dosen
    public function store(Request $request, JadwalKuliah $jadwal)
    {
        $request->validate([
            'nilai' => 'required|array',
            'nilai.*.krs_detail_id' => 'required|exists:krs_details,id',
            'nilai.*.angka' => 'nullable|numeric|min:0|max:100',
        ]);

        foreach ($request->nilai as $item) {
            $angka = $item['angka'];
            $huruf = null;
            $status = 'Pending';

            if ($angka !== null) {
                // Konversi Angka ke Huruf sederhana
                if ($angka >= 85) { $huruf = 'A'; $status = 'Lulus'; }
                elseif ($angka >= 70) { $huruf = 'B'; $status = 'Lulus'; }
                elseif ($angka >= 55) { $huruf = 'C'; $status = 'Lulus'; }
                elseif ($angka >= 40) { $huruf = 'D'; $status = 'Tidak Lulus'; }
                else { $huruf = 'E'; $status = 'Tidak Lulus'; }
            }

            DB::table('krs_details')
                ->where('id', $item['krs_detail_id'])
                ->update([
                    'nilai_angka' => $angka,
                    'nilai_huruf' => $huruf,
                    'status_kelulusan' => $status,
                ]);
        }

        return redirect()->back()->with('success', 'Nilai kelas berhasil disimpan.');
    }
}
