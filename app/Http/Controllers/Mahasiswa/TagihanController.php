<?php 

namespace App\Http\Controllers\Mahasiswa;

use App\Http\Controllers\Controller;
use App\Models\TagihanKuliah;
use Inertia\Inertia;
use Illuminate\Support\Facades\Auth;


class TagihanController extends Controller
{
    public function index()
    {
        $mahasiswa = Auth::user()->mahasiswa;

        // Ambil semua tagihan untuk mahasiswa ini
        $tagihan = TagihanKuliah::with('tahun_akademik')
            ->where('mahasiswa_id', $mahasiswa->id)
            ->orderBy('created_at', 'desc')
            ->get();

        return Inertia::render('Mahasiswa/Tagihan/Index', [
            'tagihan' => $tagihan
        ]);
    }
}