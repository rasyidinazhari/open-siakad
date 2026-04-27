<?php

namespace App\Http\Controllers\Mahasiswa;

use App\Http\Controllers\Controller;
use App\Models\Skripsi;
use App\Models\Dosen;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Illuminate\Support\Facades\Auth;

class SkripsiController extends Controller
{
    public function index()
    {
        $mahasiswa = Auth::user()->mahasiswa;
        $skripsi = Skripsi::with('pembimbing.user')->where('mahasiswa_id', $mahasiswa->id)->first();
        $dosens = Dosen::with('user')->get();

        return Inertia::render('Mahasiswa/Skripsi/Index', [
            'skripsi' => $skripsi,
            'dosens' => $dosens
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'judul' => 'required|string|max:255',
            'dosen_pembimbing_id' => 'required|exists:dosens,id',
            'abstrak' => 'nullable|string',
        ]);

        Skripsi::create([
            'mahasiswa_id' => Auth::user()->mahasiswa->id,
            'dosen_pembimbing_id' => $request->dosen_pembimbing_id,
            'judul' => $request->judul,
            'abstrak' => $request->abstrak,
            'status' => 'Diajukan'
        ]);

        return redirect()->back()->with('success', 'Judul skripsi berhasil diajukan.');
    }
}