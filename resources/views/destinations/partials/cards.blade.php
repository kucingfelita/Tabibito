@php use Illuminate\Support\Str; @endphp

@foreach($destinations as $destination)
    <a href="{{ route('destinations.show', $destination) }}" class="flex gap-4 rounded-3xl bg-white p-5 shadow-sm hover:-translate-y-1 transition">
        <div class="h-28 w-40 shrink-0 overflow-hidden rounded-3xl bg-slate-200">
            @if($destination->images->first()?->image_path)
                <img src="{{ asset('storage/' . $destination->images->first()->image_path) }}" alt="{{ $destination->name }}" class="h-full w-full object-cover">
            @endif
        </div>
        <div class="flex-1">
            <h3 class="text-lg font-semibold">{{ $destination->name }}</h3>
            <div class="mt-2 flex flex-wrap gap-2">
                @foreach($destination->tags as $tag)
                    <span class="rounded-full bg-emerald-100 px-2 py-1 text-xs text-emerald-700">{{ $tag->name }}</span>
                @endforeach
            </div>
            <p class="mt-3 line-clamp-2 text-sm text-slate-500">{{ Str::limit($destination->description, 100) }}</p>
        </div>
        <div class="text-right">
            <p class="text-sm text-slate-500">{{ $destination->city }}</p>
        </div>
    </a>
@endforeach