<?php

namespace App\Http\Controllers\Owner;

use App\Http\Controllers\Controller;
use App\Http\Requests\WithdrawalRequest;
use App\Models\Withdrawal;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\DB;
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

    public function store(WithdrawalRequest $request): RedirectResponse
    {
        $owner = $request->user();
        $amount = (float) $request->input('amount');
        $adminFee = $amount * 0.05;

        if ($owner->balance < $amount) {
            return back()->withErrors(['amount' => 'Saldo Anda tidak mencukupi.']);
        }

        DB::transaction(function () use ($owner, $amount, $adminFee, $request) {
            $owner->decrement('balance', $amount);

            Withdrawal::query()->create([
                'user_id' => $owner->id,
                'amount' => $amount - $adminFee,
                'admin_fee' => $adminFee,
                'ewallet_or_bank_name' => $request->string('ewallet_or_bank_name')->toString(),
                'account_number' => $request->string('account_number')->toString(),
                'status' => 'pending',
            ]);
        });

        return back()->with('success', 'Permintaan penarikan dana berhasil dikirim.');
    }
}
