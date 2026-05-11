
@extends('layouts.app')

@section('content')
    <!-- Hero Section - Premium Overhaul -->
    <section class="relative rounded-[2rem] md:rounded-[3rem] overflow-hidden bg-slate-900 min-h-[400px] md:min-h-[500px] flex items-center px-6 md:px-16 py-20">
        <!-- Background Image with Overlay -->
        <div class="absolute inset-0 z-0">
            <img src="{{ asset('assets/images/hero.png') }}" alt="Hero Background" class="w-full h-full object-cover opacity-60">
            <div class="absolute inset-0 bg-gradient-to-t from-slate-900 via-slate-900/40 to-transparent"></div>
        </div>

        <!-- Hero Content -->
        <div class="relative z-10 w-full max-w-2xl">
            <span class="inline-block px-4 py-1.5 rounded-full bg-primary-500/20 backdrop-blur-md border border-primary-400/30 text-primary-200 text-xs font-bold uppercase tracking-widest mb-6">Explore Central Java</span>
            <h1 class="text-4xl md:text-6xl font-bold text-white leading-tight mb-6">
                Petualangan Seru <br>
                <span class="text-primary-400">Dimulai dari Sini.</span>
            </h1>
            <p class="text-lg text-slate-200 mb-10 leading-relaxed opacity-90">Jelajahi keindahan Jawa Tengah dengan kemudahan pemesanan tiket online dan konfirmasi instan.</p>
            
            <!-- Floating Search Bar -->
            <div class="relative max-w-xl group">
                <form action="{{ route('destinations.index') }}" class="flex items-center gap-2 p-2 bg-white/10 backdrop-blur-2xl border border-white/20 rounded-2xl md:rounded-3xl shadow-2xl transition-all focus-within:bg-white focus-within:border-white focus-within:ring-4 focus-within:ring-primary-500/20">
                    <div class="flex-1 flex items-center gap-3 px-4">
                        <svg class="w-6 h-6 text-primary-400 group-focus-within:text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                        <input type="text" name="q" value="{{ request('q') }}" placeholder="Cari nama tempat wisata..." class="w-full bg-transparent border-0 focus:ring-0 text-white placeholder-slate-400 group-focus-within:text-slate-900 group-focus-within:placeholder-slate-500 font-medium py-3">
                    </div>
                    <button class="bg-primary-600 hover:bg-primary-700 text-white px-8 py-3.5 rounded-xl md:rounded-2xl font-bold transition-all shadow-lg shadow-primary-600/30 whitespace-nowrap">Cari Wisata</button>
                </form>
            </div>
        </div>
    </section>

    <!-- Recommendations Section -->
    <section class="mt-20 md:mt-32">
        <div class="flex items-end justify-between mb-10">
            <div>
                <h2 class="text-3xl md:text-4xl font-bold text-slate-900 mb-3">Rekomendasi Populer</h2>
                <p class="text-slate-500">Destinasi pilihan yang paling sering dikunjungi bulan ini.</p>
            </div>
            <a href="{{ route('destinations.index') }}" class="hidden md:flex items-center gap-2 text-primary-600 font-bold hover:gap-3 transition-all">
                Lihat Semua <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
            </a>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8">
            @forelse($recommendations as $destination)
                <div class="group relative bg-white rounded-[2rem] border border-slate-100 p-3 shadow-sm hover:shadow-xl hover:-translate-y-2 transition-all duration-500">
                    <a href="{{ route('destinations.show', $destination) }}" class="block overflow-hidden rounded-[1.5rem] aspect-[4/3] relative">
                        @if($destination->images->first()?->image_path)
                            <img src="{{ asset('storage/' . $destination->images->first()->image_path) }}" alt="{{ $destination->name }}" class="h-full w-full object-cover group-hover:scale-110 transition-transform duration-700">
                        @else
                            <div class="w-full h-full bg-slate-100 flex items-center justify-center">
                                <svg class="w-12 h-12 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                            </div>
                        @endif
                        <div class="absolute top-4 right-4 px-3 py-1.5 rounded-xl bg-white/80 backdrop-blur-md border border-white/20 text-xs font-bold text-slate-900 shadow-sm flex items-center gap-1">
                            @if($destination->transactions_avg_rating > 0)
                                <svg class="w-3.5 h-3.5 text-amber-500" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                                <span>{{ number_format($destination->transactions_avg_rating, 1) }}</span>
                            @else
                                <span class="text-slate-500">Baru</span>
                            @endif
                        </div>
                    </a>
                    
                    <div class="p-4">
                        <div class="flex items-center gap-1.5 text-primary-600 mb-2">
                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M5.05 4.05a7 7 0 119.9 9.9L10 18.9l-4.95-4.95a7 7 0 010-9.9zM10 11a2 2 0 100-4 2 2 0 000 4z" clip-rule="evenodd"/></svg>
                            <span class="text-xs font-bold uppercase tracking-wider">{{ $destination->city }}</span>
                        </div>
                        <h3 class="text-xl font-bold text-slate-900 mb-4 truncate group-hover:text-primary-600 transition-colors">{{ $destination->name }}</h3>
                        
                        <div class="flex items-center justify-between pt-4 border-t border-slate-50">
                            <div>
                                <p class="text-[10px] text-slate-400 font-bold uppercase tracking-wider mb-0.5">Mulai dari</p>
                                <p class="text-lg font-black text-slate-900">
                                    <span class="text-xs font-medium text-slate-500">Rp</span> {{ number_format(optional($destination->tickets->sortBy('price')->first())->price ?? 0, 0, ',', '.') }}
                                </p>
                            </div>
                            <a href="{{ route('destinations.show', $destination) }}" class="w-10 h-10 flex items-center justify-center rounded-full bg-slate-50 text-slate-400 group-hover:bg-primary-600 group-hover:text-white transition-all shadow-sm">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
                            </a>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-span-full rounded-3xl bg-slate-50 border-2 border-dashed border-slate-200 p-12 text-center">
                    <p class="text-slate-400 font-medium">Belum ada rekomendasi wisata saat ini.</p>
                </div>
            @endforelse
        </div>
    </section>

    <!-- Enhanced Steps Section -->
    <section class="mt-24 md:mt-40 bg-primary-950 rounded-[3rem] p-10 md:p-20 relative overflow-hidden">
        <!-- Decorative background -->
        <div class="absolute top-0 right-0 -mt-20 -mr-20 w-80 h-80 bg-primary-600 rounded-full blur-[120px] opacity-20"></div>
        <div class="absolute bottom-0 left-0 -mb-20 -ml-20 w-60 h-60 bg-secondary-600 rounded-full blur-[100px] opacity-10"></div>

        <div class="relative z-10">
            <div class="text-center max-w-3xl mx-auto mb-16 md:mb-20">
                <h2 class="text-3xl md:text-5xl font-black text-white mb-6">Pesan Tiket <br class="md:hidden"> Cuma 3 Langkah</h2>
                <p class="text-primary-100 text-lg opacity-80">Liburan nggak pakai ribet. Booking tiket kapan saja, di mana saja.</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-10 md:gap-16">
                <!-- Step 1 -->
                <div class="group">
                    <div class="w-16 h-16 rounded-2xl bg-white/10 backdrop-blur-xl border border-white/20 flex items-center justify-center mb-8 group-hover:scale-110 group-hover:bg-primary-600 transition-all duration-500">
                        <svg class="w-8 h-8 text-primary-400 group-hover:text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                    </div>
                    <h3 class="text-2xl font-bold text-white mb-4">1. Cari Wisata</h3>
                    <p class="text-primary-100 opacity-70 leading-relaxed">Temukan ratusan destinasi menarik di Jawa Tengah lewat fitur pencarian kami.</p>
                </div>

                <!-- Step 2 -->
                <div class="group">
                    <div class="w-16 h-16 rounded-2xl bg-white/10 backdrop-blur-xl border border-white/20 flex items-center justify-center mb-8 group-hover:scale-110 group-hover:bg-primary-600 transition-all duration-500">
                        <svg class="w-8 h-8 text-primary-400 group-hover:text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 5v2m0 4v2m0 4v2M5 5a2 2 0 00-2 2v3a2 2 0 110 4v3a2 2 0 002 2h14a2 2 0 002-2v-3a2 2 0 110-4V7a2 2 0 00-2-2H5z"/></svg>
                    </div>
                    <h3 class="text-2xl font-bold text-white mb-4">2. Pilih Tiket</h3>
                    <p class="text-primary-100 opacity-70 leading-relaxed">Pilih paket tiket yang sesuai dengan kebutuhan dan budget liburan Anda.</p>
                </div>

                <!-- Step 3 -->
                <div class="group">
                    <div class="w-16 h-16 rounded-2xl bg-white/10 backdrop-blur-xl border border-white/20 flex items-center justify-center mb-8 group-hover:scale-110 group-hover:bg-primary-600 transition-all duration-500">
                        <svg class="w-8 h-8 text-primary-400 group-hover:text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    </div>
                    <h3 class="text-2xl font-bold text-white mb-4">3. Bayar Online</h3>
                    <p class="text-primary-100 opacity-70 leading-relaxed">Lakukan pembayaran aman lewat Midtrans dengan berbagai metode pilihan.</p>
                </div>
            </div>
        </div>
    </section>
@endsection
