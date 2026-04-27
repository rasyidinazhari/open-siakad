<?php 

namespace App\Http\Controllers\Pmb;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;

class BerkasController extends Controller
{
    public function index()
    {
        // Ambil data pendaftaran untuk mengetahui jalur yang dipilih
        // Kita asumsikan ada relasi ke tabel 'syarat_pendaftarans' sesuai dokumen
        $user = Auth::user();
        $pendaftaran = $user->pendaftaran; // Sesuaikan dengan model Anda

        return Inertia::render('PMB/Berkas/Index', [
            'pendaftaran' => $pendaftaran,
            // Opsional: Kirim daftar syarat dari database
            // 'syarat' => SyaratPendaftaran::where('jalur_pendaftaran_id', $pendaftaran->jalur_id)->get()
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'berkas' => 'required|file|mimes:pdf,jpg,jpeg,png|max:2048',
            'jenis_berkas' => 'required|string'
        ]);

        if ($request->hasFile('berkas')) {
            $file = $request->file('berkas');
            
            // Simpan file ke folder storage/app/public/pmb/berkas/{user_id}
            $path = $file->store('pmb/berkas/' . Auth::id(), 'public');

            // Ambil data pendaftaran milik user yang sedang login
            // Asumsi: model User memiliki relasi pendaftaran()
            $pendaftaran = Auth::user()->pendaftaran; 

            // Jika menggunakan query manual (hapus tanda // di bawah ini jika relasi belum ada):
            // $pendaftaran = \App\Models\PendaftaranPmb::where('user_id', Auth::id())->first();

            if ($pendaftaran) {
                // Mapping jenis_berkas ('foto', 'ijazah', dll) menjadi nama kolom ('path_foto', 'path_ijazah')
                $nama_kolom = 'path_' . $request->jenis_berkas;

                // Simpan lokasi file ke database
                $pendaftaran->update([
                    $nama_kolom => $path
                ]);
            }

            return redirect()->back()->with('success', 'Berkas berhasil diunggah.');
        }

        return redirect()->back()->with('error', 'Gagal mengunggah berkas.');
    }
}