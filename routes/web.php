<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use App\Models\JalurPendaftaran;
use App\Models\Gelombang;
use App\Models\JenisKelas;
use App\Models\ProgramStudi;
use Illuminate\Support\Facades\Auth;
use App\Http\Middleware\RoleMiddleware;
use App\Http\Controllers\Mahasiswa\PmbController;
use App\Http\Controllers\Mahasiswa\KrsController;
use App\Http\Controllers\Dosen\PerwalianController;
use App\Http\Controllers\Dosen\PenilaianController;
use App\Http\Controllers\Mahasiswa\KhsController;
use App\Http\Controllers\Dosen\JadwalController;
use App\Http\Controllers\Dosen\BimbinganController;
use App\Http\Controllers\Mahasiswa\TagihanController;
use App\Http\Controllers\Mahasiswa\TranskripController;
use App\Http\Controllers\Mahasiswa\SkripsiController;
use App\Http\Controllers\Pmb\BerkasController;
use App\Http\Controllers\Pmb\BiodataController;
use App\Http\Controllers\Pmb\PembayaranController;
use App\Http\Controllers\Pmb\PengumumanController;




Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

// --- 1. PORTAL PMB (Hanya untuk Calon Mahasiswa) ---
Route::middleware(['auth', 'role:Calon Mahasiswa'])->prefix('pmb')->group(function () {
    Route::get('/dashboard', function () {

        $user = Auth::user();
        $mahasiswa = $user->mahasiswa->load('program_studi');

        $dataWizard = [
            'jalurs' => \App\Models\JalurPendaftaran::all(),
            'gelombangs' => \App\Models\Gelombang::where('tanggal_selesai', '>=', now())->get(),
            'jenis_kelas' => \App\Models\JenisKelas::all(),
            'prodis' => \App\Models\ProgramStudi::where('status', 'Aktif')->get(),
        ];

        $syaratPendaftaran = [];
        $berkasDiunggah = [];
        if ($mahasiswa->jalur_pendaftaran_id) {
            $syaratPendaftaran = \App\Models\SyaratPendaftaran::where('jalur_pendaftaran_id', $mahasiswa->jalur_pendaftaran_id)->get();
            $berkasDiunggah = \App\Models\BerkasPendaftaran::where('mahasiswa_id', $mahasiswa->id)->get();
        }
        $pembayaran = null;
        if ($mahasiswa->jalur_pendaftaran_id) {
            // Load berkas dan tagihan
            $syaratPendaftaran = \App\Models\SyaratPendaftaran::where('jalur_pendaftaran_id', $mahasiswa->jalur_pendaftaran_id)->get();
            $berkasDiunggah = \App\Models\BerkasPendaftaran::where('mahasiswa_id', $mahasiswa->id)->get();
            
            // Ambil data pembayaran terbaru beserta relasi nominal biayanya
            $pembayaran = \App\Models\PembayaranPmb::with('biaya_pendaftaran')
                            ->where('mahasiswa_id', $mahasiswa->id)
                            ->latest()->first();
        }

        // Return ke file Vue PMB (Bisa pakai layout khusus PMB)
        return Inertia::render('PMB/Dashboard', [ // Nanti foldernya bisa kita rename ke PMB/Dashboard
            'mahasiswa' => $mahasiswa,
            'dataWizard' => $dataWizard,
            'syaratPendaftaran' => $syaratPendaftaran,
            'berkasDiunggah' => $berkasDiunggah,
            'pembayaran' => $pembayaran,
        ]);
    })->name('pmb.dashboard');
    
    Route::post('/submit', [\App\Http\Controllers\Mahasiswa\PmbController::class, 'store'])->name('pmb.store');
    Route::post('/upload-berkas', [\App\Http\Controllers\Mahasiswa\PmbController::class, 'uploadBerkas'])->name('pmb.upload_berkas');
    Route::post('/pmb/create-payment', [\App\Http\Controllers\Mahasiswa\PaymentController::class, 'createPayment'])->name('pmb.create_payment');
    Route::get('/biodata', [BiodataController::class, 'index'])->name('pmb.biodata.index');
    Route::post('/biodata', [BiodataController::class, 'store'])->name('pmb.biodata.store');
    Route::get('/berkas', [BerkasController::class, 'index'])->name('pmb.berkas.index');
    Route::post('/berkas', [BerkasController::class, 'store'])->name('pmb.berkas.store');
    Route::get('/pembayaran', [PembayaranController::class, 'index'])->name('pmb.pembayaran.index');
    Route::post('/pembayaran/success', [PembayaranController::class, 'success'])->name('pmb.pembayaran.success');
    Route::get('/pengumuman', [PengumumanController::class, 'index'])->name('pmb.pengumuman.index');
});

