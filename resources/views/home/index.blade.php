@extends('layouts.app')

@section('content')
    <!-- Hero Section - Premium Overhaul -->
    <section class="relative rounded-[2rem] md:rounded-[3rem] overflow-hidden bg-slate-900 min-h-[460px] md:min-h-[580px] flex items-center px-6 md:px-16 py-12 md:py-24 shadow-2xl shadow-slate-950/20">
        <!-- Background Image with Overlay -->
        <div class="absolute inset-0 z-0">
            <img src="{{ asset('assets/images/hero.png') }}" alt="Keindahan Alam dan Pariwisata Jawa Tengah - Tabibito Jateng" fetchpriority="high" loading="eager" class="w-full h-full object-cover opacity-50 scale-105 animate-[pulse_8s_infinite]">
            <div class="absolute inset-0 bg-gradient-to-tr from-slate-950 via-slate-900/60 to-transparent"></div>
        </div>

        <!-- Hero Content -->
        <div class="relative z-10 w-full max-w-4xl">
            <span class="inline-flex items-center gap-2 px-4 py-2 rounded-full bg-primary-500/10 backdrop-blur-md border border-primary-400/20 text-primary-200 text-xs font-bold uppercase tracking-widest mb-6">
                <i class="fa-solid fa-compass animate-spin" style="animation-duration: 6s;"></i> Jelajahi Jawa Tengah
            </span>
            <h1 class="text-4xl md:text-7xl font-extrabold text-white leading-[1.1] tracking-tight mb-6">
                Pintu Gerbang <br class="hidden md:inline">
                Petualangan <span class="text-transparent bg-clip-text bg-gradient-to-r from-primary-400 to-secondary-400">Jawa Tengah</span>
            </h1>
            <p class="text-base md:text-xl text-slate-200 mb-8 max-w-xl leading-relaxed opacity-90">Pesan tiket destinasi wisata impian Anda secara instan. Tanpa antre, aman, dan bergaransi resmi.</p>
        </div>
    </section>

    <!-- Traveloka Style Search Widget Widget (Overlapping) -->
    <section class="relative z-20 -mt-16 md:-mt-24 px-4 md:px-10 max-w-6xl mx-auto">
        <div class="bg-white rounded-3xl border border-slate-100 p-6 md:p-8 shadow-xl shadow-slate-200/60">
            <div class="flex items-center gap-3 border-b border-slate-100 pb-4 mb-6">
                <div class="w-8 h-8 rounded-lg bg-primary-50 text-primary-600 flex items-center justify-center">
                    <i class="fa-solid fa-magnifying-glass"></i>
                </div>
                <div>
                    <h3 class="font-bold text-slate-900 text-base">Cari Tiket Wisata Terbaik</h3>
                    <p class="text-[11px] text-slate-400">Temukan ribuan keajaiban di sekitarmu</p>
                </div>
            </div>

            <form action="{{ route('destinations.index') }}" method="GET" class="grid grid-cols-1 md:grid-cols-4 gap-6">
                <!-- Search Query Input -->
                <div class="space-y-2">
                    <label class="block text-xs font-bold text-slate-400 uppercase tracking-widest"><i class="fa-solid fa-map-location-dot text-primary-500 mr-1.5"></i> Nama Destinasi</label>
                    <div class="relative">
                        <input type="text" name="q" value="{{ request('q') }}" placeholder="Candi Borobudur, dll..." class="w-full bg-slate-50 border-none rounded-2xl px-4 py-3.5 text-sm font-semibold text-slate-700 placeholder-slate-400 focus:bg-white focus:ring-2 focus:ring-primary-500/20 transition-all">
                    </div>
                </div>

                <!-- Location Selector -->
                <div class="space-y-2">
                    <label class="block text-xs font-bold text-slate-400 uppercase tracking-widest"><i class="fa-solid fa-location-dot text-secondary-500 mr-1.5"></i> Kabupaten/Kota</label>
                    <div class="relative">
                        <select name="city" class="w-full bg-slate-50 border-none rounded-2xl px-4 py-3.5 text-sm font-semibold text-slate-700 focus:bg-white focus:ring-2 focus:ring-primary-500/20 transition-all cursor-pointer appearance-none">
                            <option value="">Semua Lokasi</option>
                            @foreach($cities as $city)
                                <option value="{{ $city }}" @selected(request('city') == $city)>{{ $city }}</option>
                            @endforeach
                        </select>
                        <div class="absolute right-4 top-1/2 -translate-y-1/2 pointer-events-none text-slate-400">
                            <i class="fa-solid fa-chevron-down text-xs"></i>
                        </div>
                    </div>
                </div>

                <!-- Category Selector -->
                <div class="space-y-2">
                    <label class="block text-xs font-bold text-slate-400 uppercase tracking-widest"><i class="fa-solid fa-tags text-primary-500 mr-1.5"></i> Kategori Wisata</label>
                    <div class="relative">
                        <select name="tags[]" class="w-full bg-slate-50 border-none rounded-2xl px-4 py-3.5 text-sm font-semibold text-slate-700 focus:bg-white focus:ring-2 focus:ring-primary-500/20 transition-all cursor-pointer appearance-none">
                            <option value="">Semua Kategori</option>
                            @foreach($tags as $tag)
                                <option value="{{ $tag->id }}">{{ $tag->name }}</option>
                            @endforeach
                        </select>
                        <div class="absolute right-4 top-1/2 -translate-y-1/2 pointer-events-none text-slate-400">
                            <i class="fa-solid fa-chevron-down text-xs"></i>
                        </div>
                    </div>
                </div>

                <!-- Submit Button -->
                <div class="flex items-end">
                    <button type="submit" class="w-full bg-gradient-to-r from-primary-600 to-primary-500 hover:from-primary-700 hover:to-primary-600 text-white font-bold py-3.5 rounded-2xl shadow-lg shadow-primary-500/20 hover:shadow-primary-500/30 transition-all transform hover:-translate-y-0.5 flex items-center justify-center gap-2">
                        <i class="fa-solid fa-magnifying-glass"></i> Cari Tiket
                    </button>
                </div>
            </form>
        </div>
    </section>

    <!-- Recommendations Section -->
    <section class="mt-20 md:mt-28 px-4">
        <div class="flex flex-col md:flex-row md:items-end justify-between mb-10 gap-4">
            <div>
                <span class="text-xs font-extrabold text-primary-600 uppercase tracking-widest mb-2 block">Pilihan Terbaik</span>
                <h2 class="text-3xl md:text-4xl font-black text-slate-900 mb-3 tracking-tight">Rekomendasi Terpopuler</h2>
                <p class="text-slate-400 text-sm">Destinasi dengan ulasan terbaik dan paling disukai oleh traveler.</p>
            </div>
            <a href="{{ route('destinations.index') }}" class="inline-flex items-center gap-2 text-primary-600 font-bold hover:text-primary-700 hover:gap-3 transition-all self-start md:self-auto text-sm group">
                Lihat Semua Wisata <i class="fa-solid fa-arrow-right transition-transform group-hover:translate-x-1"></i>
            </a>
        </div>

        <!-- Recommendations Grid -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8">
            @forelse($recommendations as $destination)
                <div class="group relative bg-white rounded-[2rem] border border-slate-100 p-3.5 shadow-sm hover:shadow-xl hover:-translate-y-2 transition-all duration-500">
                    <!-- Wishlist Button -->
                    @auth
                        @php $isWishlisted = $destination->wishlists->isNotEmpty(); @endphp
                        <button onclick="toggleWishlist(event, {{ $destination->id }})" 
                                id="wishlist-btn-{{ $destination->id }}"
                                class="absolute top-6 right-6 w-10 h-10 rounded-full flex items-center justify-center transition-all shadow-lg z-30 
                                {{ $isWishlisted ? 'bg-rose-500 text-white shadow-rose-200' : 'bg-white text-slate-400 hover:text-rose-500 shadow-slate-200' }}">
                            <svg class="w-5 h-5 {{ $isWishlisted ? 'fill-current' : 'fill-none' }}" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/>
                            </svg>
                        </button>
                    @endauth

                    <a href="{{ route('destinations.show', $destination) }}" class="block overflow-hidden rounded-[1.5rem] aspect-[4/3] relative z-10 bg-slate-100 isolate">
                        @php
                            $coverImg = $destination->coverImage ?? $destination->images->first();
                        @endphp
                        @if($coverImg?->image_path)
                            <img src="{{ asset('storage/' . $coverImg->image_path) }}" 
                                 alt="Destinasi Wisata {{ $destination->name }} di {{ $destination->city }} - Tabibito Jateng" 
                                 class="h-full w-full object-cover group-hover:scale-110 transition-transform duration-700 rounded-[1.5rem]">
                        @else
                            <div class="w-full h-full bg-slate-100 flex items-center justify-center rounded-[1.5rem]">
                                <svg class="w-12 h-12 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                            </div>
                        @endif
                        
                        <!-- Floating Category badges -->
                        <div class="absolute bottom-4 left-4 z-20 flex flex-wrap gap-1.5">
                            @foreach($destination->tags->take(2) as $tag)
                                <span class="px-2 py-0.5 rounded-md bg-slate-900/60 backdrop-blur-md border border-white/10 text-[9px] font-extrabold text-white uppercase tracking-wider">{{ $tag->name }}</span>
                            @endforeach
                        </div>
                        
                        <!-- Floating Rating -->
                        <div class="absolute top-4 left-4 z-20 px-3 py-1.5 rounded-xl bg-white/90 backdrop-blur-md border border-white/20 text-xs font-bold text-slate-900 shadow-sm flex items-center gap-1">
                            @if($destination->transactions_avg_rating > 0)
                                <i class="fa-solid fa-star text-amber-500"></i>
                                <span>{{ number_format($destination->transactions_avg_rating, 1) }}</span>
                            @else
                                <span class="text-primary-600 text-[10px] font-extrabold">NEW</span>
                            @endif
                        </div>
                    </a>
                    
                    <div class="p-4">
                        <div class="flex items-center gap-1.5 text-primary-600 mb-2">
                            <i class="fa-solid fa-location-dot text-xs"></i>
                            <span class="text-[10px] font-extrabold uppercase tracking-wider">{{ $destination->city }}</span>
                        </div>
                        <h3 class="text-xl font-bold text-slate-900 mb-4 truncate group-hover:text-primary-600 transition-colors tracking-tight">{{ $destination->name }}</h3>
                        
                        <div class="flex items-center justify-between pt-4 border-t border-slate-50">
                            <div>
                                <p class="text-[9px] text-slate-400 font-extrabold uppercase tracking-wider mb-0.5">Mulai dari</p>
                                <p class="text-lg font-black text-slate-950">
                                    <span class="text-xs font-medium text-slate-400">Rp</span> {{ number_format(optional($destination->tickets->sortBy('price')->first())->price ?? 0, 0, ',', '.') }}
                                </p>
                            </div>
                            <a href="{{ route('destinations.show', $destination) }}" class="w-10 h-10 flex items-center justify-center rounded-full bg-slate-50 text-slate-400 group-hover:bg-primary-600 group-hover:text-white transition-all shadow-sm hover:scale-105 duration-300">
                                <i class="fa-solid fa-arrow-right"></i>
                            </a>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-span-full rounded-3xl bg-slate-50 border-2 border-dashed border-slate-200 p-16 text-center">
                    <div class="w-16 h-16 rounded-full bg-slate-100 flex items-center justify-center mx-auto mb-4 text-slate-400">
                        <i class="fa-solid fa-map-location text-2xl"></i>
                    </div>
                    <p class="text-slate-400 font-semibold">Belum ada rekomendasi wisata saat ini.</p>
                </div>
            @endforelse
        </div>
    </section>

    <!-- Enhanced Steps Section -->
    <section class="mt-28 md:mt-36 bg-slate-950 rounded-[3rem] p-10 md:p-20 relative overflow-hidden">
        <!-- Decorative background -->
        <div class="absolute top-0 right-0 -mt-20 -mr-20 w-80 h-80 bg-primary-600 rounded-full blur-[120px] opacity-25"></div>
        <div class="absolute bottom-0 left-0 -mb-20 -ml-20 w-60 h-60 bg-secondary-500 rounded-full blur-[100px] opacity-15"></div>

        <div class="relative z-10">
            <div class="text-center max-w-2xl mx-auto mb-16 md:mb-20">
                <span class="text-xs font-extrabold text-primary-400 uppercase tracking-widest mb-3 block">Panduan Pemesanan</span>
                <h2 class="text-3xl md:text-5xl font-black text-white mb-6 tracking-tight">Pesan Tiket Cepat & Praktis</h2>
                <p class="text-slate-400 text-sm md:text-base leading-relaxed">Nikmati kemudahan eksplorasi Jawa Tengah dalam 3 langkah mudah.</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-10 md:gap-16">
                <!-- Step 1 -->
                <div class="group">
                    <div class="w-14 h-14 rounded-2xl bg-white/10 backdrop-blur-xl border border-white/20 flex items-center justify-center mb-6 group-hover:scale-110 group-hover:bg-primary-600 transition-all duration-300">
                        <i class="fa-solid fa-magnifying-glass text-primary-400 group-hover:text-white text-xl"></i>
                    </div>
                    <h3 class="text-xl font-bold text-white mb-3">1. Cari Wisata Jateng</h3>
                    <p class="text-slate-400 text-sm leading-relaxed">Temukan ratusan destinasi indah, candi megah, pantai eksotis, hingga pegunungan sejuk di Jawa Tengah.</p>
                </div>

                <!-- Step 2 -->
                <div class="group">
                    <div class="w-14 h-14 rounded-2xl bg-white/10 backdrop-blur-xl border border-white/20 flex items-center justify-center mb-6 group-hover:scale-110 group-hover:bg-primary-600 transition-all duration-300">
                        <i class="fa-solid fa-ticket text-primary-400 group-hover:text-white text-xl"></i>
                    </div>
                    <h3 class="text-xl font-bold text-white mb-3">2. Pilih Kategori Tiket</h3>
                    <p class="text-slate-400 text-sm leading-relaxed">Sesuaikan pilihan paket tiket dan kuota tanggal kunjungan Anda dengan mudah serta transparan.</p>
                </div>

                <!-- Step 3 -->
                <div class="group">
                    <div class="w-14 h-14 rounded-2xl bg-white/10 backdrop-blur-xl border border-white/20 flex items-center justify-center mb-6 group-hover:scale-110 group-hover:bg-primary-600 transition-all duration-300">
                        <i class="fa-solid fa-credit-card text-primary-400 group-hover:text-white text-xl"></i>
                    </div>
                    <h3 class="text-xl font-bold text-white mb-3">3. Bayar Secara Instan</h3>
                    <p class="text-slate-400 text-sm leading-relaxed">Metode pembayaran lengkap dan aman melalui Midtrans. E-Ticket langsung dikirim ke profil dan email Anda.</p>
                </div>
            </div>
        </div>
    </section>
@endsection
