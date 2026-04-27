<?php
namespace App\Http\Controllers\Dosen;

use App\Http\Controllers\Controller;
use App\Models\JadwalKuliah;
use Inertia\Inertia;
use Illuminate\Support\Facades\Auth;

class JadwalController extends Controller
{
    public function index()
    {
        $dosen = Auth::user()->dosen;

        $jadwal = JadwalKuliah::with(['mata_kuliah', 'ruang', 'waktu_kuliah', 'jenis_kelas'])
            ->where('dosen_id', $dosen->id)
            ->orderBy('hari')
            ->get();

        return Inertia::render('Dosen/Jadwal/Index', [
            'jadwal' => $jadwal
        ]);
    }
}