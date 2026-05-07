@extends('layouts.app')

@section('content')
    <div class="mb-10">
        <h1 class="text-3xl font-black text-slate-900 mb-2">Selamat Datang, {{ auth()->user()->name }}!</h1>
        <p class="text-slate-500 font-medium">Berikut adalah ringkasan performa destinasi wisata Anda.</p>
    </div>

    @include('owner.partials.nav')

    <div class="grid gap-6 md:grid-cols-2 lg:grid-cols-4 mb-10">
        <!-- Stat Card 1 -->
        <div class="bg-white p-8 rounded-[2rem] border border-slate-100 shadow-sm group hover:border-primary-200 transition-all">
            <div class="w-12 h-12 rounded-2xl bg-primary-50 flex items-center justify-center text-primary-600 mb-6 group-hover:scale-110 transition-transform">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 5v2m0 4v2m0 4v2M5 5a2 2 0 00-2 2v3a2 2 0 110 4v3a2 2 0 002 2h14a2 2 0 002-2v-3a2 2 0 110-4V7a2 2 0 00-2-2H5z"/></svg>
            </div>
            <p class="text-xs text-slate-400 font-bold uppercase tracking-widest mb-1">Tiket Terjual</p>
            <p class="text-3xl font-black text-slate-900">{{ number_format($totalSold) }}</p>
        </div>

        <!-- Stat Card 2 -->
        <div class="bg-white p-8 rounded-[2rem] border border-slate-100 shadow-sm group hover:border-emerald-200 transition-all">
            <div class="w-12 h-12 rounded-2xl bg-emerald-50 flex items-center justify-center text-emerald-600 mb-6 group-hover:scale-110 transition-transform">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            </div>
            <p class="text-xs text-slate-400 font-bold uppercase tracking-widest mb-1">Total Pendapatan</p>
            <p class="text-3xl font-black text-slate-900"><span class="text-sm font-medium text-slate-400">Rp</span> {{ number_format($totalRevenue, 0, ',', '.') }}</p>
        </div>

        <!-- Stat Card 3 -->
        <div class="bg-white p-8 rounded-[2rem] border border-slate-100 shadow-sm group hover:border-amber-200 transition-all">
            <div class="w-12 h-12 rounded-2xl bg-amber-50 flex items-center justify-center text-amber-600 mb-6 group-hover:scale-110 transition-transform">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>
            </div>
            <p class="text-xs text-slate-400 font-bold uppercase tracking-widest mb-1">Sisa Kuota Hari Ini</p>
            <p class="text-3xl font-black text-slate-900">{{ number_format($todayRemainingQuota) }}</p>
        </div>

        <!-- Stat Card 4 -->
        <div class="bg-white p-8 rounded-[2rem] border border-slate-100 shadow-sm group hover:border-rose-200 transition-all">
            <div class="w-12 h-12 rounded-2xl bg-rose-50 flex items-center justify-center text-rose-600 mb-6 group-hover:scale-110 transition-transform">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"/></svg>
            </div>
            <p class="text-xs text-slate-400 font-bold uppercase tracking-widest mb-1">Withdrawal Pending</p>
            <p class="text-3xl font-black text-slate-900"><span class="text-sm font-medium text-slate-400">Rp</span> {{ number_format($pendingWithdrawal, 0, ',', '.') }}</p>
        </div>
    </div>

    <!-- Revenue Chart -->
    <div x-data='{chart:@json($chart)}' class="bg-white rounded-[2.5rem] p-10 border border-slate-100 shadow-sm">
        <div class="flex items-center justify-between mb-12">
            <div>
                <h2 class="text-xl font-bold text-slate-900">Grafik Pendapatan</h2>
                <p class="text-sm text-slate-400 font-medium">Data 6 bulan terakhir</p>
            </div>
            <div class="flex items-center gap-2">
                <div class="w-3 h-3 rounded-full bg-primary-500"></div>
                <span class="text-xs font-bold text-slate-400 uppercase tracking-widest">Pendapatan (IDR)</span>
            </div>
        </div>

        <div class="flex items-end gap-4 h-64">
            <template x-for="item in chart" :key="item.label">
                <div class="flex-1 flex flex-col items-center group h-full justify-end">
                    <div class="relative w-full flex justify-center items-end h-full">
                        <div class="absolute -top-10 scale-0 group-hover:scale-100 transition-transform bg-slate-900 text-white text-[10px] font-bold py-1 px-2 rounded-lg whitespace-nowrap z-10 shadow-xl">
                            Rp <span x-text="new Intl.NumberFormat('id-ID').format(item.amount)"></span>
                        </div>
                        <div class="w-full max-w-[40px] rounded-t-xl bg-primary-100 group-hover:bg-primary-600 transition-all duration-500" :style="`height:${Math.max(10, (item.amount / Math.max(...chart.map(i => i.amount || 1))) * 100)}%`" :title="item.amount"></div>
                    </div>
                    <p class="mt-4 text-[10px] font-bold text-slate-400 uppercase tracking-widest" x-text="item.label"></p>
                </div>
            </template>
        </div>
    </div>
@endsection
