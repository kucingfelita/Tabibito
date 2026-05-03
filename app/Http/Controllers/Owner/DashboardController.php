<?php

namespace App\Http\Controllers\Owner;

use App\Http\Controllers\Controller;
use App\Models\Destination;
use App\Models\Transaction;
use App\Models\Withdrawal;
use Carbon\Carbon;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(): View
    {
        $ownerId = auth()->id();
        $destinationIds = Destination::query()->where('user_id', $ownerId)->pluck('id');

        $totalSold = Transaction::query()
            ->whereHas('ticket', fn ($q) => $q->whereIn('destination_id', $destinationIds))
            ->whereIn('status', ['settlement', 'used'])
            ->sum('qty');

        $totalRevenue = Transaction::query()
            ->whereHas('ticket', fn ($q) => $q->whereIn('destination_id', $destinationIds))
            ->whereIn('status', ['settlement', 'used'])
            ->sum('total_price');

        $tickets = \App\Models\Ticket::query()->whereIn('destination_id', $destinationIds)->get();
        $todayRemainingQuota = $tickets->sum(fn ($ticket) => $ticket->getAvailableQuota(now()->toDateString()));

        $pendingWithdrawal = Withdrawal::query()
            ->where('user_id', $ownerId)
            ->where('status', 'pending')
            ->sum('amount');

        $chart = collect(range(5, 0))->map(function (int $monthsAgo) use ($destinationIds) {
            $start = Carbon::now()->subMonths($monthsAgo)->startOfMonth();
            $end = (clone $start)->endOfMonth();
            $amount = Transaction::query()
                ->whereHas('ticket', fn ($q) => $q->whereIn('destination_id', $destinationIds))
                ->whereBetween('created_at', [$start, $end])
                ->whereIn('status', ['settlement', 'used'])
                ->sum('total_price');

            return [
                'label' => $start->translatedFormat('M'),
                'amount' => (int) $amount,
            ];
        })->values();

        return view('owner.dashboard', compact('totalSold', 'totalRevenue', 'todayRemainingQuota', 'pendingWithdrawal', 'chart'));
    }
}
