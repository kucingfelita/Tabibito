@extends('layouts.app')

@section('content')
    <h1 class="text-xl font-semibold">Admin Dashboard</h1>
    <div class="mt-4 grid gap-4 md:grid-cols-3">
        <div class="rounded-xl bg-white p-4 shadow-sm"><p class="text-xs text-slate-500">Total User</p><p class="text-2xl font-bold">{{ $stats['total_users'] }}</p></div>
        <div class="rounded-xl bg-white p-4 shadow-sm"><p class="text-xs text-slate-500">Owner Terverifikasi</p><p class="text-2xl font-bold">{{ $stats['total_owner'] }}</p></div>
        <div class="rounded-xl bg-white p-4 shadow-sm"><p class="text-xs text-slate-500">Destinasi Aktif</p><p class="text-2xl font-bold">{{ $stats['active_destinations'] }}</p></div>
    </div>
    <div class="mt-6 grid gap-6 lg:grid-cols-2">
        <div class="rounded-xl bg-white p-4 shadow-sm">
            <h2 class="font-semibold">Verifikasi Destinasi</h2>
            @forelse($pendingDestinations as $destination)
                <div class="mt-3 rounded-lg border p-3">
                    <p class="font-medium">{{ $destination->name }}</p>
                    <p class="text-xs text-slate-500">{{ $destination->city }}</p>
                    <div class="mt-2 flex gap-2">
                        <form method="POST" action="{{ route('admin.destinations.approve', $destination) }}">@csrf @method('PATCH') <button class="rounded bg-emerald-600 px-3 py-1 text-xs text-white">Approve</button></form>
                        <form method="POST" action="{{ route('admin.destinations.reject', $destination) }}">@csrf @method('PATCH') <button class="rounded bg-rose-600 px-3 py-1 text-xs text-white">Reject</button></form>
                    </div>
                </div>
            @empty
                <p class="mt-3 text-sm text-slate-500">Belum ada pengajuan destinasi pending.</p>
            @endforelse
        </div>
        <div class="rounded-xl bg-white p-4 shadow-sm">
            <h2 class="font-semibold">Pencairan Dana</h2>
            @forelse($pendingWithdrawals as $withdrawal)
                <div class="mt-3 rounded-lg border p-3">
                    <p class="text-sm">Owner #{{ $withdrawal->user_id }} - Rp {{ number_format($withdrawal->amount, 0, ',', '.') }}</p>
                    <form method="POST" action="{{ route('admin.withdrawals.approve', $withdrawal) }}" class="mt-2">@csrf @method('PATCH') <button class="rounded bg-cyan-600 px-3 py-1 text-xs text-white">Tandai Selesai</button></form>
                </div>
            @empty
                <p class="mt-3 text-sm text-slate-500">Belum ada pencairan dana pending.</p>
            @endforelse
        </div>
    </div>
    <div class="mt-6 grid gap-6 lg:grid-cols-2">
        <div class="rounded-xl bg-white p-4 shadow-sm">
            <h2 class="font-semibold">User Terbaru</h2>
            @foreach($users as $user)
                <p class="mt-2 text-sm">{{ $user->name }} <span class="text-xs text-slate-500">({{ $user->username }})</span></p>
            @endforeach
        </div>
        <div class="rounded-xl bg-white p-4 shadow-sm">
            <h2 class="font-semibold">Transaksi Terbaru</h2>
            @foreach($latestTransactions as $trx)
                <p class="mt-2 text-sm">{{ $trx->order_id }} - {{ strtoupper($trx->status) }} - Rp {{ number_format($trx->total_price, 0, ',', '.') }}</p>
            @endforeach
        </div>
    </div>
@endsection
