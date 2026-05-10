@extends('layouts.app')

@section('content')
    @include('owner.partials.nav')

    <div class="mt-6 mb-8 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <h1 class="text-2xl font-black text-slate-900">Riwayat Scan Tiket</h1>
            <p class="mt-1 text-sm text-slate-500">Daftar tiket yang telah discan / ditukarkan.</p>
        </div>

        {{-- Filter tanggal --}}
        <form method="GET" action="{{ route('owner.scan-history') }}" class="flex items-center gap-2">
            <label for="date" class="text-sm font-semibold text-slate-600 whitespace-nowrap">Tanggal:</label>
            <input
                id="date"
                type="date"
                name="date"
                value="{{ $date }}"
                max="{{ now()->toDateString() }}"
                class="rounded-xl border border-slate-200 px-4 py-2 text-sm font-medium focus:border-primary-400 focus:outline-none focus:ring-2 focus:ring-primary-100"
            >
            <button type="submit" class="rounded-xl bg-primary-600 px-5 py-2 text-sm font-bold text-white shadow hover:bg-primary-700 transition-colors">
                Tampilkan
            </button>
            @if($date !== now()->toDateString())
                <a href="{{ route('owner.scan-history') }}" class="rounded-xl border border-slate-200 px-4 py-2 text-sm font-semibold text-slate-500 hover:bg-slate-50 transition-colors">
                    Hari Ini
                </a>
            @endif
        </form>
    </div>

    {{-- Info badge tanggal --}}
    <div class="mb-5 flex items-center gap-3">
        <span class="inline-flex items-center gap-1.5 rounded-full bg-primary-50 px-4 py-1.5 text-sm font-bold text-primary-700">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
            {{ \Carbon\Carbon::parse($date)->translatedFormat('l, d F Y') }}
        </span>
        <span class="inline-flex items-center gap-1.5 rounded-full bg-emerald-50 px-4 py-1.5 text-sm font-bold text-emerald-700">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg>
            {{ $transactions->count() }} Tiket Discan
        </span>
        @if($transactions->count() > 0)
            <span class="inline-flex items-center gap-1.5 rounded-full bg-amber-50 px-4 py-1.5 text-sm font-bold text-amber-700">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                {{ $transactions->sum('qty') }} Pengunjung
            </span>
        @endif
    </div>

    {{-- Tabel --}}
    <div class="overflow-hidden rounded-[2rem] border border-slate-100 bg-white shadow-sm">
        @if($transactions->isEmpty())
            <div class="flex flex-col items-center justify-center py-20 text-center">
                <div class="mb-4 flex h-20 w-20 items-center justify-center rounded-full bg-slate-50">
                    <svg class="h-10 w-10 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                    </svg>
                </div>
                <p class="text-base font-bold text-slate-400">Belum ada tiket yang discan</p>
                <p class="mt-1 text-sm text-slate-400">pada tanggal {{ \Carbon\Carbon::parse($date)->translatedFormat('d F Y') }}</p>
            </div>
        @else
            <div class="overflow-x-auto">
                <table class="w-full text-sm">
                    <thead>
                        <tr class="border-b border-slate-100 bg-slate-50/50">
                            <th class="px-6 py-4 text-left text-xs font-bold uppercase tracking-widest text-slate-400">Waktu Scan</th>
                            <th class="px-6 py-4 text-left text-xs font-bold uppercase tracking-widest text-slate-400">Nama Pengunjung</th>
                            <th class="px-6 py-4 text-left text-xs font-bold uppercase tracking-widest text-slate-400">Jenis Tiket</th>
                            <th class="px-6 py-4 text-left text-xs font-bold uppercase tracking-widest text-slate-400">Tgl Kunjungan</th>
                            <th class="px-6 py-4 text-center text-xs font-bold uppercase tracking-widest text-slate-400">Jumlah</th>
                            <th class="px-6 py-4 text-right text-xs font-bold uppercase tracking-widest text-slate-400">Total Harga</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-50">
                        @foreach($transactions as $trx)
                            <tr class="group hover:bg-slate-50/80 transition-colors">
                                <td class="px-6 py-4 text-slate-500">
                                    {{ $trx->updated_at->format('H:i') }}
                                    <span class="ml-1 text-xs text-slate-400">WIB</span>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="flex items-center gap-3">
                                        <div class="flex h-9 w-9 shrink-0 items-center justify-center rounded-full bg-primary-100 text-sm font-black text-primary-700">
                                            {{ strtoupper(substr($trx->user->name, 0, 1)) }}
                                        </div>
                                        <div>
                                            <p class="font-semibold text-slate-800">{{ $trx->user->name }}</p>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4">
                                    <span class="inline-flex items-center rounded-full bg-primary-50 px-3 py-1 text-xs font-bold text-primary-700">
                                        {{ $trx->ticket->name }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 text-slate-600 font-medium">
                                    {{ $trx->booking_date->format('d M Y') }}
                                </td>
                                <td class="px-6 py-4 text-center">
                                    <span class="inline-flex h-7 w-7 items-center justify-center rounded-full bg-emerald-100 text-xs font-black text-emerald-700">
                                        {{ $trx->qty }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 text-right font-bold text-slate-800">
                                    <span class="text-xs font-medium text-slate-400">Rp</span>
                                    {{ number_format($trx->total_price, 0, ',', '.') }}
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                    <tfoot>
                        <tr class="border-t-2 border-slate-100 bg-slate-50/80">
                            <td colspan="4" class="px-6 py-4 text-sm font-bold text-slate-600">Total</td>
                            <td class="px-6 py-4 text-center">
                                <span class="inline-flex h-7 w-auto min-w-[1.75rem] items-center justify-center rounded-full bg-emerald-600 px-2 text-xs font-black text-white">
                                    {{ $transactions->sum('qty') }}
                                </span>
                            </td>
                            <td class="px-6 py-4 text-right font-black text-slate-900">
                                <span class="text-xs font-medium text-slate-400">Rp</span>
                                {{ number_format($transactions->sum('total_price'), 0, ',', '.') }}
                            </td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        @endif
    </div>
@endsection
