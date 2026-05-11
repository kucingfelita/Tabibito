@php use Illuminate\Support\Str; @endphp

@foreach($destinations as $destination)
    <div class="group relative bg-white rounded-3xl border border-slate-100 p-4 shadow-sm hover:shadow-xl hover:-translate-y-1 transition-all duration-300">
        <div class="flex flex-col md:flex-row gap-6">
            <!-- Image Section -->
            <a href="{{ route('destinations.show', $destination) }}" class="relative shrink-0 w-full md:w-64 h-48 md:h-40 overflow-hidden rounded-2xl">
                @if($destination->images->first()?->image_path)
                    <img src="{{ asset('storage/' . $destination->images->first()->image_path) }}" alt="{{ $destination->name }}" class="h-full w-full object-cover group-hover:scale-110 transition-transform duration-500">
                @else
                    <div class="w-full h-full bg-slate-100 flex items-center justify-center">
                        <svg class="w-10 h-10 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                    </div>
                @endif
                <div class="absolute top-3 left-3 px-2 py-1 rounded-lg bg-white/90 backdrop-blur-sm text-[10px] font-bold text-primary-600 uppercase tracking-wider shadow-sm">
                    {{ $destination->city }}
                </div>
                @if($destination->transactions_avg_rating > 0)
                <div class="absolute top-3 right-3 px-2 py-1 rounded-lg bg-white/90 backdrop-blur-sm text-[10px] font-bold text-amber-600 uppercase tracking-wider shadow-sm flex items-center gap-1">
                    <svg class="w-3 h-3 text-amber-500" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                    {{ number_format($destination->transactions_avg_rating, 1) }}
                </div>
                @endif
            </a>
            
            <!-- Content Section -->
            <div class="flex-1 flex flex-col justify-between min-w-0 py-1">
                <div>
                    <div class="flex flex-wrap gap-2 mb-3">
                        @foreach($destination->tags as $tag)
                            <span class="px-2.5 py-1 rounded-lg bg-primary-50 text-[10px] font-bold text-primary-600 uppercase tracking-wider">{{ $tag->name }}</span>
                        @endforeach
                    </div>
                    <a href="{{ route('destinations.show', $destination) }}" class="block">
                        <h3 class="text-xl font-bold text-slate-900 group-hover:text-primary-600 transition-colors truncate mb-2">{{ $destination->name }}</h3>
                    </a>
                    <p class="text-sm text-slate-500 line-clamp-2 leading-relaxed">{{ Str::limit($destination->description, 120) }}</p>
                </div>

                <div class="mt-4 flex items-center justify-between">
                    <div>
                        <p class="text-[10px] text-slate-400 font-bold uppercase tracking-widest mb-0.5">Mulai dari</p>
                        <p class="text-lg font-black text-slate-900">
                            <span class="text-xs font-medium text-slate-500">Rp</span> {{ number_format(optional($destination->tickets->sortBy('price')->first())->price ?? 0, 0, ',', '.') }}
                        </p>
                    </div>
                    <a href="{{ route('destinations.show', $destination) }}" class="btn-premium bg-primary-600 hover:bg-primary-700 text-white px-6 py-2.5 rounded-xl text-sm font-bold shadow-md shadow-primary-200 transition-all">
                        Lihat Detail
                    </a>
                </div>
            </div>
        </div>
    </div>
@endforeach
