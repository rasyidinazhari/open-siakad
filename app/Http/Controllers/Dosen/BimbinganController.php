<?php
namespace App\Http\Controllers\Dosen;

use App\Http\Controllers\Controller;
use App\Models\Skripsi;
use Inertia\Inertia;
use Illuminate\Support\Facades\Auth;

class BimbinganController extends Controller
{
    public function index()
    {
        $dosen = Auth::user()->dosen;

        $bimbingan = Skripsi::with(['mahasiswa.user', 'mahasiswa.program_studi'])
            ->where('dosen_pembimbing_id', $dosen->id)
            ->get();

        return Inertia::render('Dosen/Bimbingan/Index', [
            'bimbingan' => $bimbingan
        ]);
    }
}