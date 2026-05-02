@extends('layouts.app')

@section('content')
    @include('owner.partials.nav')
    <h1 class="text-xl font-semibold">Owner Dashboard</h1>
    <div class="mt-4 grid gap-4 md:grid-cols-4">
        <div class="rounded-xl bg-white p-4 shadow-sm">
            <p class="text-sm text-slate-500">Total tiket terjual</p>
            <p class="text-2xl font-bold">{{ number_format($totalSold) }}</p>
        </div>
        <div class="rounded-xl bg-white p-4 shadow-sm">
            <p class="text-sm text-slate-500">Total pendapatan</p>
            <p class="text-2xl font-bold">Rp {{ number_format($totalRevenue, 0, ',', '.') }}</p>
        </div>
        <div class="rounded-xl bg-white p-4 shadow-sm">
            <p class="text-sm text-slate-500">Sisa kuota hari ini</p>
            <p class="text-2xl font-bold">{{ number_format($todayRemainingQuota) }}</p>
        </div>
        <div class="rounded-xl bg-white p-4 shadow-sm">
            <p class="text-sm text-slate-500">Withdrawal pending</p>
            <p class="text-2xl font-bold">Rp {{ number_format($pendingWithdrawal, 0, ',', '.') }}</p>
        </div>
    </div>
    <div x-data='{chart:@json($chart)}' class="mt-6 rounded-xl bg-white p-4 shadow-sm">
        <h2 class="font-semibold">Grafik Pendapatan 6 Bulan</h2>
        <div class="mt-4 flex items-end gap-3">
            <template x-for="item in chart" :key="item.label">
                <div class="flex-1 text-center">
                    <div class="mx-auto w-full rounded-t bg-emerald-500" :style="`height:${Math.max(8, item.amount / 50000)}px`"></div>
                    <p class="mt-1 text-xs text-slate-500" x-text="item.label"></p>
                </div>
            </template>
        </div>
    </div>
@endsection
