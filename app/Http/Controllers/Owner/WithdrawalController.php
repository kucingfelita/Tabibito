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
        $owner = $request->user();

        // Cek apakah data bank sudah diisi di profil
        if (empty($owner->bank_code) || empty($owner->bank_account_number) || empty($owner->bank_account_name)) {
            return back()->withErrors(['bank' => 'Lengkapi data rekening bank Anda di halaman Profil terlebih dahulu.']);
        }

        $request->validate([
            'amount' => ['required', 'numeric', 'min:50000'],
        ]);

        $amount = (float) $request->input('amount');
        $adminFee = $amount * 0.05;
        $netAmount = $amount - $adminFee;

        if ($owner->balance < $amount) {
            return back()->withErrors(['amount' => 'Saldo Anda tidak mencukupi.']);
        }

        $referenceNo = null;
        $irisAvailable = config('services.iris.creator_key') !== '';

        // Jika Iris API Key sudah ada, buat payout request
        if ($irisAvailable) {
            try {
                $iris = new IrisService();
                $referenceNo = $iris->createPayout([
                    'beneficiary_name'    => $owner->bank_account_name,
                    'beneficiary_account' => $owner->bank_account_number,
                    'bank_code'           => $owner->bank_code,
                    'amount'              => $netAmount,
                    'notes'               => 'Withdrawal Owner #' . $owner->id,
                ]);
            } catch (\Exception $e) {
                Log::error('Iris createPayout error: ' . $e->getMessage());
                return back()->withErrors(['iris' => 'Gagal terhubung ke sistem pembayaran. Silakan coba lagi.']);
            }
        }

        DB::transaction(function () use ($owner, $amount, $adminFee, $netAmount, $referenceNo) {
            $owner->decrement('balance', $amount);

            Withdrawal::query()->create([
                'user_id'             => $owner->id,
                'amount'              => $netAmount,
                'admin_fee'           => $adminFee,
                'ewallet_or_bank_name' => strtoupper($owner->bank_code),
                'account_number'      => $owner->bank_account_number,
                'status'              => 'pending',
                'reference_no'        => $referenceNo,
            ]);
        });

        return back()->with('success', 'Permintaan penarikan dana berhasil dikirim' . ($irisAvailable ? ' dan akan diproses otomatis setelah Admin menyetujui.' : '. Admin akan memproses transfer Anda segera.'));
    }
}
