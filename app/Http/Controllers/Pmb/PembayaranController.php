<?php

namespace App\Http\Controllers\Pmb;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Midtrans\Config;
use Midtrans\Snap;
use Illuminate\Support\Facades\Auth;

class PembayaranController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $pendaftaran = $user->pendaftaran;

        if (!$pendaftaran) {
            return redirect()->route('pmb.biodata.index')->with('error', 'Silakan isi biodata terlebih dahulu.');
        }

        // Setup konfigurasi Midtrans
        Config::$serverKey = env('MIDTRANS_SERVER_KEY');
        Config::$isProduction = env('MIDTRANS_IS_PRODUCTION', false);
        Config::$isSanitized = true;
        Config::$is3ds = true;

        $snapToken = null;
        $nominal = 250000; // Biaya pendaftaran (bisa disesuaikan)

        // Generate Snap Token hanya jika belum lunas
        if ($pendaftaran->status_pembayaran === 'Belum Lunas') {
            $params = [
                'transaction_details' => [
                    'order_id' => 'PMB-' . $user->id . '-' . time(),
                    'gross_amount' => $nominal,
                ],
                'customer_details' => [
                    'first_name' => $user->name,
                    'email' => $user->email,
                    // 'phone' => $pendaftaran->nomor_telepon, // Buka komen ini jika ada kolom no telp
                ]
            ];

            // Dapatkan token dari Midtrans
            $snapToken = Snap::getSnapToken($params);
        }

        return Inertia::render('PMB/Pembayaran/Index', [
            'pendaftaran' => $pendaftaran,
            'nominal' => $nominal,
            'snapToken' => $snapToken
        ]);
    }

    // Endpoint untuk menangani sukses pembayaran (simulasi update status)
    public function success(Request $request)
    {
        $pendaftaran = Auth::user()->pendaftaran;
        if ($pendaftaran) {
            $pendaftaran->update(['status_pembayaran' => 'Lunas']);
        }
        
        return redirect()->route('pmb.dashboard')->with('success', 'Pembayaran berhasil! Berkas Anda sedang diproses.');
    }
}