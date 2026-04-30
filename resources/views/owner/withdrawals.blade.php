@extends('layouts.app')

@section('content')
    <h1 class="text-xl font-semibold">Tarik Dana</h1>
    <p class="mt-1 text-sm text-slate-500">Saldo saat ini: Rp {{ number_format(auth()->user()->balance, 0, ',', '.') }}</p>
    <form method="POST" action="{{ route('owner.withdrawals.store') }}" class="mt-4 max-w-xl space-y-3 rounded-xl bg-white p-4 shadow-sm">
        @csrf
        <input type="number" name="amount" min="50000" placeholder="Jumlah tarik (min Rp 50.000)" class="w-full rounded-lg border px-3 py-2">
        <input name="ewallet_or_bank_name" placeholder="Nama Bank / E-Wallet" class="w-full rounded-lg border px-3 py-2">
        <input name="account_number" placeholder="Nomor Rekening / Akun" class="w-full rounded-lg border px-3 py-2">
        <button class="rounded-lg bg-emerald-600 px-4 py-2 text-white">Kirim Permintaan</button>
    </form>
@endsection
