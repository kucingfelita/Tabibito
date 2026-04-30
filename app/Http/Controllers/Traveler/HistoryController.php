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
}
