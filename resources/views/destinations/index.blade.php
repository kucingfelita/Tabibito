@extends('layouts.app')

@section('content')
    <!-- Breadcrumbs -->
    <nav class="mb-8 flex items-center gap-2 text-sm">
        <a href="{{ route('home') }}" class="text-slate-400 hover:text-primary-600 transition-colors">Beranda</a>
        <svg class="w-4 h-4 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
        <span class="text-slate-900 font-bold">Eksplor Wisata</span>
    </nav>

    <div class="grid gap-10 lg:grid-cols-4">
        <!-- Filter Sidebar -->
        <aside class="lg:col-span-1">
            <div class="sticky top-24 bg-white rounded-3xl border border-slate-100 p-6 shadow-sm">
                <div class="flex items-center justify-between mb-8">
                    <h2 class="text-xl font-bold text-slate-900">Filter</h2>
                    <svg class="w-5 h-5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6V4m0 2a2 2 0 100 4m0-4a2 2 0 110 4m-6 8a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4m6 6v10m6-2a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4"/></svg>
                </div>

                <form class="space-y-8" action="{{ route('destinations.index') }}" method="GET">
                    <div>
                        <label class="block text-xs font-bold text-slate-400 uppercase tracking-widest mb-4">Pencarian</label>
                        <div class="relative">
                            <svg class="w-5 h-5 text-slate-400 absolute left-4 top-1/2 -translate-y-1/2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                            <input type="text" name="q" value="{{ request('q') }}" placeholder="Cari wisata..." class="w-full bg-slate-50 border-none rounded-2xl pl-11 pr-4 py-3.5 text-sm font-medium focus:ring-2 focus:ring-primary-500/20 transition-all">
                        </div>
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-400 uppercase tracking-widest mb-4">Rentang Harga</label>
                        <div class="grid grid-cols-2 gap-3">
                            <input type="number" name="min_price" value="{{ request('min_price') }}" placeholder="Min" class="w-full bg-slate-50 border-none rounded-xl px-4 py-3 text-xs font-bold focus:ring-2 focus:ring-primary-500/20 transition-all">
                            <input type="number" name="max_price" value="{{ request('max_price') }}" placeholder="Max" class="w-full bg-slate-50 border-none rounded-xl px-4 py-3 text-xs font-bold focus:ring-2 focus:ring-primary-500/20 transition-all">
                        </div>
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-400 uppercase tracking-widest mb-4">Lokasi</label>
                        <select name="city" class="w-full bg-slate-50 border-none rounded-2xl px-4 py-3.5 text-sm font-medium focus:ring-2 focus:ring-primary-500/20 transition-all">
                            <option value="">Semua Kota</option>
                            @foreach($cities as $city)
                                <option value="{{ $city }}" @selected(request('city') == $city)>{{ $city }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-400 uppercase tracking-widest mb-4">Kategori</label>
                        <div class="space-y-3 max-h-48 overflow-y-auto pr-2 custom-scrollbar">
                            @foreach($tags as $tag)
                                <label class="flex items-center group cursor-pointer">
                                    <div class="relative flex items-center">
                                        <input type="checkbox" name="tags[]" value="{{ $tag->id }}" 
                                               @checked(is_array(request('tags')) && in_array($tag->id, request('tags')))
                                               class="peer appearance-none w-5 h-5 border-2 border-slate-200 rounded-lg checked:bg-primary-600 checked:border-primary-600 transition-all">
                                        <svg class="w-3.5 h-3.5 text-white absolute left-0.5 top-0.5 opacity-0 peer-checked:opacity-100 transition-opacity pointer-events-none" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"/></svg>
                                    </div>
                                    <span class="ml-3 text-sm font-medium text-slate-600 group-hover:text-primary-600 transition-colors">{{ $tag->name }}</span>
                                </label>
                            @endforeach
                        </div>
                    </div>

                    @if(request('sort'))
                        <input type="hidden" name="sort" value="{{ request('sort') }}">
                    @endif

                    <button type="submit" class="w-full bg-primary-600 hover:bg-primary-700 text-white font-bold py-4 rounded-2xl shadow-lg shadow-primary-600/20 transition-all transform hover:-translate-y-0.5">
                        Terapkan Filter
                    </button>
                    
                    @if(request()->anyFilled(['q', 'tags', 'city', 'min_price', 'max_price']))
                        <a href="{{ route('destinations.index') }}" class="block text-center text-xs font-bold text-rose-500 hover:text-rose-600 uppercase tracking-widest mt-4">Reset Filter</a>
                    @endif
                </form>
            </div>
        </aside>
        
        <!-- Destinations Grid -->
        <div class="lg:col-span-3">
            <div class="flex flex-col sm:flex-row items-center justify-between mb-8 gap-4">
                <div>
                    <h1 class="text-2xl font-bold text-slate-900">Menampilkan Destinasi</h1>
                    <p class="text-sm text-slate-400 font-medium">{{ $destinations->total() }} wisata ditemukan</p>
                </div>
                
                <div class="flex items-center gap-4 w-full sm:w-auto">
                    <select onchange="window.location.href = this.value" class="w-full sm:w-48 bg-white border border-slate-100 rounded-2xl px-4 py-3 text-sm font-bold text-slate-700 shadow-sm focus:ring-2 focus:ring-primary-500/20 transition-all cursor-pointer">
                        <option value="{{ request()->fullUrlWithQuery(['sort' => 'latest']) }}" @selected(request('sort') == 'latest')>Terbaru</option>
                        <option value="{{ request()->fullUrlWithQuery(['sort' => 'rating_desc']) }}" @selected(request('sort') == 'rating_desc')>Rating Tertinggi</option>
                        <option value="{{ request()->fullUrlWithQuery(['sort' => 'price_asc']) }}" @selected(request('sort') == 'price_asc')>Harga Terendah</option>
                        <option value="{{ request()->fullUrlWithQuery(['sort' => 'price_desc']) }}" @selected(request('sort') == 'price_desc')>Harga Tertinggi</option>
                    </select>
                </div>
            </div>

            <div class="space-y-6" id="destinations-container">
                @include('destinations.partials.cards', ['destinations' => $destinations])
            </div>

            @if($destinations->hasPages())
                <div class="text-center mt-12">
                    <button id="load-more" 
                            class="inline-flex items-center gap-3 bg-white border border-slate-200 px-8 py-4 rounded-2xl font-bold text-slate-700 hover:bg-slate-50 hover:border-slate-300 transition-all group shadow-sm" 
                            data-page="2">
                        Muat Lebih Banyak
                        <svg class="w-5 h-5 text-slate-400 group-hover:translate-y-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                    </button>
                </div>
            @endif
        </div>
    </div>

    <script>
        document.getElementById('load-more')?.addEventListener('click', function() {
            const button = this;
            const page = button.getAttribute('data-page');
            button.textContent = 'Memuat...';
            button.disabled = true;

            const urlParams = new URLSearchParams(window.location.search);
            urlParams.set('page', page);

            fetch(`/destinations/load-more?${urlParams.toString()}`)
                .then(response => response.json())
                .then(data => {
                    document.getElementById('destinations-container').insertAdjacentHTML('beforeend', data.html);
                    button.textContent = 'Muat Lebih Banyak';
                    button.disabled = false;
                    if (data.has_more) {
                        button.setAttribute('data-page', parseInt(page) + 1);
                    } else {
                        button.style.display = 'none';
                    }
                })
                .catch(() => {
                    button.textContent = 'Muat Lebih Banyak';
                    button.disabled = false;
                });
        });
    </script>
@endsection
