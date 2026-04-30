@extends('layouts.app')

@section('content')
    <nav class="mb-4 text-sm text-slate-500">Beranda > Wisata</nav>
    <div class="grid gap-6 lg:grid-cols-4">
        <aside class="rounded-xl bg-white p-4 shadow-sm lg:col-span-1">
            <h2 class="font-semibold">Filter</h2>
            <form class="mt-4 space-y-3">
                <select name="tag" class="w-full rounded-lg border px-3 py-2">
                    <option value="">Semua Tag</option>
                    @foreach($tags as $tag)
                        <option value="{{ $tag->id }}" @selected(request('tag') == $tag->id)>{{ $tag->name }}</option>
                    @endforeach
                </select>
                <select name="city" class="w-full rounded-lg border px-3 py-2">
                    <option value="">Semua Kota</option>
                    @foreach($cities as $city)
                        <option value="{{ $city }}" @selected(request('city') == $city)>{{ $city }}</option>
                    @endforeach
                </select>
                <button class="w-full rounded-lg bg-emerald-600 py-2 text-sm font-medium text-white">Terapkan</button>
            </form>
        </aside>
        <section class="space-y-4 lg:col-span-3" id="destinations-container">
            @include('destinations.partials.cards', ['destinations' => $destinations])
        </section>
        @if($destinations->hasPages())
            <div class="text-center mt-4">
                <button id="load-more" class="bg-emerald-600 text-white px-4 py-2 rounded-lg" data-page="2">Lebih Banyak</button>
            </div>
        @endif
    </div>

    <script>
        document.getElementById('load-more')?.addEventListener('click', function() {
            const button = this;
            const page = button.getAttribute('data-page');
            button.textContent = 'Memuat...';
            button.disabled = true;

            fetch(`/destinations/load-more?page=${page}&tag={{ request('tag') }}&city={{ request('city') }}`)
                .then(response => response.json())
                .then(data => {
                    document.getElementById('destinations-container').insertAdjacentHTML('beforeend', data.html);
                    button.textContent = 'Lebih Banyak';
                    button.disabled = false;
                    if (data.has_more) {
                        button.setAttribute('data-page', parseInt(page) + 1);
                    } else {
                        button.style.display = 'none';
                    }
                })
                .catch(() => {
                    button.textContent = 'Lebih Banyak';
                    button.disabled = false;
                });
        });
    </script>
@endsection
