@extends('layouts.app')

@section('content')
    @include('owner.partials.nav')
    <h1 class="text-xl font-semibold">Manajemen Destinasi</h1>
    @if($destinations->isEmpty())
        <form method="POST" action="{{ route('owner.destinations.store') }}" enctype="multipart/form-data" class="mt-4 grid gap-3 rounded-xl bg-white p-4 shadow-sm md:grid-cols-2">
            @csrf
            <input name="name" placeholder="Nama wisata" class="rounded-lg border px-3 py-2" value="{{ old('name') }}">
            <select name="city" class="rounded-lg border px-3 py-2">
                <option value="">Pilih kota/kabupaten Jawa Tengah</option>
                @foreach($cities as $city)
                    <option value="{{ $city }}" @selected(old('city') === $city)>{{ $city }}</option>
                @endforeach
            </select>
            <input name="address" placeholder="Alamat" class="rounded-lg border px-3 py-2 md:col-span-2" value="{{ old('address') }}">
            <textarea name="description" placeholder="Deskripsi" class="rounded-lg border px-3 py-2 md:col-span-2">{{ old('description') }}</textarea>
            <div class="md:col-span-2 rounded-lg border bg-slate-50 p-3">
                <p class="mb-2 font-medium text-sm text-slate-700">Pilih tag</p>
                <div class="grid gap-2 sm:grid-cols-2 lg:grid-cols-3">
                    @foreach($tags as $tag)
                        <label class="inline-flex items-center gap-2 rounded-md border px-3 py-2 text-sm text-slate-700">
                            <input type="checkbox" name="tag_ids[]" value="{{ $tag->id }}" @checked(in_array($tag->id, old('tag_ids', [])))>
                            <span>{{ $tag->name }}</span>
                        </label>
                    @endforeach
                </div>
            </div>
            <input type="text" name="custom_tags" placeholder="Tag baru, pisahkan koma" class="rounded-lg border px-3 py-2 md:col-span-2" value="{{ old('custom_tags') }}">
            <input name="map_link" placeholder="Google map link" class="rounded-lg border px-3 py-2 md:col-span-2" value="{{ old('map_link') }}">
            <input type="time" name="open_time" class="rounded-lg border px-3 py-2" value="{{ old('open_time') }}">
            <input type="time" name="close_time" class="rounded-lg border px-3 py-2" value="{{ old('close_time') }}">
            <input type="file" name="image" class="rounded-lg border px-3 py-2 md:col-span-2">
            <button class="rounded-lg bg-emerald-600 px-4 py-2 text-white md:col-span-2">Tambah Destinasi</button>
        </form>
    @else
        <div class="mt-4 rounded-xl bg-white p-4 shadow-sm">
            <p class="text-sm text-slate-600">Anda sudah memiliki satu destinasi. Untuk menambahkan destinasi baru, hapus destinasi yang ada terlebih dahulu.</p>
        </div>
    @endif

    <div class="mt-6 space-y-4">
        @foreach($destinations as $destination)
            <div class="rounded-xl bg-white p-4 shadow-sm">
                <form method="POST" action="{{ route('owner.destinations.update', $destination) }}" enctype="multipart/form-data" class="grid gap-3 md:grid-cols-2">
                    @csrf
                    @method('PUT')
                    <input name="name" value="{{ $destination->name }}" class="rounded-lg border px-3 py-2">
                    <select name="city" class="rounded-lg border px-3 py-2">
                        @foreach($cities as $city)
                            <option value="{{ $city }}" @selected($destination->city === $city)>{{ $city }}</option>
                        @endforeach
                    </select>
                    <input name="address" value="{{ $destination->address }}" class="rounded-lg border px-3 py-2 md:col-span-2">
                    <textarea name="description" class="rounded-lg border px-3 py-2 md:col-span-2">{{ $destination->description }}</textarea>
                    <div class="md:col-span-2 rounded-lg border bg-slate-50 p-3">
                        <p class="mb-2 font-medium text-sm text-slate-700">Pilih tag</p>
                        <div class="grid gap-2 sm:grid-cols-2 lg:grid-cols-3">
                            @foreach($tags as $tag)
                                <label class="inline-flex items-center gap-2 rounded-md border px-3 py-2 text-sm text-slate-700">
                                    <input type="checkbox" name="tag_ids[]" value="{{ $tag->id }}" @checked(in_array($tag->id, old('tag_ids', $destination->tags->pluck('id')->toArray())))>
                                    <span>{{ $tag->name }}</span>
                                </label>
                            @endforeach
                        </div>
                    </div>
                    <input type="text" name="custom_tags" placeholder="Tag baru, pisahkan koma" class="rounded-lg border px-3 py-2 md:col-span-2" value="{{ old('custom_tags') }}">
                    <input name="map_link" value="{{ $destination->map_link }}" class="rounded-lg border px-3 py-2 md:col-span-2">
                    <input type="time" name="open_time" value="{{ \Illuminate\Support\Str::of($destination->open_time)->substr(0, 5) }}" class="rounded-lg border px-3 py-2">
                    <input type="time" name="close_time" value="{{ \Illuminate\Support\Str::of($destination->close_time)->substr(0, 5) }}" class="rounded-lg border px-3 py-2">
                    <input type="file" name="image" class="rounded-lg border px-3 py-2 md:col-span-2">
                    <button class="rounded-lg bg-cyan-600 px-4 py-2 text-white md:col-span-2">Simpan</button>
                </form>
                <div class="mt-2">
                    <form method="POST" action="{{ route('owner.destinations.destroy', $destination) }}">
                        @csrf
                        @method('DELETE')
                        <button class="rounded-lg bg-rose-600 px-4 py-2 text-white">Hapus</button>
                    </form>
                </div>
                <p class="mt-2 text-xs text-slate-500">Status: {{ strtoupper($destination->status) }}</p>
            </div>
        @endforeach
    </div>
    <div class="mt-4">{{ $destinations->links() }}</div>
@endsection
