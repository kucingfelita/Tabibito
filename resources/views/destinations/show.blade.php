@extends('layouts.app')

@section('content')
    <!-- Breadcrumbs -->
    <nav class="mb-8 flex items-center gap-2 text-sm">
        <a href="{{ route('home') }}" class="text-slate-400 hover:text-primary-600 transition-colors">Beranda</a>
        <svg class="w-4 h-4 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
        <a href="{{ route('destinations.index') }}" class="text-slate-400 hover:text-primary-600 transition-colors">Eksplor Wisata</a>
        <svg class="w-4 h-4 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
        <span class="text-slate-900 font-bold truncate">{{ $destination->name }}</span>
    </nav>

    <div class="grid gap-10 lg:grid-cols-[1.8fr_1fr]">
        <!-- Main Content -->
        <div class="space-y-10">
            <!-- Hero Section -->
            <div class="relative bg-white rounded-[2.5rem] overflow-hidden shadow-sm border border-slate-100">
                <div class="h-80 md:h-[450px] overflow-hidden relative">
                    @if($destination->images->first()?->image_path)
                        <img src="{{ asset('storage/' . $destination->images->first()->image_path) }}" alt="{{ $destination->name }}" class="h-full w-full object-cover">
                    @else
                        <div class="w-full h-full bg-slate-100 flex items-center justify-center">
                            <svg class="w-20 h-20 text-slate-200" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                        </div>
                    @endif
                    <div class="absolute inset-0 bg-gradient-to-t from-black/60 via-transparent to-transparent"></div>
                    <div class="absolute bottom-8 left-8 right-8">
                        <div class="flex flex-wrap gap-2 mb-4">
                            @foreach($destination->tags as $tag)
                                <span class="px-3 py-1 rounded-lg bg-white/20 backdrop-blur-md border border-white/30 text-xs font-bold text-white uppercase tracking-widest">{{ $tag->name }}</span>
                            @endforeach
                        </div>
                        <h1 class="text-3xl md:text-5xl font-black text-white">{{ $destination->name }}</h1>
                    </div>
                </div>
                
                <div class="p-8 md:p-10">
                    <div class="flex flex-wrap items-center gap-6 mb-8 text-sm text-slate-500 font-medium">
                        <div class="flex items-center gap-2">
                            <div class="w-8 h-8 rounded-lg bg-primary-50 flex items-center justify-center text-primary-600">
                                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M5.05 4.05a7 7 0 119.9 9.9L10 18.9l-4.95-4.95a7 7 0 010-9.9zM10 11a2 2 0 100-4 2 2 0 000 4z" clip-rule="evenodd"/></svg>
                            </div>
                            {{ $destination->city }}
                        </div>
                        <div class="flex items-center gap-2">
                            <div class="w-8 h-8 rounded-lg bg-amber-50 flex items-center justify-center text-amber-600">
                                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd"/></svg>
                            </div>
                            {{ $destination->open_time }} - {{ $destination->close_time }}
                        </div>
                    </div>

                    <div class="prose prose-slate max-w-none">
                        @if($destination->transactions_avg_rating > 0)
                        <div class="flex items-center gap-2 mb-6 bg-amber-50 inline-flex px-4 py-2 rounded-2xl border border-amber-100">
                            <div class="flex items-center gap-1 text-amber-500">
                                <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                            </div>
                            <span class="text-xl font-black text-amber-700">{{ number_format($destination->transactions_avg_rating, 1) }}</span>
                            <span class="text-sm text-amber-600 font-medium">/ 5.0 dari pengunjung</span>
                        </div>
                        @endif
                        <h2 class="text-xl font-bold text-slate-900 mb-4">Tentang Destinasi</h2>
                        <p class="text-slate-600 leading-relaxed text-lg">{{ $destination->description }}</p>
                    </div>

                    <div class="mt-10 pt-10 border-t border-slate-50">
                        <h2 class="text-xl font-bold text-slate-900 mb-4">Lokasi</h2>
                        <p class="text-slate-500 mb-6 flex items-start gap-2">
                            <svg class="w-5 h-5 text-primary-600 shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                            {{ $destination->address }}, {{ $destination->city }}
                        </p>
                        <a href="{{ $destination->map_link }}" target="_blank" class="inline-flex items-center gap-3 bg-white border-2 border-slate-100 px-6 py-3 rounded-2xl font-bold text-slate-700 hover:bg-slate-50 hover:border-primary-600/20 hover:text-primary-600 transition-all group">
                            Petunjuk Arah
                            <svg class="w-5 h-5 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
                        </a>
                    </div>
                </div>
            </div>

            <!-- Tickets Section -->
            <div>
                <h2 class="text-2xl font-bold text-slate-900 mb-8">Pilihan Tiket</h2>
                <div class="grid gap-6">
                    @foreach($destination->tickets as $ticket)
                        <div class="bg-white rounded-3xl border border-slate-100 p-6 md:p-8 shadow-sm hover:shadow-xl hover:-translate-y-1 transition-all duration-300">
                            <div class="flex flex-col md:flex-row md:items-center justify-between gap-6">
                                <div class="flex-1">
                                    <div class="flex items-center gap-3 mb-4">
                                        <div class="w-10 h-10 rounded-xl bg-primary-50 flex items-center justify-center text-primary-600 font-black">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 5v2m0 4v2m0 4v2M5 5a2 2 0 00-2 2v3a2 2 0 110 4v3a2 2 0 002 2h14a2 2 0 002-2v-3a2 2 0 110-4V7a2 2 0 00-2-2H5z"/></svg>
                                        </div>
                                        <h3 class="text-xl font-bold text-slate-900">{{ $ticket->name }}</h3>
                                    </div>
                                    <p class="text-slate-500 text-sm leading-relaxed mb-4">{{ $ticket->benefit }}</p>
                                    <div class="flex items-center gap-4 text-xs font-bold uppercase tracking-widest text-slate-400">
                                        <div class="flex items-center gap-1.5">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                            Kuota: {{ $ticket->daily_quota }} / hari
                                        </div>
                                    </div>
                                </div>
                                <div class="shrink-0 flex md:flex-col items-center md:items-end justify-between md:justify-center gap-4 pt-6 md:pt-0 border-t md:border-t-0 md:border-l border-slate-100 md:pl-10">
                                    <div class="text-left md:text-right">
                                        <p class="text-[10px] text-slate-400 font-bold uppercase tracking-widest mb-1">Harga Tiket</p>
                                        <p class="text-2xl font-black text-primary-600">
                                            <span class="text-xs font-medium">Rp</span> {{ number_format($ticket->price, 0, ',', '.') }}
                                        </p>
                                    </div>
                                    <a href="{{ route('tickets.show', $ticket) }}" class="btn-premium bg-primary-600 hover:bg-primary-700 text-white px-8 py-4 rounded-2xl font-bold shadow-lg shadow-primary-200 transition-all">
                                        Pesan Sekarang
                                    </a>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>

        <!-- Sidebar Info -->
        <aside class="space-y-8">
            <div class="sticky top-24 space-y-8">
                <!-- Owner Info -->
                <div class="bg-white rounded-3xl border border-slate-100 p-8 shadow-sm">
                    <h3 class="text-lg font-bold text-slate-900 mb-6">Informasi Kontak</h3>
                    <div class="flex items-center gap-4 mb-8">
                        <div class="w-12 h-12 rounded-full bg-slate-100 flex items-center justify-center font-bold text-slate-500 uppercase">
                            {{ substr($destination->owner?->name ?? 'A', 0, 1) }}
                        </div>
                        <div>
                            <p class="text-xs text-slate-400 font-bold uppercase tracking-widest">Dikelola oleh</p>
                            <p class="font-bold text-slate-900">{{ $destination->owner?->name ?? 'Admin Tabibito' }}</p>
                        </div>
                    </div>
                    
                    <div class="space-y-4">
                        <div class="p-4 rounded-2xl bg-slate-50 border border-slate-100">
                            <p class="text-xs text-slate-400 font-bold uppercase tracking-widest mb-1">Email</p>
                            <p class="text-sm font-medium text-slate-700 truncate">{{ $destination->owner?->email ?? 'info@tabibito.id' }}</p>
                        </div>
                        <p class="text-xs text-slate-400 leading-relaxed italic">Silakan hubungi pengelola untuk informasi fasilitas khusus atau pemesanan grup besar.</p>
                    </div>
                </div>

                <!-- Trusted Badge -->
                <div class="bg-primary-50 rounded-3xl p-8 border border-primary-100">
                    <div class="flex gap-4">
                        <div class="shrink-0 w-12 h-12 rounded-2xl bg-white flex items-center justify-center text-primary-600 shadow-sm">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/></svg>
                        </div>
                        <div>
                            <h4 class="font-bold text-primary-900 mb-1 text-sm">Pembayaran Aman</h4>
                            <p class="text-xs text-primary-700 opacity-80 leading-relaxed">Seluruh transaksi Anda dilindungi dengan sistem enkripsi terbaik dari Midtrans.</p>
                        </div>
                    </div>
                </div>
            </div>
        </aside>
    </div>
@endsection
