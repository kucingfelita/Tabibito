@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto w-full min-w-0 px-0 sm:px-2 md:px-6">
    <div class="mb-6 md:mb-8 flex flex-col lg:flex-row lg:items-end justify-between gap-4">
        <div>
            <h1 class="text-2xl sm:text-3xl font-black text-slate-900 tracking-tight">Rangkuman Destinasi Wisata</h1>
            <p class="text-xs text-slate-400 font-bold uppercase tracking-wider mt-1">Lihat pemilik, status, tiket, dan detail lengkap setiap destinasi</p>
        </div>
        <a href="{{ route('admin.dashboard') }}" class="inline-flex items-center gap-2 text-xs font-bold text-slate-500 hover:text-primary-600 transition-colors">
            <i class="fa-solid fa-arrow-left"></i> Kembali ke Dashboard
        </a>
    </div>

    @include('admin.partials.nav')

  @if(session('success'))
        <div class="mb-6 rounded-2xl bg-emerald-50 border border-emerald-100 text-emerald-800 px-5 py-4 text-sm font-semibold">
            <i class="fa-solid fa-circle-check mr-1"></i> {{ session('success') }}
        </div>
    @endif

    <!-- Filter tabs -->
    <div class="mobile-scroll-tabs mb-6">
        @foreach(['all' => 'Semua', 'pending' => 'Pending', 'active' => 'Aktif', 'maintenance' => 'Perawatan', 'rejected' => 'Ditolak'] as $key => $label)
            <a href="{{ route('admin.destinations.index', array_filter(['status' => $key !== 'all' ? $key : null, 'q' => $search ?: null])) }}"
               class="px-4 py-2 rounded-xl text-xs font-extrabold uppercase tracking-wider transition-all
                      {{ $status === $key ? 'bg-primary-600 text-white shadow-md' : 'bg-white text-slate-600 border border-slate-100 hover:bg-slate-50' }}">
                {{ $label }}
                <span class="ml-1 opacity-80">({{ $counts[$key] }})</span>
            </a>
        @endforeach
    </div>

    <!-- Search -->
    <form method="GET" action="{{ route('admin.destinations.index') }}" class="mb-8 flex flex-col sm:flex-row gap-3">
        @if($status !== 'all')
            <input type="hidden" name="status" value="{{ $status }}">
        @endif
        <div class="relative flex-1">
            <i class="fa-solid fa-magnifying-glass absolute left-4 top-1/2 -translate-y-1/2 text-slate-400"></i>
            <input type="search" name="q" value="{{ $search }}" placeholder="Cari nama destinasi, kota, alamat, atau nama owner..."
                   class="w-full bg-white border border-slate-100 rounded-2xl pl-11 pr-4 py-3.5 text-sm font-semibold text-slate-800 focus:ring-2 focus:ring-primary-500/20 focus:border-primary-500 outline-none">
        </div>
        <button type="submit" class="w-full sm:w-auto bg-slate-900 hover:bg-slate-800 text-white font-extrabold px-6 py-3.5 rounded-2xl text-xs uppercase tracking-wider">Cari</button>
    </form>

    <div class="grid gap-5 md:grid-cols-2 xl:grid-cols-3">
        @forelse($destinations as $destination)
            <article class="bg-white rounded-[2rem] border border-slate-100 shadow-sm hover:shadow-lg transition-all overflow-hidden flex flex-col">
                <div class="relative h-40 bg-slate-100">
                    @if($destination->coverImage)
                        <img src="{{ asset('storage/' . $destination->coverImage->image_path) }}" alt="{{ $destination->name }}"
                             class="w-full h-full object-cover">
                    @else
                        <div class="w-full h-full flex items-center justify-center text-slate-300">
                            <i class="fa-solid fa-image text-4xl"></i>
                        </div>
                    @endif
                    <span class="absolute top-3 left-3 px-2.5 py-1 rounded-lg text-[9px] font-black uppercase tracking-wider
                        @if($destination->status === 'active') bg-emerald-500 text-white
                        @elseif($destination->status === 'pending') bg-amber-500 text-white
                        @elseif($destination->status === 'maintenance') bg-slate-500 text-white
                        @elseif($destination->status === 'rejected') bg-rose-500 text-white
                        @else bg-slate-500 text-white @endif">
                        @if($destination->status === 'active') Aktif
                        @elseif($destination->status === 'pending') Pending
                        @elseif($destination->status === 'maintenance') Perawatan
                        @elseif($destination->status === 'rejected') Ditolak
                        @else {{ $destination->status }}
                        @endif
                    </span>
                </div>

                <div class="p-5 flex-1 flex flex-col">
                    <h2 class="font-black text-slate-900 text-lg leading-snug line-clamp-2">{{ $destination->name }}</h2>
                    <p class="text-xs text-slate-500 font-semibold mt-1 flex items-center gap-1">
                        <i class="fa-solid fa-location-dot text-rose-500"></i> {{ $destination->city }}
                    </p>

                    <div class="mt-4 p-3 rounded-xl bg-slate-50 border border-slate-100 space-y-1.5">
                        <p class="text-[9px] font-black text-slate-400 uppercase tracking-widest">Pemilik / Mitra</p>
                        <p class="text-sm font-extrabold text-slate-800">{{ $destination->owner?->name ?? '—' }}</p>
                        <p class="text-[10px] text-slate-500 font-semibold truncate">{{ $destination->owner?->email }}</p>
                        @if($destination->owner?->phone)
                            <p class="text-[10px] text-slate-500"><i class="fa-solid fa-phone text-primary-500 mr-1"></i>{{ $destination->owner->phone }}</p>
                        @endif
                    </div>

                    <div class="grid grid-cols-2 gap-2 mt-4 text-center">
                        <div class="rounded-xl bg-primary-50/50 py-2 px-2">
                            <p class="text-[8px] font-black text-slate-400 uppercase">Paket Tiket</p>
                            <p class="text-sm font-black text-primary-700">{{ $destination->tickets_count }}</p>
                        </div>
                        <div class="rounded-xl bg-emerald-50/50 py-2 px-2">
                            <p class="text-[8px] font-black text-slate-400 uppercase">Terjual</p>
                            <p class="text-sm font-black text-emerald-700">{{ $destination->sold_transactions_count }}</p>
                        </div>
                    </div>

                    <div class="mt-5 flex gap-2">
                        <a href="{{ route('admin.destinations.show', $destination) }}"
                           class="flex-1 text-center bg-primary-600 hover:bg-primary-700 text-white font-extrabold py-3 rounded-xl text-xs uppercase tracking-wider">
                            Lihat Lengkap
                        </a>
                        @if($destination->status === 'pending')
                            <form method="POST" action="{{ route('admin.destinations.approve', $destination) }}">
                                @csrf @method('PATCH')
                                <button type="submit" class="bg-emerald-600 hover:bg-emerald-700 text-white font-extrabold px-3 py-3 rounded-xl text-xs" title="Setujui">
                                    <i class="fa-solid fa-check"></i>
                                </button>
                            </form>
                            <button type="button"
                                    onclick="openRejectDestinationModal(@js(route('admin.destinations.reject', $destination)), @js($destination->name))"
                                    class="bg-rose-50 hover:bg-rose-100 text-rose-600 font-extrabold px-3 py-3 rounded-xl text-xs border border-rose-100" title="Tolak">
                                <i class="fa-solid fa-xmark"></i>
                            </button>
                        @endif
                    </div>
                </div>
            </article>
        @empty
            <div class="col-span-full py-16 text-center text-slate-400">
                <i class="fa-solid fa-map text-4xl mb-3"></i>
                <p class="font-semibold text-sm">Tidak ada destinasi ditemukan.</p>
            </div>
        @endforelse
    </div>

    <div class="mt-8">{{ $destinations->links() }}</div>
</div>

@push('modals')
    @include('admin.partials.reject-destination-modal')
@endpush
@endsection
