<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Destination;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\View\View;

class DestinationController extends Controller
{
    public function index(Request $request): View
    {
        $status = $request->query('status', 'all');
        $search = trim((string) $request->query('q', ''));

        $destinations = Destination::query()
            ->with(['owner:id,name,username,email,phone', 'coverImage'])
            ->withCount(['tickets', 'transactions as sold_transactions_count' => function ($query) {
                $query->whereIn('transactions.status', ['settlement', 'used']);
            }])
            ->when($status !== 'all' && in_array($status, ['pending', 'active', 'rejected'], true), function ($query) use ($status) {
                $query->where('status', $status);
            })
            ->when($search !== '', function ($query) use ($search) {
                $query->where(function ($inner) use ($search) {
                    $inner->where('name', 'like', "%{$search}%")
                        ->orWhere('city', 'like', "%{$search}%")
                        ->orWhere('address', 'like', "%{$search}%")
                        ->orWhereHas('owner', function ($ownerQuery) use ($search) {
                            $ownerQuery->where('name', 'like', "%{$search}%")
                                ->orWhere('username', 'like', "%{$search}%")
                                ->orWhere('email', 'like', "%{$search}%");
                        });
                });
            })
            ->latest()
            ->paginate(12)
            ->withQueryString();

        $counts = [
            'all' => Destination::query()->count(),
            'pending' => Destination::query()->where('status', 'pending')->count(),
            'active' => Destination::query()->where('status', 'active')->count(),
            'rejected' => Destination::query()->where('status', 'rejected')->count(),
        ];

        return view('admin.destinations.index', compact('destinations', 'status', 'search', 'counts'));
    }

    public function show(Destination $destination): View
    {
        $destination->load([
            'owner',
            'tags',
            'coverImage',
            'slideImages',
            'tickets' => fn ($q) => $q->orderBy('price'),
        ]);

        $transactionStats = Transaction::query()
            ->whereHas('ticket', fn ($q) => $q->where('destination_id', $destination->id))
            ->selectRaw("
                COUNT(*) as total_orders,
                SUM(CASE WHEN status = 'pending' THEN 1 ELSE 0 END) as pending_count,
                SUM(CASE WHEN status IN ('settlement', 'used') THEN 1 ELSE 0 END) as paid_count,
                SUM(CASE WHEN status IN ('settlement', 'used') THEN total_price ELSE 0 END) as total_revenue,
                SUM(CASE WHEN status IN ('settlement', 'used') THEN qty ELSE 0 END) as tickets_sold
            ")
            ->first();

        $recentTransactions = Transaction::query()
            ->whereHas('ticket', fn ($q) => $q->where('destination_id', $destination->id))
            ->with(['user:id,name,email', 'ticket:id,name'])
            ->latest()
            ->take(10)
            ->get();

        return view('admin.destinations.show', compact('destination', 'transactionStats', 'recentTransactions'));
    }
}
