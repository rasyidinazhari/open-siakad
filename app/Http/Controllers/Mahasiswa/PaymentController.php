<?php 

namespace App\Http\Controllers\Mahasiswa;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Midtrans\Config;
use Midtrans\Snap;
use App\Models\PembayaranPmb;
use App\Models\BiayaPendaftaran;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class PaymentController extends Controller
{
    public function __construct()
    {
        Config::$serverKey = config('midtrans.server_key');
        Config::$isProduction = config('midtrans.is_production');
        Config::$isSanitized = config('midtrans.is_sanitized');
        Config::$is3ds = config('midtrans.is_3ds');
    }

    // Fungsi untuk membuat tagihan dan meminta token ke Midtrans
    public function createPayment(Request $request)
    {
        $user = Auth::user();
        $mahasiswa = $user->mahasiswa;

        // Cek tagihan yang belum lunas
        $pembayaran = PembayaranPmb::where('mahasiswa_id', $mahasiswa->id)
            ->whereIn('status', ['Pending'])
            ->first();

        // Jika belum ada tagihan sama sekali, buat baru
        if (!$pembayaran) {
            $biaya = BiayaPendaftaran::where('jalur_pendaftaran_id', $mahasiswa->jalur_pendaftaran_id)->first();
            
            if (!$biaya) {
                return back()->with('error', 'Biaya pendaftaran untuk jalur ini belum diatur oleh admin.');
            }

            $orderId = 'PMB-' . $mahasiswa->id . '-' . time();
            
            $pembayaran = PembayaranPmb::create([
                'mahasiswa_id' => $mahasiswa->id,
                'biaya_pendaftaran_id' => $biaya->id,
                'order_id' => $orderId,
                'status' => 'Pending',
            ]);
        }

        // Request Token ke Midtrans jika belum punya token
        if (!$pembayaran->snap_token) {
            $biaya = BiayaPendaftaran::find($pembayaran->biaya_pendaftaran_id);
            
            $params = [
                'transaction_details' => [
                    'order_id' => $pembayaran->order_id,
                    'gross_amount' => $biaya->nominal,
                ],
                'customer_details' => [
                    'first_name' => $user->name,
                    'email' => $user->email,
                    'phone' => $mahasiswa->nomor_telepon ?? '',
                ]
            ];

            try {
                $snapToken = Snap::getSnapToken($params);
                $pembayaran->update(['snap_token' => $snapToken]);
            } catch (\Exception $e) {
                return back()->with('error', 'Gagal memuat pembayaran: ' . $e->getMessage());
            }
        }

        return back(); // Kembali ke halaman Vue
    }

    // Fungsi Webhook untuk menerima update status dari server Midtrans
    public function webhook(Request $request)
    {
        $payload = $request->getContent();
        $notification = json_decode($payload);

        // Verifikasi Signature Key untuk keamanan
        $validSignatureKey = hash("sha512", $notification->order_id . $notification->status_code . $notification->gross_amount . config('midtrans.server_key'));
        
        if ($request->signature_key != $validSignatureKey) {
            return response(['message' => 'Invalid signature'], 403);
        }

        $transactionStatus = $notification->transaction_status;
        $pembayaran = PembayaranPmb::where('order_id', $notification->order_id)->first();

        if (!$pembayaran) {
            return response(['message' => 'Order not found'], 404);
        }

        if ($transactionStatus == 'capture' || $transactionStatus == 'settlement') {
            $pembayaran->update(['status' => 'Lunas']);
        } else if ($transactionStatus == 'cancel' || $transactionStatus == 'deny' || $transactionStatus == 'expire') {
            $pembayaran->update(['status' => 'Dibatalkan']);
        }

        return response(['message' => 'Webhook received']);
    }
}