<?php

namespace App\Http\Controllers\Traveler;

use App\Http\Controllers\Controller;
use App\Models\Transaction;
use App\Services\MidtransService;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class HistoryController extends Controller
{
    public function index(): View
    {
        $transactions = Transaction::query()
            ->where('user_id', auth()->id())
            ->with('ticket.destination')
            ->latest()
            ->paginate(10);

        return view('traveler.history', compact('transactions'));
    }

    public function checkStatus(Transaction $transaction, MidtransService $midtransService): RedirectResponse
    {
        // Ensure user owns the transaction
        if ($transaction->user_id !== auth()->id()) {
            abort(403);
        }

        $statusResponse = $midtransService->checkTransactionStatus($transaction->order_id);

        if ($statusResponse) {
            $newStatus = match ($statusResponse->transaction_status) {
                'settlement' => 'settlement',
                'pending' => 'pending',
                'expire', 'cancel' => 'expire',
                default => $transaction->status,
            };

            if ($newStatus !== $transaction->status) {
                $transaction->update(['status' => $newStatus]);
            }
        }

        return back()->with('success', 'Status transaksi telah diperbarui.');
    }

    public function submitRating(\Illuminate\Http\Request $request, Transaction $transaction): RedirectResponse
    {
        if ($transaction->user_id !== auth()->id() || $transaction->status !== 'used') {
            abort(403);
        }

        if ($transaction->rating !== null) {
            return back()->with('error', 'Anda sudah memberikan penilaian untuk tiket ini.');
        }

        $request->validate([
            'rating' => ['required', 'integer', 'min:1', 'max:5'],
        ]);

        $transaction->update(['rating' => $request->integer('rating')]);

        return back()->with('success', 'Terima kasih atas penilaian Anda!');
    }

    public function cancel(Transaction $transaction): RedirectResponse
    {
        // Pastikan transaksi milik user yang login
        if ($transaction->user_id !== auth()->id()) {
            abort(403);
        }

        // Hanya transaksi pending yang bisa dibatalkan
        if ($transaction->status !== 'pending') {
            return back()->with('error', 'Hanya pesanan dengan status pending yang bisa dibatalkan. Tidak ada pengembalian dana.');
        }

        // Update status ke 'cancelled' — kuota otomatis kembali karena getAvailableQuota tidak menghitung 'cancelled'
        $transaction->update(['status' => 'cancelled']);

        return back()->with('success', 'Pesanan berhasil dibatalkan. Kuota tiket telah dikembalikan.');
    }
}
