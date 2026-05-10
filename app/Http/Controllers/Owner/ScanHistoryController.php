<?php

namespace App\Http\Controllers\Owner;

use App\Http\Controllers\Controller;
use App\Models\Destination;
use App\Models\Transaction;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ScanHistoryController extends Controller
{
    public function index(Request $request): View
    {
        $user     = auth()->user();
        $ownerId  = $user->resolveOwnerId();

        // Ambil semua destination_id milik owner
        $destinationIds = Destination::query()
            ->where('user_id', $ownerId)
            ->pluck('id');

        // Default: hari ini
        $date = $request->input('date', now()->toDateString());

        $transactions = Transaction::query()
            ->with(['user', 'ticket.destination'])
            ->whereHas('ticket', fn ($q) => $q->whereIn('destination_id', $destinationIds))
            ->where('status', 'used')
            ->whereDate('updated_at', $date)   // tanggal scan (kapan status berubah jadi 'used')
            ->orderByDesc('updated_at')
            ->get();

        return view('owner.scan-history', compact('transactions', 'date'));
    }
}
