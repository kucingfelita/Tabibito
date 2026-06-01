<?php

namespace App\Http\Controllers\Owner;

use App\Http\Controllers\Controller;
use App\Models\Withdrawal;
use App\Services\IrisService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\View\View;

class WithdrawalController extends Controller
{
    public function index(): View
    {
        $withdrawals = Withdrawal::query()
            ->where('user_id', auth()->id())
            ->latest()
            ->paginate(10);

        return view('owner.withdrawals', compact('withdrawals'));
    }

    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'amount' => ['required', 'numeric', 'min:50000'],
        ]);

        $amount = (float) $request->input('amount');
        $adminFee = round($amount * 0.05, 2);
        $netAmount = $amount - $adminFee;

        try {
            DB::transaction(function () use ($request, $amount, $adminFee, $netAmount) {
                $owner = $request->user()->newQuery()->lockForUpdate()->findOrFail($request->user()->id);

                if (empty($owner->bank_code) || empty($owner->bank_account_number) || empty($owner->bank_account_name)) {
                    throw new \RuntimeException('bank_incomplete');
                }

                if (Withdrawal::query()->where('user_id', $owner->id)->where('status', 'pending')->exists()) {
                    throw new \RuntimeException('pending_exists');
                }

                if ($owner->balance < $amount) {
                    throw new \RuntimeException('insufficient_balance');
                }

                $referenceNo = null;

                if (config('services.iris.creator_key') !== '') {
                    try {
                        $iris = new IrisService();
                        $referenceNo = $iris->createPayout([
                            'beneficiary_name' => $owner->bank_account_name,
                            'beneficiary_account' => $owner->bank_account_number,
                            'bank_code' => $owner->bank_code,
                            'amount' => $netAmount,
                            'notes' => 'Withdrawal Owner #' . $owner->id,
                        ]);
                    } catch (\Exception $e) {
                        Log::error('Iris createPayout error: ' . $e->getMessage());
                        throw new \RuntimeException('iris_failed');
                    }
                }

                $owner->decrement('balance', $amount);

                Withdrawal::query()->create([
                    'user_id' => $owner->id,
                    'amount' => $netAmount,
                    'admin_fee' => $adminFee,
                    'ewallet_or_bank_name' => strtoupper($owner->bank_code),
                    'account_number' => $owner->bank_account_number,
                    'status' => 'pending',
                    'reference_no' => $referenceNo,
                ]);
            });
        } catch (\RuntimeException $e) {
            return match ($e->getMessage()) {
                'bank_incomplete' => back()->withErrors(['bank' => 'Lengkapi data rekening bank Anda di halaman Profil terlebih dahulu.']),
                'pending_exists' => back()->withErrors(['amount' => 'Anda masih memiliki pengajuan penarikan yang menunggu persetujuan admin.']),
                'insufficient_balance' => back()->withErrors(['amount' => 'Saldo Anda tidak mencukupi.']),
                'iris_failed' => back()->withErrors(['iris' => 'Gagal terhubung ke sistem pembayaran. Silakan coba lagi.']),
                default => back()->withErrors(['amount' => 'Gagal memproses penarikan.']),
            };
        }

        $irisAvailable = config('services.iris.creator_key') !== '';

        return back()->with('success', 'Permintaan penarikan dana berhasil dikirim' . ($irisAvailable ? ' dan akan diproses setelah Admin menyetujui.' : '. Admin akan memproses transfer Anda segera.'));
    }
}
