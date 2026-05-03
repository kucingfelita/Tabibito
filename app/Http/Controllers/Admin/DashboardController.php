<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Destination;
use App\Models\Transaction;
use App\Models\User;
use App\Models\Withdrawal;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(): View
    {
        $pendingDestinations = Destination::query()->where('status', 'pending')->latest()->get();
        $pendingWithdrawals = Withdrawal::query()->where('status', 'pending')->latest()->get();
        $users = User::query()->latest()->take(8)->get();
        $latestTransactions = Transaction::query()->with('user:id,name', 'ticket:id,name')->latest()->take(8)->get();

        $stats = [
            'total_users' => User::query()->count(),
            'total_owner' => User::query()->where('tipe_user', User::TYPE_OWNER)->count(),
            'active_destinations' => Destination::query()->where('status', 'active')->count(),
            'pending_destinations' => $pendingDestinations->count(),
            'pending_withdrawals' => $pendingWithdrawals->count(),
            'settlement_transactions' => Transaction::query()->where('status', 'settlement')->count(),
        ];

        return view('admin.dashboard', compact('pendingDestinations', 'pendingWithdrawals', 'users', 'latestTransactions', 'stats'));
    }

    public function approveDestination(Destination $destination): RedirectResponse
    {
        $destination->update(['status' => 'active']);
        $destination->owner()->update(['tipe_user' => User::TYPE_OWNER]);

        return back()->with('success', 'Destinasi berhasil di-approve.');
    }

    public function rejectDestination(Destination $destination): RedirectResponse
    {
        $destination->update(['status' => 'rejected']);

        return back()->with('success', 'Destinasi ditolak.');
    }

    public function approveWithdrawal(Withdrawal $withdrawal): RedirectResponse
    {
        if ($withdrawal->status !== 'pending') {
            return back()->withErrors(['withdrawal' => 'Withdrawal ini sudah diproses.']);
        }

        // Jika Iris API Key sudah dikonfigurasi dan ada reference_no, approve via API
        $approverKey = config('services.iris.approver_key');
        if ($approverKey && $withdrawal->reference_no) {
            try {
                $iris = new \App\Services\IrisService();
                $iris->approvePayout($withdrawal->reference_no);
            } catch (\Exception $e) {
                \Illuminate\Support\Facades\Log::error('Iris approvePayout error: ' . $e->getMessage());
                return back()->withErrors(['iris' => 'Gagal memproses transfer otomatis: ' . $e->getMessage()]);
            }
        }

        $withdrawal->update(['status' => 'approved']);

        return back()->with('success', 'Withdrawal berhasil disetujui' . ($approverKey && $withdrawal->reference_no ? ' dan transfer otomatis telah dieksekusi.' : '. Jangan lupa transfer manual ke rekening Owner.'));
    }
}
