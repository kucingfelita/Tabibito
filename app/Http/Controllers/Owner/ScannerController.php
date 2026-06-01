<?php

namespace App\Http\Controllers\Owner;

use App\Http\Controllers\Controller;
use App\Models\Destination;
use App\Models\Transaction;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ScannerController extends Controller
{
    public function index(): View
    {
        return view('owner.scanner');
    }

    public function verify(Request $request): JsonResponse
    {
        $data = $request->validate([
            'qr_code_token' => ['required', 'string'],
        ]);

        $transaction = Transaction::query()->where('qr_code_token', $data['qr_code_token'])->first();

        if (! $transaction) {
            return response()->json(['message' => 'QR tidak ditemukan di sistem.'], 404);
        }

        if ($transaction->status === 'pending' || empty($transaction->qr_code_token)) {
            return response()->json([
                'message' => 'Tiket belum aktif. QR masuk hanya muncul di akun pengunjung setelah pembayaran berhasil.',
            ], 422);
        }

        if (in_array($transaction->status, ['expire', 'cancelled'], true)) {
            return response()->json([
                'message' => 'Tiket dibatalkan atau kedaluwarsa. Tidak dapat digunakan untuk masuk.',
            ], 422);
        }

        if ($transaction->status === 'used') {
            return response()->json([
                'message' => 'Tiket ini sudah pernah discan dan digunakan.',
            ], 422);
        }

        if ($transaction->status !== 'settlement') {
            return response()->json(['message' => 'Status tiket tidak valid untuk scan.'], 422);
        }

        if (! now()->isSameDay($transaction->booking_date)) {
            return response()->json([
                'message' => 'Tiket ini tidak berlaku untuk hari ini. Tanggal kunjungan tiket adalah ' . $transaction->booking_date->translatedFormat('d F Y') . '.',
            ], 422);
        }

        $user = auth()->user();
        $ownerId = $user->resolveOwnerId();

        $ownerDestinationIds = Destination::query()
            ->where('user_id', $ownerId)
            ->pluck('id');

        $transaction->load(['ticket.destination']);

        if (! $ownerDestinationIds->contains($transaction->ticket->destination_id)) {
            return response()->json(['message' => 'Tiket ini bukan milik destinasi Anda.'], 403);
        }

        $transaction->load('user');
        $transaction->update(['status' => 'used']);

        return response()->json([
            'message' => 'Tiket valid!',
            'qty' => $transaction->qty,
            'visitor_name' => $transaction->user->name,
            'ticket_name' => $transaction->ticket->name,
            'destination_name' => $transaction->ticket->destination->name,
            'booking_date' => $transaction->booking_date->format('d M Y'),
        ]);
    }
}
