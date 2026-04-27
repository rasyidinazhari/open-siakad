<?php

namespace App\Http\Controllers\Dosen;

use App\Http\Controllers\Controller;
use App\Models\Krs;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Illuminate\Support\Facades\Auth;

class PerwalianController extends Controller
{
    public function index()
    {
        $dosen = Auth::user()->dosen;

        // Ambil daftar KRS mahasiswa bimbingan dosen ini
        $perwalian = Krs::with(['mahasiswa.user', 'tahun_akademik'])
            ->where('dosen_wali_id', $dosen->id)
            ->latest()
            ->get();

        return Inertia::render('Dosen/Perwalian/Index', [
            'perwalian' => $perwalian
        ]);
    }

    public function show(Krs $krs)
    {
        // Load detail mata kuliah yang diambil
        $krs->load(['mahasiswa.user', 'mahasiswa.program_studi', 'jadwal_kuliahs.mata_kuliah', 'jadwal_kuliahs.waktu_kuliah']);

        return Inertia::render('Dosen/Perwalian/Show', [
            'krs' => $krs
        ]);
    }

    public function approve(Krs $krs)
    {
        $krs->update(['status' => 'Approved']);
        return redirect()->route('dosen.perwalian.index')->with('success', 'KRS Mahasiswa telah disetujui.');
    }

    public function reject(Request $request, Krs $krs)
    {
        $request->validate(['catatan' => 'required|string']);
        
        $krs->update([
            'status' => 'Rejected',
            'catatan' => $request->catatan
        ]);
        
        return redirect()->route('dosen.perwalian.index')->with('success', 'KRS Mahasiswa telah ditolak dengan catatan.');
    }
}
