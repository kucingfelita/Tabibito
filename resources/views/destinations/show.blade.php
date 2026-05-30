@extends('layouts.app')

@section('content')
    @push('styles')
    <style>
        /* Safety CSS: Prevent overflow even if JS fails */
        .hero-swiper { overflow: hidden !important; position: relative !important; }
        .swiper-wrapper { display: flex !important; }
        .swiper-slide { flex-shrink: 0 !important; width: 100% !important; height: 100% !important; }
        
        .swiper-button-next, .swiper-button-prev { color: #fff; background: rgba(0,0,0,0.4); width: 40px; height: 40px; border-radius: 12px; backdrop-filter: blur(8px); border: 1px solid rgba(255,255,255,0.1); }
        .swiper-button-next:after, .swiper-button-prev:after { font-size: 14px; font-weight: bold; }
        .swiper-pagination-bullet-active { background: #0ea8e9 !important; width: 24px !important; border-radius: 9999px !important; }
        .swiper-pagination-bullet { transition: all 0.3s; }
    </style>
    @endpush

    <!-- Breadcrumbs -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-8 px-4 md:px-0">
        <nav class="flex items-center gap-2.5 text-xs font-semibold">
            <a href="{{ route('home') }}" class="text-slate-400 hover:text-primary-600 transition-colors flex items-center gap-1"><i class="fa-solid fa-house"></i> Beranda</a>
            <i class="fa-solid fa-chevron-right text-slate-300 text-[10px]"></i>
            <a href="{{ route('destinations.index') }}" class="text-slate-400 hover:text-primary-600 transition-colors">Eksplor Wisata</a>
            <i class="fa-solid fa-chevron-right text-slate-300 text-[10px]"></i>
            <span class="text-slate-900 font-bold truncate max-w-[150px] md:max-w-none">{{ $destination->name }}</span>
        </nav>

        <a href="https://wa.me/?text={{ urlencode('Cek tempat wisata keren ini di Tabibito Jateng: ' . $destination->name . ' - ' . request()->url()) }}" target="_blank" class="inline-flex items-center justify-center gap-2 px-5 py-2.5 rounded-2xl bg-emerald-50 hover:bg-emerald-100 text-emerald-600 transition-all font-bold text-xs shadow-sm shadow-emerald-100 border border-emerald-200/50 hover:scale-[1.02]">
            <i class="fa-brands fa-whatsapp text-base"></i> Bagikan Ke WhatsApp
        </a>
    </div>

    <div class="grid gap-10 lg:grid-cols-[1.8fr_1fr] px-4 md:px-0">
        <!-- Main Content -->
        <div class="space-y-10">
            <!-- Hero Section / Slider -->
            <div class="bg-white rounded-[2.5rem] overflow-hidden shadow-sm border border-slate-100/80">
                <div class="relative">
                    <div class="swiper hero-swiper h-80 md:h-[480px]">
                        <div class="swiper-wrapper">
                            @php
                                $allImages = collect();
                                if ($destination->coverImage) {
                                    $allImages->push($destination->coverImage);
                                }
                                if ($destination->slideImages && $destination->slideImages->isNotEmpty()) {
                                    $allImages = $allImages->concat($destination->slideImages);
                                } elseif ($destination->images && $destination->images->isNotEmpty() && $allImages->isEmpty()) {
                                    // Fallback for legacy images
                                    $allImages = $destination->images;
                                }
                            @endphp
                            @forelse($allImages as $image)
                                <div class="swiper-slide bg-slate-100 relative group" x-data="{ loaded: false, error: false }">
                                     <div x-show="!loaded" class="absolute inset-0 shimmer bg-slate-200 z-10"></div>
                                     <img x-show="!error"
                                          src="{{ asset('storage/' . $image->image_path) }}" 
                                          alt="Foto Keindahan {{ $destination->name }} di {{ $destination->city }} - Tabibito Jateng" 
                                          class="h-full w-full object-cover"
                                          x-on:load="loaded = true"
                                          x-on:error="loaded = true; error = true"
                                          loading="lazy">
                                     <div x-show="error" class="w-full h-full bg-slate-100 flex flex-col items-center justify-center text-slate-300">
                                         <i class="fa-regular fa-image text-4xl"></i>
                                         <span class="text-[10px] font-black uppercase tracking-wider text-slate-400 mt-2">Gambar Tidak Ditemukan</span>
                                     </div>
                                 </div>
                            @empty
                                <div class="swiper-slide">
                                    <div class="w-full h-full bg-slate-50 flex items-center justify-center">
                                        <i class="fa-regular fa-image text-slate-200 text-6xl"></i>
                                    </div>
                                </div>
                            @endforelse
                        </div>
                        @if($allImages->count() > 1)
                            <div class="swiper-pagination !bottom-8"></div>
                            <div class="swiper-button-next !right-6"></div>
                            <div class="swiper-button-prev !left-6"></div>
                        @endif
                    </div>
                    
                    <!-- Gradient Overlay -->
                    <div class="absolute inset-0 bg-gradient-to-t from-slate-950/90 via-slate-950/20 to-transparent pointer-events-none z-[5]"></div>
                    <div class="absolute bottom-8 left-8 right-8 z-10 pointer-events-none">
                        <div class="flex flex-wrap gap-2 mb-3">
                            @foreach($destination->tags as $tag)
                                <span class="px-3 py-1 rounded-lg bg-white/20 backdrop-blur-md border border-white/20 text-[10px] font-extrabold text-white uppercase tracking-wider">{{ $tag->name }}</span>
                            @endforeach
                        </div>
                        <h1 class="text-3xl md:text-5xl font-black text-white leading-tight tracking-tight">{{ $destination->name }}</h1>
                    </div>
                </div>
                
                <div class="p-8 md:p-10">
                    <div class="flex flex-wrap items-center gap-6 mb-8 text-xs text-slate-500 font-bold uppercase tracking-wider">
                        <div class="flex items-center gap-2">
                            <div class="w-9 h-9 rounded-xl bg-primary-50 flex items-center justify-center text-primary-600 shadow-sm shadow-primary-100">
                                <i class="fa-solid fa-location-dot"></i>
                            </div>
                            <span>{{ $destination->city }}</span>
                        </div>
                        <div class="flex items-center gap-2">
                            <div class="w-9 h-9 rounded-xl bg-amber-50 flex items-center justify-center text-amber-600 shadow-sm shadow-amber-100">
                                <i class="fa-solid fa-clock"></i>
                            </div>
                            <span>{{ $destination->open_time }} - {{ $destination->close_time }} WIB</span>
                        </div>
                    </div>

                    <div class="prose prose-slate max-w-none">
                        @if($destination->transactions_avg_rating > 0)
                        <div class="flex items-center gap-2.5 mb-6 bg-gradient-to-r from-amber-50 to-amber-100/50 inline-flex px-4 py-2.5 rounded-2xl border border-amber-200/40 shadow-sm">
                            <div class="flex items-center text-amber-500">
                                <i class="fa-solid fa-star text-base"></i>
                            </div>
                            <span class="text-lg font-black text-amber-800">{{ number_format($destination->transactions_avg_rating, 1) }}</span>
                            <span class="text-xs text-amber-600 font-semibold uppercase tracking-wider">/ 5.0 Rating Pengunjung</span>
                        </div>
                        @endif
                        <h2 class="text-lg font-bold text-slate-900 tracking-tight mb-3">Tentang Destinasi</h2>
                        <p class="text-slate-600 leading-relaxed text-sm md:text-base font-medium">{{ $destination->description }}</p>
                    </div>

                    <div class="mt-10 pt-10 border-t border-slate-100">
                        <h2 class="text-lg font-bold text-slate-900 tracking-tight mb-3">Lokasi Alamat</h2>
                        <p class="text-slate-500 text-xs md:text-sm mb-6 flex items-start gap-2 font-medium">
                            <i class="fa-solid fa-map-location-dot text-primary-500 shrink-0 mt-0.5 text-base"></i>
                            <span>{{ $destination->address }}, {{ $destination->city }}</span>
                        </p>
                        <a href="{{ $destination->map_link }}" target="_blank" class="inline-flex items-center gap-3 bg-white border border-slate-200 hover:border-primary-500/30 px-6 py-3 rounded-2xl font-bold text-xs text-slate-700 hover:text-primary-600 transition-all hover:shadow-lg shadow-slate-100 group">
                            Petunjuk Arah Google Maps
                            <i class="fa-solid fa-arrow-right group-hover:translate-x-1 transition-transform"></i>
                        </a>
                    </div>
                </div>
            </div>

            <!-- Tickets Section -->
            <div>
                <h2 class="text-xl font-bold text-slate-900 tracking-tight mb-6 flex items-center gap-2"><i class="fa-solid fa-ticket text-primary-500"></i> Pilihan Tiket & Kategori</h2>
                <div class="grid gap-6">
                    @foreach($destination->tickets as $index => $ticket)
                        <div class="ticket-card {{ $index >= 5 ? 'hidden' : '' }} bg-white rounded-[2rem] border border-slate-100/80 p-6 md:p-8 shadow-sm hover:shadow-xl hover:-translate-y-1 transition-all duration-300">
                            <div class="flex flex-col md:flex-row md:items-center justify-between gap-6">
                                <div class="flex-1">
                                    <div class="flex items-center gap-3 mb-4">
                                        <div class="w-10 h-10 rounded-xl bg-primary-50 flex items-center justify-center text-primary-600 font-black">
                                            <i class="fa-solid fa-ticket"></i>
                                        </div>
                                        <h3 class="text-lg font-bold text-slate-900 tracking-tight">{{ $ticket->name }}</h3>
                                    </div>
                                    <p class="text-slate-500 text-xs md:text-sm leading-relaxed mb-4 font-semibold">{{ $ticket->benefit }}</p>
                                    <div class="flex flex-wrap gap-3">
                                        <span class="px-3 py-1 rounded-lg bg-slate-50 text-[10px] font-bold text-slate-500 flex items-center gap-1.5"><i class="fa-solid fa-users"></i> Kuota Kuota: {{ $ticket->daily_quota }} / hari</span>
                                        <span class="px-3 py-1 rounded-lg bg-emerald-50 text-[10px] font-bold text-emerald-600 flex items-center gap-1.5"><i class="fa-solid fa-circle-check"></i> Instan Konfirmasi</span>
                                    </div>
                                </div>
                                <div class="shrink-0 flex md:flex-col items-center md:items-end justify-between md:justify-center gap-4 pt-6 md:pt-0 border-t md:border-t-0 md:border-l border-slate-100 md:pl-8">
                                    <div class="text-left md:text-right">
                                        <p class="text-[9px] text-slate-400 font-extrabold uppercase tracking-widest mb-1">Harga Tiket</p>
                                        <p class="text-2xl font-black text-primary-600">
                                            <span class="text-xs font-medium">Rp</span> {{ number_format($ticket->price, 0, ',', '.') }}
                                        </p>
                                    </div>
                                    <a href="{{ route('tickets.show', $ticket) }}" class="btn-premium bg-gradient-to-r from-primary-600 to-primary-500 hover:from-primary-700 hover:to-primary-600 text-white px-6 py-3.5 rounded-xl text-xs font-bold shadow-md shadow-primary-200 transition-all">
                                        Pesan Sekarang
                                    </a>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                @if($destination->tickets->count() > 5)
                    <div class="mt-8 text-center">
                        <button onclick="showAllTickets(this)" class="inline-flex items-center gap-3 bg-white border border-slate-200 px-8 py-4 rounded-2xl font-bold text-slate-700 hover:bg-slate-50 hover:border-slate-300 transition-all group shadow-sm">
                            Lihat {{ $destination->tickets->count() - 5 }} Tiket Lainnya
                            <i class="fa-solid fa-chevron-down text-slate-400 group-hover:translate-y-0.5 transition-transform"></i>
                        </button>
                    </div>

                    <script>
                        function showAllTickets(btn) {
                            document.querySelectorAll('.ticket-card.hidden').forEach(el => el.classList.remove('hidden'));
                            btn.parentElement.remove();
                        }
                    </script>
                @endif
            </div>

            <!-- Reviews Section -->
            <div class="mt-12 bg-white rounded-[2.5rem] border border-slate-100 p-8 md:p-10 shadow-sm">
                <div class="flex items-center justify-between mb-8">
                    <h2 class="text-xl font-bold text-slate-900 tracking-tight">Ulasan Pengunjung</h2>
                    <span class="px-4 py-1.5 rounded-full bg-slate-50 border border-slate-100 text-xs font-bold text-slate-500 flex items-center gap-1.5">
                        <i class="fa-solid fa-star text-amber-400"></i>
                        {{ $reviews->total() }} Ulasan
                    </span>
                </div>

                @if($reviews->isEmpty())
                    <div class="text-center py-12">
                        <div class="w-16 h-16 rounded-full bg-slate-50 border border-slate-100 flex items-center justify-center mx-auto mb-4 text-slate-300">
                            <i class="fa-regular fa-comment-dots text-xl"></i>
                        </div>
                        <p class="text-sm font-semibold text-slate-800">Belum ada ulasan</p>
                        <p class="text-xs text-slate-400 mt-1">Jadilah yang pertama memberikan ulasan setelah melakukan kunjungan wisata!</p>
                    </div>
                @else
                    <div id="reviews-container" class="divide-y divide-slate-100">
                        @include('destinations.partials.reviews', ['reviews' => $reviews])
                    </div>
                    
                    @if($reviews->hasMorePages())
                        <div class="mt-6 text-center" id="load-more-reviews-wrapper">
                            <button id="load-more-reviews-btn" 
                                    data-next-page="2" 
                                    data-url="{{ route('destinations.reviews.loadMore', $destination) }}" 
                                    class="inline-flex items-center gap-2 rounded-2xl border border-slate-200 bg-white hover:bg-slate-50 px-6 py-3 text-sm font-semibold text-slate-700 transition-all shadow-sm">
                                <span>Muat Lebih Banyak Ulasan</span>
                                <i class="fa-solid fa-chevron-down text-slate-400"></i>
                            </button>
                        </div>
                    @endif
                @endif
            </div>
        </div>

        <!-- Sidebar Info -->
        <aside class="space-y-8">
            <div class="sticky top-24 space-y-8">
                <!-- Owner Info -->
                <div class="bg-white rounded-3xl border border-slate-100 p-8 shadow-sm">
                    <h2 class="text-lg font-bold text-slate-900 tracking-tight mb-6">Informasi Kontak Pengelola</h2>
                    <div class="flex items-center gap-4 mb-8">
                        <div class="w-12 h-12 rounded-2xl bg-gradient-to-tr from-primary-600 to-primary-500 flex items-center justify-center font-bold text-white uppercase shadow-sm">
                            {{ substr($destination->owner?->name ?? 'A', 0, 1) }}
                        </div>
                        <div>
                            <p class="text-[9px] text-slate-400 font-extrabold uppercase tracking-widest">Dikelola oleh</p>
                            <p class="font-bold text-slate-900">{{ $destination->owner?->name ?? 'Admin Tabibito' }}</p>
                        </div>
                    </div>
                    
                    <div class="space-y-4">
                        <div class="p-4 rounded-2xl bg-slate-50 border border-slate-100">
                            <p class="text-[9px] text-slate-400 font-extrabold uppercase tracking-widest mb-1">Email Resmi</p>
                            <p class="text-xs md:text-sm font-bold text-slate-700 truncate"><i class="fa-regular fa-envelope mr-1.5 text-primary-500"></i>{{ $destination->owner?->email ?? 'info@tabibito.id' }}</p>
                        </div>
                        <p class="text-xs text-slate-400 leading-relaxed italic">Silakan hubungi pengelola untuk informasi fasilitas khusus, kunjungan kelompok besar, atau kemitraan event.</p>
                    </div>
                </div>

                <!-- Trusted Badge -->
                <div class="bg-primary-950 rounded-3xl p-8 text-white relative overflow-hidden shadow-xl shadow-primary-950/20">
                    <div class="absolute right-0 bottom-0 translate-x-4 translate-y-4 opacity-5 text-9xl">
                        <i class="fa-solid fa-shield-halved"></i>
                    </div>
                    <div class="relative z-10 flex gap-4">
                        <div class="shrink-0 w-12 h-12 rounded-2xl bg-white/10 backdrop-blur-md border border-white/10 flex items-center justify-center text-primary-400">
                            <i class="fa-solid fa-shield-halved text-xl"></i>
                        </div>
                        <div>
                            <h4 class="font-bold mb-1 text-sm tracking-tight">Transaksi Aman & Terlindungi</h4>
                            <p class="text-xs text-slate-300 leading-relaxed">Seluruh proses pemesanan tiket Anda terenkripsi penuh menggunakan payment gateway Midtrans yang aman dan tepercaya.</p>
                        </div>
                    </div>
                </div>
            </div>
        </aside>
    </div>

    <!-- Schema Markup JSON-LD untuk SEO Rich Snippets -->
    <script type="application/ld+json">
    {
      "@@context": "https://schema.org",
      "@@type": "TouristAttraction",
      "name": "{{ $destination->name }}",
      "description": "{{ \Illuminate\Support\Str::limit(strip_tags($destination->description), 160) }}",
      "image": "{{ ($destination->coverImage ?? $destination->images->first())?->image_path ? asset('storage/' . ($destination->coverImage ?? $destination->images->first())->image_path) : asset('assets/images/hero.png') }}",
      "address": {
        "@@type": "PostalAddress",
        "streetAddress": "{{ $destination->address }}",
        "addressLocality": "{{ $destination->city }}",
        "addressRegion": "Jawa Tengah",
        "addressCountry": "ID"
      },
      "telephone": "{{ $destination->owner?->phone ?? 'info@tabibito.id' }}",
      @if($destination->transactions_avg_rating > 0)
      "aggregateRating": {
        "@@type": "AggregateRating",
        "ratingValue": "{{ number_format($destination->transactions_avg_rating, 1) }}",
        "bestRating": "5",
        "worstRating": "1",
        "reviewCount": "{{ max($reviews->total(), 1) }}"
      },
      @endif
      "offers": {
        "@@type": "AggregateOffer",
        "priceCurrency": "IDR",
        "lowPrice": "{{ optional($destination->tickets->sortBy('price')->first())->price ?? 0 }}",
        "highPrice": "{{ optional($destination->tickets->sortByDesc('price')->first())->price ?? 0 }}",
        "offerCount": "{{ $destination->tickets->count() }}"
      }
    }
    </script>

    @push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            new Swiper('.hero-swiper', {
                loop: true,
                pagination: { el: '.swiper-pagination', clickable: true },
                navigation: { nextEl: '.swiper-button-next', prevEl: '.swiper-button-prev' },
                autoplay: { delay: 5000, disableOnInteraction: false },
            });

            // Load More Reviews
            const loadMoreBtn = document.getElementById('load-more-reviews-btn');
            const wrapper = document.getElementById('load-more-reviews-wrapper');
            const container = document.getElementById('reviews-container');

            if (loadMoreBtn) {
                loadMoreBtn.addEventListener('click', function() {
                    const page = this.getAttribute('data-next-page');
                    const url = this.getAttribute('data-url') + '?page=' + page;

                    // Disable button and show loading state
                    this.disabled = true;
                    this.classList.add('opacity-50');
                    const textSpan = this.querySelector('span');
                    const originalText = textSpan.innerText;
                    textSpan.innerText = 'Memuat...';

                    fetch(url)
                        .then(res => res.json())
                        .then(data => {
                            // Append new reviews HTML
                            container.insertAdjacentHTML('beforeend', data.html);

                            if (data.has_more) {
                                this.setAttribute('data-next-page', parseInt(page) + 1);
                                this.disabled = false;
                                this.classList.remove('opacity-50');
                                textSpan.innerText = originalText;
                            } else {
                                // Hide wrapper if no more reviews
                                wrapper.remove();
                            }
                        })
                        .catch(err => {
                            console.error(err);
                            this.disabled = false;
                            this.classList.remove('opacity-50');
                            textSpan.innerText = originalText;
                        });
                });
            }
        });
    </script>
    @endpush
@endsection
