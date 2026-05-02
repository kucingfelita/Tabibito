@php use Illuminate\Support\Str; @endphp

@foreach($destinations as $destination)
    <a href="{{ route('destinations.show', $destination) }}" class="card-stack flex gap-3 md:gap-4 rounded-2xl md:rounded-3xl bg-white p-3 md:p-5 shadow-sm hover:-translate-y-1 transition">
        <!-- Responsive Image -->
        <div class="card-img h-24 md:h-28 w-32 md:w-40 shrink-0 overflow-hidden rounded-2xl md:rounded-3xl bg-slate-200">
            @if($destination->images->first()?->image_path)
                <img src="{{ asset('storage/' . $destination->images->first()->image_path) }}" alt="{{ $destination->name }}" class="h-full w-full object-cover">
            @endif
        </div>
        
        <!-- Content -->
        <div class="flex-1 min-w-0">
            <h3 class="text-base md:text-lg font-semibold truncate">{{ $destination->name }}</h3>
            <div class="mt-1 md:mt-2 flex flex-wrap gap-1 md:gap-2">
                @foreach($destination->tags as $tag)
                    <span class="rounded-full bg-emerald-100 px-1.5 md:px-2 py-0.5 text-xs text-emerald-700">{{ $tag->name }}</span>
                @endforeach
            </div>
            <p class="mt-2 md:mt-3 line-clamp-2 text-xs md:text-sm text-slate-500">{{ Str::limit($destination->description, 80) }}</p>
        </div>
        
        <!-- City Badge -->
        <div class="text-right shrink-0">
            <p class="text-xs md:text-sm text-slate-500">{{ $destination->city }}</p>
        </div>
    </a>
@endforeach
