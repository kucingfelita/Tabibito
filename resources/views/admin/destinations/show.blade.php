@extends('layouts.app')

@section('content')
@php
    $allImages = collect();
    if ($destination->coverImage) {
        $allImages->push($destination->coverImage);
    }
    if ($destination->slideImages?->isNotEmpty()) {
        $allImages = $allImages->concat($destination->slideImages);
    }
    $stats = $transactionStats;
@endphp

<div class="max-w-7xl mx-auto px-4 md:px-6">
    <div class="mb-6 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <a href="{{ route('admin.destinations.index') }}" class="inline-flex items-center gap-2 text-xs font-bold text-slate-500 hover:text-primary-600 transition-colors">
            <i class="fa-solid fa-arrow-left"></i> Kembali ke Rangkuman Destinasi
        </a>
        @if($destination->status === 'active')
            <a href="{{ route('destinations.show', $destination) }}" target="_blank"
               class="inline-flex items-center gap-2 text-xs font-extrabold text-primary-600 hover:text-primary-700 uppercase tracking-wider">
                <i class="fa-solid fa-arrow-up-right-from-square"></i> Lihat di Situs Publik
            </a>
        @endif
    </div>

    @include('admin.partials.nav')

    @if(session('success'))
        <div class="mb-6 rounded-2xl bg-emerald-50 border border-emerald-100 text-emerald-800 px-5 py-4 text-sm font-semibold">
            <i class="fa-solid fa-circle-check mr-1"></i> {{ session('success') }}
        </div>
    @endif

    <!-- Hero header -->
    <div class="mb-8 bg-slate-900 rounded-[2.5rem] overflow-hidden text-white relative shadow-xl">
        <div class="grid lg:grid-cols-2">
            <div class="relative h-56 lg:h-auto min-h-[220px] bg-slate-800">
                @if($destination->coverImage)
                    <img src="{{ asset('storage/' . $destination->coverImage->image_path) }}" alt="{{ $destination->name }}"
                         class="w-full h-full object-cover opacity-90">
                @endif
                <div class="absolute inset-0 bg-gradient-to-r from-slate-900/80 to-transparent"></div>
            </div>
            <div class="p-8 md:p-10 relative z-10 flex flex-col justify-center">
                <span class="inline-flex self-start px-2.5 py-1 rounded-lg text-[9px] font-black uppercase tracking-wider mb-3
                    @if($destination->status === 'active') bg-emerald-500
                    @elseif($destination->status === 'pending') bg-amber-500
                    @else bg-rose-500 @endif">
                    {{ $destination->status === 'active' ? 'Aktif' : ($destination->status === 'pending' ? 'Menunggu Persetujuan' : 'Ditolak') }}
                </span>
                <h1 class="text-2xl md:text-3xl font-black tracking-tight leading-tight">{{ $destination->name }}</h1>
                <p class="text-sm text-slate-300 font-semibold mt-2 flex items-center gap-2">
                    <i class="fa-solid fa-location-dot text-rose-400"></i> {{ $destination->city }} · {{ $destination->address }}
                </p>
                @if($destination->open_time && $destination->close_time)
                    <p class="text-xs text-slate-400 font-bold mt-2">
                        <i class="fa-regular fa-clock mr-1"></i> {{ $destination->open_time }} – {{ $destination->close_time }}
                    </p>
                @endif
                @if($destination->status === 'pending')
                    <div class="flex flex-wrap gap-2 mt-6">
                        <form method="POST" action="{{ route('admin.destinations.approve', $destination) }}">
                            @csrf @method('PATCH')
                            <button type="submit" class="bg-emerald-500 hover:bg-emerald-600 text-white font-extrabold px-5 py-2.5 rounded-xl text-xs uppercase tracking-wider">
                                <i class="fa-solid fa-check mr-1"></i> Setujui Destinasi
                            </button>
                        </form>
                        <form method="POST" action="{{ route('admin.destinations.reject', $destination) }}">
                            @csrf @method('PATCH')
                            <button type="submit" class="bg-white/10 hover:bg-white/20 text-white font-extrabold px-5 py-2.5 rounded-xl text-xs uppercase tracking-wider border border-white/20">
                                Tolak
                            </button>
                        </form>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <!-- Stats row -->
    <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-8">
        <div class="bg-white rounded-2xl border border-slate-100 p-5 text-center shadow-sm">
            <p class="text-[8px] font-black text-slate-400 uppercase tracking-widest">Paket Tiket</p>
            <p class="text-2xl font-black text-primary-600 mt-1">{{ $destination->tickets->count() }}</p>
        </div>
        <div class="bg-white rounded-2xl border border-slate-100 p-5 text-center shadow-sm">
            <p class="text-[8px] font-black text-slate-400 uppercase tracking-widest">Tiket Terjual</p>
            <p class="text-2xl font-black text-emerald-600 mt-1">{{ (int) ($stats->tickets_sold ?? 0) }}</p>
        </div>
        <div class="bg-white rounded-2xl border border-slate-100 p-5 text-center shadow-sm">
            <p class="text-[8px] font-black text-slate-400 uppercase tracking-widest">Transaksi Lunas</p>
            <p class="text-2xl font-black text-slate-900 mt-1">{{ (int) ($stats->paid_count ?? 0) }}</p>
        </div>
        <div class="bg-white rounded-2xl border border-slate-100 p-5 text-center shadow-sm">
            <p class="text-[8px] font-black text-slate-400 uppercase tracking-widest">Omzet</p>
            <p class="text-lg font-black text-slate-900 mt-1">Rp {{ number_format((float) ($stats->total_revenue ?? 0), 0, ',', '.') }}</p>
        </div>
    </div>

    <div class="grid gap-8 lg:grid-cols-3">
        <!-- Left: content -->
        <div class="lg:col-span-2 space-y-8">
            <!-- Owner card -->
            <section class="bg-white rounded-[2rem] border border-slate-100 p-6 md:p-8 shadow-sm">
                <h2 class="text-lg font-black text-slate-900 mb-5 flex items-center gap-2">
                    <i class="fa-solid fa-user-tie text-primary-500"></i> Pemilik / Mitra
                </h2>
                @if($destination->owner)
                    <div class="flex items-start gap-4">
                        <div class="w-14 h-14 rounded-2xl bg-gradient-to-tr from-primary-600 to-violet-500 flex items-center justify-center text-white text-xl font-black shrink-0">
                            {{ strtoupper(substr($destination->owner->name, 0, 1)) }}
                        </div>
                        <div class="space-y-2 min-w-0 flex-1">
                            <p class="font-black text-slate-900 text-lg">{{ $destination->owner->name }}</p>
                            <p class="text-sm text-slate-500 font-semibold"><i class="fa-solid fa-at text-slate-400 mr-1"></i>{{ $destination->owner->username }}</p>
                            <p class="text-sm text-slate-600"><i class="fa-solid fa-envelope text-primary-500 mr-2"></i>{{ $destination->owner->email }}</p>
                            @if($destination->owner->phone)
                                <p class="text-sm text-slate-600"><i class="fa-solid fa-phone text-emerald-500 mr-2"></i>{{ $destination->owner->phone }}</p>
                            @endif
                            <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest mt-2">
                                Tipe akun:
                                @if($destination->owner->tipe_user === \App\Models\User::TYPE_OWNER)
                                    <span class="text-emerald-600">Owner Terverifikasi</span>
                                @else
                                    <span class="text-amber-600">Belum Owner (Traveler)</span>
                                @endif
                            </p>
                        </div>
                    </div>
                @else
                    <p class="text-slate-400 text-sm">Data pemilik tidak ditemukan.</p>
                @endif
            </section>

            <!-- Description -->
            <section class="bg-white rounded-[2rem] border border-slate-100 p-6 md:p-8 shadow-sm">
                <h2 class="text-lg font-black text-slate-900 mb-4 flex items-center gap-2">
                    <i class="fa-solid fa-align-left text-violet-500"></i> Deskripsi & Informasi
                </h2>
                <div class="prose prose-sm max-w-none text-slate-600 font-medium leading-relaxed whitespace-pre-line">{{ $destination->description ?: '—' }}</div>
                @if($destination->map_link)
                    <a href="{{ $destination->map_link }}" target="_blank" rel="noopener"
                       class="inline-flex items-center gap-2 mt-4 text-xs font-extrabold text-primary-600 hover:text-primary-700 uppercase tracking-wider">
                        <i class="fa-solid fa-map"></i> Buka di Google Maps
                    </a>
                @endif
                @if($destination->tags->isNotEmpty())
                    <div class="flex flex-wrap gap-2 mt-5 pt-5 border-t border-slate-50">
                        @foreach($destination->tags as $tag)
                            <span class="px-3 py-1 rounded-lg bg-slate-50 text-[10px] font-extrabold text-slate-600 uppercase tracking-wider border border-slate-100">{{ $tag->name }}</span>
                        @endforeach
                    </div>
                @endif
            </section>

            <!-- Tickets -->
            <section class="bg-white rounded-[2rem] border border-slate-100 p-6 md:p-8 shadow-sm">
                <h2 class="text-lg font-black text-slate-900 mb-5 flex items-center gap-2">
                    <i class="fa-solid fa-ticket text-amber-500"></i> Paket Tiket ({{ $destination->tickets->count() }})
                </h2>
                <div class="space-y-3">
                    @forelse($destination->tickets as $ticket)
                        <div class="rounded-2xl border border-slate-100 p-4 bg-slate-50/50 flex flex-col sm:flex-row sm:items-center justify-between gap-3">
                            <div>
                                <h3 class="font-extrabold text-slate-800">{{ $ticket->name }}</h3>
                                @if($ticket->benefit)
                                    <p class="text-xs text-slate-500 mt-1">{{ $ticket->benefit }}</p>
                                @endif
                            </div>
                            <div class="text-right shrink-0">
                                <p class="font-black text-primary-600">Rp {{ number_format($ticket->price, 0, ',', '.') }}</p>
                                <p class="text-[10px] text-slate-400 font-bold">Kuota/hari: {{ $ticket->daily_quota }}</p>
                            </div>
                        </div>
                    @empty
                        <p class="text-sm text-slate-400">Belum ada paket tiket.</p>
                    @endforelse
                </div>
            </section>

            <!-- Gallery -->
            @if($allImages->isNotEmpty())
            <section class="bg-white rounded-[2rem] border border-slate-100 p-6 md:p-8 shadow-sm">
                <h2 class="text-lg font-black text-slate-900 mb-5 flex items-center gap-2">
                    <i class="fa-solid fa-images text-rose-500"></i> Galeri Foto
                </h2>
                <div class="grid grid-cols-2 md:grid-cols-3 gap-3">
                    @foreach($allImages as $image)
                        <div class="aspect-video rounded-xl overflow-hidden bg-slate-100 border border-slate-100">
                            <img src="{{ asset('storage/' . $image->image_path) }}" alt="" class="w-full h-full object-cover">
                        </div>
                    @endforeach
                </div>
            </section>
            @endif
        </div>

        <!-- Right: recent transactions -->
        <div class="space-y-6">
            <section class="bg-white rounded-[2rem] border border-slate-100 p-6 shadow-sm sticky top-24">
                <h2 class="text-base font-black text-slate-900 mb-4 flex items-center gap-2">
                    <i class="fa-solid fa-receipt text-primary-500"></i> Transaksi Terbaru
                </h2>
                <div class="space-y-1 text-[10px] text-slate-500 font-bold mb-4 pb-4 border-b border-slate-50">
                    Total pesanan: {{ (int) ($stats->total_orders ?? 0) }} · Pending: {{ (int) ($stats->pending_count ?? 0) }}
                </div>
                <div class="divide-y divide-slate-50 max-h-[420px] overflow-y-auto">
                    @forelse($recentTransactions as $trx)
                        <div class="py-3">
                            <p class="font-bold text-slate-800 text-xs truncate">{{ $trx->order_id }}</p>
                            <p class="text-[10px] text-slate-500 mt-0.5">{{ $trx->user?->name ?? '—' }} · {{ $trx->ticket?->name }}</p>
                            <p class="text-[10px] font-black text-slate-700 mt-1">Rp {{ number_format($trx->total_price, 0, ',', '.') }} · {{ $trx->qty }} tiket</p>
                            @if($trx->status === 'settlement' || $trx->status === 'used')
                                <span class="inline-block mt-1 px-2 py-0.5 rounded bg-emerald-50 text-emerald-600 text-[8px] font-black uppercase">Lunas</span>
                            @elseif($trx->status === 'pending')
                                <span class="inline-block mt-1 px-2 py-0.5 rounded bg-amber-50 text-amber-600 text-[8px] font-black uppercase">Pending</span>
                            @else
                                <span class="inline-block mt-1 px-2 py-0.5 rounded bg-slate-100 text-slate-500 text-[8px] font-black uppercase">{{ $trx->status }}</span>
                            @endif
                        </div>
                    @empty
                        <p class="text-sm text-slate-400 py-6 text-center">Belum ada transaksi.</p>
                    @endforelse
                </div>
            </section>

            <div class="text-[10px] text-slate-400 font-semibold text-center">
                ID destinasi #{{ $destination->id }} · Dibuat {{ $destination->created_at?->format('d M Y') }}
            </div>
        </div>
    </div>
</div>
@endsection
