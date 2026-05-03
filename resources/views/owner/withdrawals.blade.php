@extends('layouts.app')

@section('content')
    @include('owner.partials.nav')
    <h1 class="text-xl font-semibold">Tarik Dana</h1>
    <p class="mt-1 text-sm text-slate-500">Saldo saat ini: Rp {{ number_format(auth()->user()->balance, 0, ',', '.') }}</p>
    <div class="mt-4 max-w-xl rounded-xl bg-white p-5 shadow-sm">
        @if(empty(auth()->user()->bank_code) || empty(auth()->user()->bank_account_number))
            <div class="mb-4 rounded-lg bg-amber-50 p-4 text-sm text-amber-800">
                <p class="font-semibold">Perhatian!</p>
                <p>Anda belum melengkapi data rekening bank untuk pencairan dana.</p>
                <a href="{{ route('profile') }}" class="mt-2 inline-block font-medium text-amber-900 underline">Lengkapi Profil Sekarang &rarr;</a>
            </div>
        @else
            <div class="mb-4 rounded-lg border bg-slate-50 p-4 text-sm">
                <p class="text-slate-500">Dana akan ditransfer ke:</p>
                <p class="mt-1 font-semibold text-slate-800">{{ strtoupper(auth()->user()->bank_code) }} - {{ auth()->user()->bank_account_number }}</p>
                <p class="text-slate-600">a.n {{ auth()->user()->bank_account_name }}</p>
                <a href="{{ route('profile') }}" class="mt-2 text-xs text-blue-600 underline">Ubah Rekening</a>
            </div>

            <form method="POST" action="{{ route('owner.withdrawals.store') }}" class="space-y-3">
                @csrf
                <div>
                    <label class="block text-sm font-medium text-slate-700">Jumlah Penarikan</label>
                    <input type="number" name="amount" min="50000" placeholder="Minimal Rp 50.000" class="mt-1 w-full rounded-lg border px-3 py-2">
                    <p class="mt-1 text-xs text-slate-500">Biaya admin 5% akan dipotong dari jumlah penarikan.</p>
                </div>
                <button class="w-full rounded-lg bg-emerald-600 px-4 py-2 text-white font-medium hover:bg-emerald-700 transition">Kirim Permintaan Tarik Dana</button>
            </form>
        @endif
    </div>

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