// --- 2. PORTAL MAHASISWA AKTIF (KRS, KHS, dll) ---
Route::middleware(['auth', 'role:Mahasiswa'])->prefix('mahasiswa')->group(function () {
    Route::get('/dashboard', function () {
        return Inertia::render('Mahasiswa/Dashboard'); // Halaman kosong untuk KRS/KHS nanti
    })->name('mahasiswa.dashboard');
    Route::get('/krs', [KrsController::class, 'index'])->name('mahasiswa.krs.index');
    Route::post('/krs', [KrsController::class, 'store'])->name('mahasiswa.krs.store');
    Route::get('/khs', [KhsController::class, 'index'])->name('mahasiswa.khs.index');
    Route::get('/khs/{id}', [KhsController::class, 'show'])->name('mahasiswa.khs.show');
    Route::get('/tagihan', [TagihanController::class, 'index'])->name('mahasiswa.tagihan.index');
    Route::get('/transkrip', [TranskripController::class, 'index'])->name('mahasiswa.transkrip.index');
    Route::get('/skripsi', [SkripsiController::class, 'index'])->name('mahasiswa.skripsi.index');
    Route::post('/skripsi', [SkripsiController::class, 'store'])->name('mahasiswa.skripsi.store');
});



Route::middleware(['auth', 'role:Dosen'])->prefix('dosen')->group(function () {
    Route::get('/dashboard', function () {
        $user = Auth::user();
        $dosen = $user->dosen;
        
        // Mock data sementara untuk dashboard (nanti bisa di-query dari database)
        $statistik = [
            'mahasiswa_perwalian' => 0, // Hitung jumlah mahasiswa bimbingan dari KRS
            'kelas_diampu' => 0,        // Hitung dari jadwal mengajar aktif
        ];

        return Inertia::render('Dosen/Dashboard', [
            'dosen' => $dosen,
            'statistik' => $statistik
        ]);
    })->name('dosen.dashboard');
    
    Route::get('/perwalian', [PerwalianController::class, 'index'])->name('dosen.perwalian.index');
    Route::get('/perwalian/{krs}', [PerwalianController::class, 'show'])->name('dosen.perwalian.show');
    Route::post('/perwalian/{krs}/approve', [PerwalianController::class, 'approve'])->name('dosen.perwalian.approve');
    Route::post('/perwalian/{krs}/reject', [PerwalianController::class, 'reject'])->name('dosen.perwalian.reject');
    Route::get('/penilaian', [PenilaianController::class, 'index'])->name('dosen.penilaian.index');
    Route::get('/penilaian/{jadwal}', [PenilaianController::class, 'show'])->name('dosen.penilaian.show');
    Route::post('/penilaian/{jadwal}', [PenilaianController::class, 'store'])->name('dosen.penilaian.store');
    Route::get('/jadwal', [JadwalController::class, 'index'])->name('dosen.jadwal.index');
    Route::get('/bimbingan', [BimbinganController::class, 'index'])->name('dosen.bimbingan.index');
});

Route::post('/midtrans/webhook', [\App\Http\Controllers\Mahasiswa\PaymentController::class, 'webhook']);
Route::get('/about', function () {
    return Inertia::render('About');
});

require __DIR__.'/auth.php';
