<?php
namespace App\Http\Controllers\Mahasiswa;

use App\Http\Controllers\Controller;
use App\Models\Krs;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;
use Illuminate\Support\Facades\Auth;

class TranskripController extends Controller
{
    public function index()
    {
        $mahasiswa = Auth::user()->mahasiswa;

        // Ambil semua detail nilai dari semua KRS yang sudah disetujui
        $transkrip = DB::table('krs_details')
            ->join('krs', 'krs_details.krs_id', '=', 'krs.id')
            ->join('jadwal_kuliahs', 'krs_details.jadwal_kuliah_id', '=', 'jadwal_kuliahs.id')
            ->join('mata_kuliahs', 'jadwal_kuliahs.mata_kuliah_id', '=', 'mata_kuliahs.id')
            ->where('krs.mahasiswa_id', $mahasiswa->id)
            ->where('krs.status', 'Approved')
            ->select(
                'mata_kuliahs.kode_mata_kuliah',
                'mata_kuliahs.nama_mata_kuliah',
                'jadwal_kuliahs.beban_sks',
                'krs_details.nilai_huruf',
                'krs.semester'
            )
            ->orderBy('krs.semester')
            ->get();

        // Hitung IPK Kumulatif
        $totalBobot = 0;
        $totalSks = 0;

        foreach ($transkrip as $item) {
            $bobot = match($item->nilai_huruf) {
                'A' => 4, 'B' => 3, 'C' => 2, 'D' => 1, default => 0
            };
            $totalBobot += ($bobot * $item->beban_sks);
            $totalSks += $item->beban_sks;
        }

        $ipk = $totalSks > 0 ? round($totalBobot / $totalSks, 2) : 0;

        return Inertia::render('Mahasiswa/Transkrip/Index', [
            'transkrip' => $transkrip,
            'ipk' => $ipk,
            'totalSks' => $totalSks
        ]);
    }
}