@extends('layouts.app')

@section('content')
    <!-- Breadcrumbs -->
    <nav class="mb-8 flex items-center gap-2.5 text-xs font-semibold px-4 md:px-0">
        <a href="{{ route('home') }}" class="text-slate-400 hover:text-primary-600 transition-colors flex items-center gap-1.5"><i class="fa-solid fa-house"></i> Beranda</a>
        <i class="fa-solid fa-chevron-right text-slate-300 text-[10px]"></i>
        <span class="text-slate-900 font-bold">Eksplor Wisata Jawa Tengah</span>
    </nav>

    <div class="grid gap-8 lg:gap-10 lg:grid-cols-4 min-w-0" x-data="{ filterOpen: false }">
        <!-- Filter Sidebar -->
        <aside :class="filterOpen ? 'fixed inset-0 z-50 flex justify-end lg:static lg:block lg:col-span-1' : 'hidden lg:block lg:col-span-1'" class="transition-all duration-300">
            <!-- Backdrop for mobile -->
            <div x-show="filterOpen" @click="filterOpen = false" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" class="fixed inset-0 bg-slate-950/60 backdrop-blur-sm lg:hidden z-40"></div>
            
            <!-- Filter Card -->
            <div :class="filterOpen ? 'fixed right-0 top-0 bottom-0 w-full max-w-md bg-white p-6 shadow-2xl z-50 flex flex-col h-full overflow-y-auto' : 'sticky top-24 bg-white rounded-[2rem] border border-slate-100 p-6 shadow-sm'" 
                 x-show="filterOpen || window.innerWidth >= 1024"
                 x-transition:enter="transition ease-out duration-300 transform"
                 x-transition:enter-start="translate-x-full"
                 x-transition:enter-end="translate-x-0"
                 x-transition:leave="transition ease-in duration-200 transform"
                 x-transition:leave-start="translate-x-0"
                 x-transition:leave-end="translate-x-full">
                 
                <div class="flex items-center justify-between mb-8 pb-4 border-b border-slate-100">
                    <div class="text-lg font-extrabold text-slate-900 flex items-center gap-2"><i class="fa-solid fa-sliders text-primary-500"></i> Filter Wisata</div>
                    <button type="button" @click="filterOpen = false" class="lg:hidden p-2 text-slate-400 hover:text-slate-600 hover:bg-slate-50 rounded-xl transition-colors">
                        <i class="fa-solid fa-xmark text-lg"></i>
                    </button>
                </div>

                <form class="space-y-6" action="{{ route('destinations.index') }}" method="GET">
                    <!-- Text Search -->
                    <div class="space-y-2">
                        <label class="block text-[10px] font-extrabold text-slate-400 uppercase tracking-wider">Pencarian Kata Kunci</label>
                        <div class="relative">
                            <i class="fa-solid fa-magnifying-glass text-slate-400 absolute left-4 top-1/2 -translate-y-1/2"></i>
                            <input type="text" name="q" value="{{ request('q') }}" placeholder="Cari destinasi..." class="w-full bg-slate-50 border-none rounded-xl pl-11 pr-4 py-3 text-sm font-semibold text-slate-700 placeholder-slate-400 focus:bg-white focus:ring-2 focus:ring-primary-500/20 transition-all">
                        </div>
                    </div>

                    <!-- Price Filter -->
                    <div class="space-y-2">
                        <label class="block text-[10px] font-extrabold text-slate-400 uppercase tracking-wider">Rentang Budget (Rp)</label>
                        <div class="grid grid-cols-2 gap-3">
                            <div class="relative">
                                <input type="number" name="min_price" value="{{ request('min_price') }}" placeholder="Min" class="w-full bg-slate-50 border-none rounded-xl px-3 py-2.5 text-xs font-bold text-slate-700 placeholder-slate-400 focus:bg-white focus:ring-2 focus:ring-primary-500/20 transition-all">
                            </div>
                            <div class="relative">
                                <input type="number" name="max_price" value="{{ request('max_price') }}" placeholder="Max" class="w-full bg-slate-50 border-none rounded-xl px-3 py-2.5 text-xs font-bold text-slate-700 placeholder-slate-400 focus:bg-white focus:ring-2 focus:ring-primary-500/20 transition-all">
                            </div>
                        </div>
                    </div>

                    <!-- City Location -->
                    <div class="space-y-2">
                        <label class="block text-[10px] font-extrabold text-slate-400 uppercase tracking-wider">Pilih Wilayah</label>
                        <div class="relative">
                            <select name="city" class="w-full bg-slate-50 border-none rounded-xl px-4 py-3 text-sm font-semibold text-slate-700 focus:bg-white focus:ring-2 focus:ring-primary-500/20 transition-all cursor-pointer appearance-none">
                                <option value="">Semua Kabupaten/Kota</option>
                                @foreach($cities as $city)
                                    <option value="{{ $city }}" @selected(request('city') == $city)>{{ $city }}</option>
                                @endforeach
                            </select>
                            <div class="absolute right-4 top-1/2 -translate-y-1/2 pointer-events-none text-slate-400">
                                <i class="fa-solid fa-chevron-down text-xs"></i>
                            </div>
                        </div>
                    </div>

                    <!-- Categories / Tags -->
                    <div class="space-y-3">
                        <label class="block text-[10px] font-extrabold text-slate-400 uppercase tracking-wider">Kategori Pilihan</label>
                        <div class="space-y-2.5 max-h-48 overflow-y-auto pr-2 custom-scrollbar">
                            @foreach($tags as $tag)
                                <label class="flex items-center group cursor-pointer">
                                    <div class="relative flex items-center">
                                        <input type="checkbox" name="tags[]" value="{{ $tag->id }}" 
                                               @checked(is_array(request('tags')) && in_array($tag->id, request('tags')))
                                               class="peer appearance-none w-5 h-5 border-2 border-slate-200 rounded-lg checked:bg-primary-600 checked:border-primary-600 transition-all cursor-pointer">
                                        <svg class="w-3.5 h-3.5 text-white absolute left-0.5 top-0.5 opacity-0 peer-checked:opacity-100 transition-opacity pointer-events-none" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"/></svg>
                                    </div>
                                    <span class="ml-3 text-xs font-semibold text-slate-600 group-hover:text-primary-600 transition-colors">{{ $tag->name }}</span>
                                </label>
                            @endforeach
                        </div>
                    </div>

                    @if(request('sort'))
                        <input type="hidden" name="sort" value="{{ request('sort') }}">
                    @endif

                    <div class="pt-4 border-t border-slate-50 space-y-3">
                        <button type="submit" class="w-full bg-gradient-to-r from-primary-600 to-primary-500 hover:from-primary-700 hover:to-primary-600 text-white font-bold py-3.5 rounded-2xl shadow-lg shadow-primary-500/20 hover:shadow-primary-500/30 transition-all transform hover:-translate-y-0.5 flex items-center justify-center gap-2">
                            <i class="fa-solid fa-filter text-xs"></i> Terapkan Filter
                        </button>
                        
                        @if(request()->anyFilled(['q', 'tags', 'city', 'min_price', 'max_price']))
                            <a href="{{ route('destinations.index') }}" class="block text-center text-[10px] font-extrabold text-rose-500 hover:text-rose-600 uppercase tracking-widest py-2">Reset Semua Filter</a>
                        @endif
                    </div>
                </form>
            </div>
        </aside>
        
        <!-- Destinations Grid -->
        <div class="lg:col-span-3">
            <div class="flex flex-col sm:flex-row items-center justify-between mb-8 gap-4">
                <div class="flex items-center justify-between w-full sm:w-auto">
                    <div>
                        <h1 class="text-xl font-bold text-slate-900 tracking-tight">Menampilkan Destinasi Wisata</h1>
                        <p class="text-xs text-slate-400 font-semibold">{{ $destinations->total() }} wisata ditemukan di Jawa Tengah</p>
                    </div>
                </div>
                
                <div class="flex items-center gap-3 w-full sm:w-auto">
                    <!-- Mobile Filter Trigger Button -->
                    <button type="button" @click="filterOpen = true" class="lg:hidden flex items-center justify-center gap-2 w-full sm:w-auto bg-white border border-slate-200/80 rounded-2xl px-5 py-3 text-sm font-bold text-slate-700 shadow-sm hover:bg-slate-50 transition-all">
                        <i class="fa-solid fa-sliders text-primary-500"></i>
                        Filter
                    </button>

                    <div class="relative w-full sm:w-48">
                        <select onchange="window.location.href = this.value" class="w-full bg-white border border-slate-200/80 rounded-2xl px-4 py-3 text-xs font-bold text-slate-700 shadow-sm focus:ring-2 focus:ring-primary-500/20 transition-all cursor-pointer appearance-none">
                            <option value="{{ request()->fullUrlWithQuery(['sort' => 'latest']) }}" @selected(request('sort') == 'latest')>Terbaru</option>
                            <option value="{{ request()->fullUrlWithQuery(['sort' => 'rating_desc']) }}" @selected(request('sort') == 'rating_desc')>Rating Tertinggi</option>
                            <option value="{{ request()->fullUrlWithQuery(['sort' => 'price_asc']) }}" @selected(request('sort') == 'price_asc')>Harga Terendah</option>
                            <option value="{{ request()->fullUrlWithQuery(['sort' => 'price_desc']) }}" @selected(request('sort') == 'price_desc')>Harga Tertinggi</option>
                        </select>
                        <div class="absolute right-4 top-1/2 -translate-y-1/2 pointer-events-none text-slate-400">
                            <i class="fa-solid fa-chevron-down text-[10px]"></i>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Destinations Card Wrapper -->
            <div class="grid grid-cols-1 gap-6" id="destinations-container">
                @include('destinations.partials.cards', ['destinations' => $destinations])
            </div>

            @if($destinations->hasPages())
                <div class="text-center mt-12">
                    <button id="load-more" 
                            class="inline-flex items-center gap-3 bg-white border border-slate-200 px-8 py-4 rounded-2xl font-bold text-slate-700 hover:bg-slate-50 hover:border-slate-300 transition-all group shadow-sm" 
                            data-page="2">
                        Muat Lebih Banyak Wisata
                        <i class="fa-solid fa-chevron-down text-slate-400 group-hover:translate-y-0.5 transition-transform"></i>
                    </button>
                </div>
            @endif
        </div>
    </div>

    <script>
        document.getElementById('load-more')?.addEventListener('click', function() {
            const button = this;
            const page = button.getAttribute('data-page');
            button.textContent = 'Memuat Destinasi...';
            button.disabled = true;

            const urlParams = new URLSearchParams(window.location.search);
            urlParams.set('page', page);

            fetch(`/destinations/load-more?${urlParams.toString()}`)
                .then(response => response.json())
                .then(data => {
                    document.getElementById('destinations-container').insertAdjacentHTML('beforeend', data.html);
                    button.textContent = 'Muat Lebih Banyak Wisata';
                    button.disabled = false;
                    if (data.has_more) {
                        button.setAttribute('data-page', parseInt(page) + 1);
                    } else {
                        button.style.display = 'none';
                    }
                })
                .catch(() => {
                    button.textContent = 'Muat Lebih Banyak Wisata';
                    button.disabled = false;
                });
        });
    </script>
@endsection
