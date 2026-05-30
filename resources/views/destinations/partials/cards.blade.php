@php use Illuminate\Support\Str; @endphp

@foreach($destinations as $destination)
    <div class="group relative bg-white rounded-3xl border border-slate-100/80 p-4 shadow-sm hover:shadow-xl hover:-translate-y-1 transition-all duration-300">
        <div class="flex flex-col sm:flex-row gap-6">
            <!-- Image Section -->
            <div class="relative shrink-0 w-full sm:w-56 h-48 sm:h-36 rounded-2xl bg-slate-100 isolate">
                <a href="{{ route('destinations.show', $destination) }}" class="block h-full w-full overflow-hidden rounded-2xl relative isolate">
                    <!-- Native Lazy Loading + Alpine.js Skeleton Loader -->
                    <div class="relative w-full h-full rounded-2xl overflow-hidden isolate" x-data="{ loaded: false, error: false }">
                        <div x-show="!loaded" class="absolute inset-0 shimmer bg-slate-200 z-10"></div>
                        @php
                            $coverImg = $destination->coverImage ?? $destination->images->first();
                        @endphp
                        @if($coverImg?->image_path)
                            <img x-show="!error"
                                 src="{{ asset('storage/' . $coverImg->image_path) }}" 
                                 alt="Destinasi Wisata {{ $destination->name }} di {{ $destination->city }} - Tabibito Jateng" 
                                 loading="lazy"
                                 x-on:load="loaded = true"
                                 x-on:error="loaded = true; error = true"
                                 class="h-full w-full object-cover group-hover:scale-110 transition-transform duration-700 rounded-2xl"
                                 :class="loaded && !error ? 'opacity-100' : 'opacity-0'">
                            <div x-show="error" class="w-full h-full bg-slate-100 flex flex-col items-center justify-center rounded-2xl text-slate-300">
                                <i class="fa-regular fa-image text-3xl"></i>
                                <span class="text-[9px] font-black uppercase tracking-wider text-slate-400 mt-2">Gambar Rusak</span>
                            </div>
                        @else
                            <div class="w-full h-full bg-slate-100 flex items-center justify-center rounded-2xl" x-init="loaded = true">
                                <i class="fa-regular fa-image text-slate-300 text-3xl"></i>
                            </div>
                        @endif
                    </div>
                    
                    <!-- City Overlay Badge -->
                    <div class="absolute top-3 left-3 z-20 px-2.5 py-1 rounded-lg bg-slate-900/60 backdrop-blur-md border border-white/10 text-[9px] font-extrabold text-white uppercase tracking-wider">
                        <i class="fa-solid fa-location-dot mr-1 text-secondary-400"></i>{{ $destination->city }}
                    </div>
                </a>

                <!-- Wishlist Button -->
                @auth
                    @php $isWishlisted = $destination->wishlists->isNotEmpty(); @endphp
                    <button onclick="toggleWishlist(event, {{ $destination->id }})" 
                            id="wishlist-btn-{{ $destination->id }}"
                            class="absolute top-3 right-3 w-9 h-9 rounded-full flex items-center justify-center transition-all shadow-md z-30 
                            {{ $isWishlisted ? 'bg-rose-500 text-white shadow-rose-200' : 'bg-white text-slate-400 hover:text-rose-500 shadow-slate-200' }}">
                        <svg class="w-4 h-4 {{ $isWishlisted ? 'fill-current' : 'fill-none' }}" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/>
                        </svg>
                    </button>
                @endauth
            </div>
            
            <!-- Content Section -->
            <div class="flex-1 flex flex-col justify-between min-w-0 py-1">
                <div>
                    <!-- Tag / Category badges -->
                    <div class="flex flex-wrap gap-1.5 mb-2.5">
                        @foreach($destination->tags->take(3) as $tag)
                            <span class="px-2.5 py-0.5 rounded-md bg-primary-50 text-[9px] font-extrabold text-primary-600 uppercase tracking-wider">{{ $tag->name }}</span>
                        @endforeach

                        @if($destination->transactions_avg_rating > 0)
                            <span class="ml-auto flex items-center gap-1 text-xs font-bold text-slate-700">
                                <i class="fa-solid fa-star text-amber-500 text-[10px]"></i> {{ number_format($destination->transactions_avg_rating, 1) }}
                            </span>
                        @else
                            <span class="ml-auto text-[9px] font-extrabold text-primary-500 uppercase tracking-wider self-center">Baru</span>
                        @endif
                    </div>

                    <a href="{{ route('destinations.show', $destination) }}" class="block">
                        <h2 class="text-lg font-bold text-slate-900 group-hover:text-primary-600 transition-colors truncate tracking-tight mb-2">{{ $destination->name }}</h2>
                    </a>
                    <p class="text-xs text-slate-500 line-clamp-2 leading-relaxed">{{ Str::limit($destination->description, 150) }}</p>
                </div>

                <div class="mt-4 pt-4 border-t border-slate-50 flex items-center justify-between">
                    <div>
                        <p class="text-[9px] text-slate-400 font-extrabold uppercase tracking-widest mb-0.5">Mulai dari</p>
                        <p class="text-lg font-black text-slate-950">
                            <span class="text-xs font-medium text-slate-400">Rp</span> {{ number_format(optional($destination->tickets->sortBy('price')->first())->price ?? 0, 0, ',', '.') }}
                        </p>
                    </div>
                    <a href="{{ route('destinations.show', $destination) }}" class="btn-premium bg-gradient-to-r from-primary-600 to-primary-500 hover:from-primary-700 hover:to-primary-600 text-white px-5 py-2 rounded-xl text-xs font-bold shadow-md shadow-primary-200">
                        Lihat Detail
                    </a>
                </div>
            </div>
        </div>
    </div>
@endforeach
