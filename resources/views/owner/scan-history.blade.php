@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto px-4 md:px-6">
    <!-- Header -->
    <div class="mb-8">
        <h1 class="text-3xl font-black text-slate-900 tracking-tight">Riwayat Pemindaian Tiket</h1>
        <p class="text-xs text-slate-400 font-bold uppercase tracking-wider mt-1">Lacak seluruh transaksi tiket pengunjung yang telah berhasil discan hari ini maupun tanggal lainnya</p>
    </div>

    @include('owner.partials.nav')

    <!-- Filter & Stat Panel -->
    <div class="mt-8 grid gap-6 lg:grid-cols-3 items-stretch">
        
        <!-- Filter Card -->
        <div class="bg-white rounded-[2rem] border border-slate-100 shadow-xl shadow-slate-200/40 p-6 flex flex-col justify-center relative overflow-hidden">
            <div class="absolute top-0 right-0 w-24 h-24 bg-primary-50 rounded-full -mr-12 -mt-12 opacity-50"></div>
            
            <form method="GET" action="{{ route('owner.scan-history') }}" class="space-y-4 relative z-10">
                <div class="space-y-1.5">
                    <label for="date" class="block text-[10px] font-black text-slate-400 uppercase tracking-widest ml-1">Pilih Tanggal Riwayat</label>
                    <div class="relative group">
                        <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-slate-400 group-focus-within:text-primary-600 transition-colors">
                            <i class="fa-regular fa-calendar-days text-sm"></i>
                        </div>
                        <input id="date" type="date" name="date" value="{{ $date }}" max="{{ now()->toDateString() }}"
                               class="w-full bg-slate-50 border border-slate-100 rounded-2xl pl-11 pr-4 py-3 text-slate-800 font-bold focus:ring-2 focus:ring-primary-500/20 focus:border-primary-500 outline-none transition-all text-sm">
                    </div>
                </div>
                
                <div class="flex gap-2.5">
                    <button type="submit" class="flex-1 bg-primary-600 hover:bg-primary-700 text-white font-extrabold py-3 px-5 rounded-xl transition-all shadow-md shadow-primary-200 text-xs uppercase tracking-wider">
                        Tampilkan <i class="fa-solid fa-chevron-right text-[10px] ml-1"></i>
                    </button>
                    @if($date !== now()->toDateString())
                        <a href="{{ route('owner.scan-history') }}" class="inline-flex items-center justify-center bg-slate-50 border border-slate-100 text-slate-600 font-extrabold py-3 px-5 rounded-xl hover:bg-slate-100 transition-all text-xs uppercase tracking-wider">
                            Hari Ini
                        </a>
                    @endif
                </div>
            </form>
        </div>

        <!-- Stat Card 1 -->
        <div class="bg-white rounded-[2rem] border border-slate-100 shadow-xl shadow-slate-200/40 p-6 flex items-center gap-5 relative overflow-hidden group hover:border-emerald-200 transition-all">
            <div class="w-14 h-14 rounded-2xl bg-emerald-50 text-emerald-600 flex items-center justify-center text-xl shrink-0 group-hover:scale-115 transition-transform shadow-sm">
                <i class="fa-solid fa-qrcode"></i>
            </div>
            <div>
                <p class="text-[9px] text-slate-400 font-black uppercase tracking-widest">Tiket Discan</p>
                <h3 class="text-2xl font-black text-slate-900 mt-1 leading-none">{{ $transactions->count() }} <span class="text-xs font-semibold text-slate-400">Tiket</span></h3>
                <p class="text-[10px] text-emerald-600 font-bold mt-2 uppercase tracking-wide flex items-center gap-1"><i class="fa-solid fa-calendar-day"></i> {{ \Carbon\Carbon::parse($date)->translatedFormat('d M Y') }}</p>
            </div>
        </div>

        <!-- Stat Card 2 -->
        <div class="bg-white rounded-[2rem] border border-slate-100 shadow-xl shadow-slate-200/40 p-6 flex items-center gap-5 relative overflow-hidden group hover:border-amber-200 transition-all">
            <div class="w-14 h-14 rounded-2xl bg-amber-50 text-amber-600 flex items-center justify-center text-xl shrink-0 group-hover:scale-115 transition-transform shadow-sm">
                <i class="fa-solid fa-users"></i>
            </div>
            <div>
                <p class="text-[9px] text-slate-400 font-black uppercase tracking-widest">Total Kunjungan</p>
                <h3 class="text-2xl font-black text-slate-900 mt-1 leading-none">{{ $transactions->sum('qty') }} <span class="text-xs font-semibold text-slate-400">Orang / Pax</span></h3>
                <p class="text-[10px] text-slate-400 font-bold mt-2 uppercase tracking-wide"><i class="fa-solid fa-ticket-simple mr-1 text-primary-500"></i>Rp {{ number_format($transactions->sum('total_price'), 0, ',', '.') }}</p>
            </div>
        </div>
    </div>

    <!-- Table Section -->
    <div class="mt-8">
        <div class="bg-white rounded-[2.5rem] border border-slate-100 shadow-xl shadow-slate-200/40 overflow-hidden">
            @if($transactions->isEmpty())
                <div class="flex flex-col items-center justify-center py-20 text-center space-y-4">
                    <div class="w-20 h-20 rounded-full bg-slate-50 flex items-center justify-center text-slate-300">
                        <i class="fa-solid fa-clipboard-question text-3xl"></i>
                    </div>
                    <div>
                        <p class="text-base font-black text-slate-800">Belum Ada Tiket yang Discan</p>
                        <p class="text-xs text-slate-400 mt-1 font-semibold">Tidak ada aktivitas pemindaian tiket pada tanggal {{ \Carbon\Carbon::parse($date)->translatedFormat('d F Y') }}</p>
                    </div>
                </div>
            @else
                <div class="overflow-x-auto">
                    <table class="w-full text-sm">
                        <thead>
                            <tr class="border-b border-slate-100 bg-slate-50/50">
                                <th class="px-8 py-5 text-left text-[10px] font-black uppercase tracking-widest text-slate-400">Waktu Scan</th>
                                <th class="px-8 py-5 text-left text-[10px] font-black uppercase tracking-widest text-slate-400">Nama Pengunjung</th>
                                <th class="px-8 py-5 text-left text-[10px] font-black uppercase tracking-widest text-slate-400">Jenis Tiket</th>
                                <th class="px-8 py-5 text-left text-[10px] font-black uppercase tracking-widest text-slate-400">Tgl Kunjungan</th>
                                <th class="px-8 py-5 text-center text-[10px] font-black uppercase tracking-widest text-slate-400">Jumlah</th>
                                <th class="px-8 py-5 text-right text-[10px] font-black uppercase tracking-widest text-slate-400">Total Harga</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-50">
                            @foreach($transactions as $trx)
                                <tr class="group hover:bg-slate-50/50 transition-colors">
                                    <td class="px-8 py-4.5 text-slate-500 font-extrabold text-xs">
                                        <i class="fa-regular fa-clock text-slate-400 mr-1.5"></i>{{ $trx->updated_at->format('H:i') }}
                                        <span class="text-[10px] text-slate-400 font-bold uppercase tracking-wide">WIB</span>
                                    </td>
                                    <td class="px-8 py-4.5">
                                        <div class="flex items-center gap-3">
                                            <div class="flex h-9 w-9 shrink-0 items-center justify-center rounded-xl bg-gradient-to-tr from-primary-600 to-primary-500 text-sm font-black text-white shadow-sm uppercase">
                                                {{ substr($trx->user->name, 0, 1) }}
                                            </div>
                                            <div>
                                                <p class="font-extrabold text-slate-800 text-xs md:text-sm leading-snug">{{ $trx->user->name }}</p>
                                                <p class="text-[10px] text-slate-400 font-bold mt-0.5">{{ $trx->user->email }}</p>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-8 py-4.5">
                                        <span class="inline-flex items-center rounded-lg bg-primary-50 px-3 py-1 text-[10px] font-black text-primary-700 uppercase tracking-wide border border-primary-100">
                                            {{ $ticket->name }}
                                        </span>
                                    </td>
                                    <td class="px-8 py-4.5 text-slate-500 font-extrabold text-xs">
                                        <i class="fa-regular fa-calendar-days text-slate-400 mr-1.5"></i>{{ $trx->booking_date->format('d M Y') }}
                                    </td>
                                    <td class="px-8 py-4.5 text-center">
                                        <span class="inline-flex h-7 w-7 items-center justify-center rounded-lg bg-emerald-50 text-xs font-black text-emerald-700 border border-emerald-100">
                                            {{ $trx->qty }}
                                        </span>
                                    </td>
                                    <td class="px-8 py-4.5 text-right font-black text-slate-900 text-xs md:text-sm">
                                        <span class="text-[10px] font-medium text-slate-400">Rp</span>
                                        {{ number_format($trx->total_price, 0, ',', '.') }}
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                        <tfoot>
                            <tr class="border-t-2 border-slate-100 bg-slate-50/80">
                                <td colspan="4" class="px-8 py-5 text-xs font-black text-slate-600 uppercase tracking-widest">Total Seluruh Pemindaian</td>
                                <td class="px-8 py-5 text-center">
                                    <span class="inline-flex h-8 w-auto min-w-[2rem] items-center justify-center rounded-lg bg-emerald-600 px-3 text-xs font-black text-white shadow-sm shadow-emerald-200">
                                        {{ $transactions->sum('qty') }} Orang
                                    </span>
                                </td>
                                <td class="px-8 py-5 text-right font-black text-primary-700 text-base md:text-lg">
                                    <span class="text-xs font-semibold text-primary-500">Rp</span>
                                    {{ number_format($transactions->sum('total_price'), 0, ',', '.') }}
                                </td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
