<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Midtrans\Config;
use Midtrans\Notification;

class MidtransWebhookController extends Controller
{
    public function handle(Request $request)
    {
        // Konfigurasi Midtrans
        Config::$serverKey = env('MIDTRANS_SERVER_KEY');
        Config::$isProduction = env('MIDTRANS_IS_PRODUCTION', false);

        try {
            // Instansiasi Notification akan otomatis memverifikasi Signature Key dari Midtrans
            $notif = new Notification();
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 400);
        }

        $transactionStatus = $notif->transaction_status;
        $orderId = $notif->order_id;

        // Ekstrak ID User dari format order_id kita sebelumnya (PMB-{user_id}-{time})
        $parts = explode('-', $orderId);
        $userId = $parts[1] ?? null;

        if (!$userId) {
            return response()->json(['message' => 'Format Order ID tidak valid'], 400);
        }

        $user = User::find($userId);
        if (!$user || !$user->pendaftaran) {
            return response()->json(['message' => 'Data pendaftaran tidak ditemukan'], 404);
        }

        $pendaftaran = $user->pendaftaran;

        // Logika update status berdasarkan notifikasi server Midtrans
        if ($transactionStatus == 'capture' || $transactionStatus == 'settlement') {
            $pendaftaran->update(['status_pembayaran' => 'Lunas']);
        } else if ($transactionStatus == 'cancel' || $transactionStatus == 'deny' || $transactionStatus == 'expire') {
            $pendaftaran->update(['status_pembayaran' => 'Belum Lunas']);
        }

        return response()->json(['message' => 'Webhook berhasil diproses']);
    }
}
