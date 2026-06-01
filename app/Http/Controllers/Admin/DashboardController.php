<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Jobs\SendDestinationApprovedMailJob;
use App\Jobs\SendDestinationRejectedMailJob;
use App\Models\Destination;
use App\Models\Transaction;
use App\Models\User;
use App\Models\Withdrawal;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(): View
    {
        $pendingDestinations = Destination::query()
            ->with('owner:id,name,email')
            ->where('status', 'pending')
            ->latest()
            ->get();
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
        $destination->update([
            'status' => 'active',
            'rejection_reason' => null,
        ]);
        $destination->owner()->update(['tipe_user' => User::TYPE_OWNER]);

        SendDestinationApprovedMailJob::dispatch($destination->fresh());

        return back()->with('success', 'Destinasi berhasil di-approve. Email pemberitahuan telah dikirim ke owner.');
    }

    public function rejectDestination(Request $request, Destination $destination): RedirectResponse
    {
        $validated = $request->validate([
            'rejection_reason' => ['required', 'string', 'min:10', 'max:500'],
        ]);

        $reason = $validated['rejection_reason'];

        $destination->update([
            'status' => 'rejected',
            'rejection_reason' => $reason,
        ]);

        SendDestinationRejectedMailJob::dispatch($destination->fresh(), $reason);

        return back()->with('success', 'Destinasi ditolak. Email pemberitahuan telah dikirim ke owner.');
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

    public function rejectWithdrawal(Request $request, Withdrawal $withdrawal): RedirectResponse
    {
        if ($withdrawal->status !== 'pending') {
            return back()->withErrors(['withdrawal' => 'Withdrawal ini sudah diproses.']);
        }

        $validated = $request->validate([
            'reject_reason' => ['required', 'string', 'min:10', 'max:500'],
        ]);

        DB::transaction(function () use ($withdrawal, $validated) {
            $locked = Withdrawal::query()->lockForUpdate()->findOrFail($withdrawal->id);

            if ($locked->status !== 'pending') {
                return;
            }

            $gross = $locked->gross_amount;
            $locked->update([
                'status' => 'rejected',
                'reject_reason' => $validated['reject_reason'],
            ]);

            $locked->user()->lockForUpdate()->first()?->increment('balance', $gross);
        });

        return back()->with('success', 'Pencairan ditolak. Saldo owner telah dikembalikan.');
    }
}
