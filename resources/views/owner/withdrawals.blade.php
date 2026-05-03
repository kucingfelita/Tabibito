@extends('layouts.app')

@section('content')
    @include('owner.partials.nav')
    <h1 class="text-xl font-semibold">Tarik Dana</h1>
    <p class="mt-1 text-sm text-slate-500">Saldo saat ini: Rp {{ number_format(auth()->user()->balance, 0, ',', '.') }}</p>
    <form method="POST" action="{{ route('owner.withdrawals.store') }}" class="mt-4 max-w-xl space-y-3 rounded-xl bg-white p-4 shadow-sm">
        @csrf
        <input type="number" name="amount" min="50000" placeholder="Jumlah tarik (min Rp 50.000)" class="w-full rounded-lg border px-3 py-2">
        <input name="ewallet_or_bank_name" placeholder="Nama Bank / E-Wallet" class="w-full rounded-lg border px-3 py-2">
        <input name="account_number" placeholder="Nomor Rekening / Akun" class="w-full rounded-lg border px-3 py-2">
        <button class="rounded-lg bg-emerald-600 px-4 py-2 text-white">Kirim Permintaan</button>
    </form>

    <div class="mt-8">
        <h2 class="text-lg font-semibold mb-3">Riwayat Penarikan</h2>
        @if($withdrawals->isEmpty())
            <p class="text-sm text-slate-500 bg-white p-4 rounded-xl shadow-sm">Belum ada riwayat penarikan dana.</p>
        @else
            <div class="space-y-3">
                @foreach($withdrawals as $wd)
                    <div class="rounded-xl bg-white p-4 shadow-sm flex flex-col md:flex-row md:items-center justify-between gap-3">
                        <div>
                            <p class="font-medium">Rp {{ number_format($wd->amount, 0, ',', '.') }}</p>
                            <p class="text-sm text-slate-500 mt-1">{{ $wd->ewallet_or_bank_name }} - {{ $wd->account_number }}</p>
                            <p class="text-xs text-slate-400 mt-1">{{ $wd->created_at->format('d M Y H:i') }} | Biaya Admin: Rp {{ number_format($wd->admin_fee, 0, ',', '.') }}</p>
                        </div>
                        <div>
                            @if($wd->status === 'pending')
                                <span class="rounded-full bg-amber-100 px-3 py-1 text-xs font-medium text-amber-700">Pending</span>
                            @elseif($wd->status === 'approved')
                                <span class="rounded-full bg-emerald-100 px-3 py-1 text-xs font-medium text-emerald-700">Approved</span>
                            @else
                                <span class="rounded-full bg-rose-100 px-3 py-1 text-xs font-medium text-rose-700">{{ ucfirst($wd->status) }}</span>
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>
            <div class="mt-4">{{ $withdrawals->links() }}</div>
        @endif
    </div>
@endsection
