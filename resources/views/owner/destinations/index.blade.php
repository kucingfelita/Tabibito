@extends('layouts.app')

@section('content')
    <h1 class="text-xl font-semibold">Manajemen Destinasi</h1>
    <form method="POST" action="{{ route('owner.destinations.store') }}" enctype="multipart/form-data" class="mt-4 grid gap-3 rounded-xl bg-white p-4 shadow-sm md:grid-cols-2">
        @csrf
        <input name="name" placeholder="Nama wisata" class="rounded-lg border px-3 py-2">
        <input name="city" placeholder="Kota" class="rounded-lg border px-3 py-2">
        <input name="address" placeholder="Alamat" class="rounded-lg border px-3 py-2 md:col-span-2">
        <textarea name="description" placeholder="Deskripsi" class="rounded-lg border px-3 py-2 md:col-span-2"></textarea>
        <input name="map_link" placeholder="Google map link" class="rounded-lg border px-3 py-2 md:col-span-2">
        <input type="time" name="open_time" class="rounded-lg border px-3 py-2">
        <input type="time" name="close_time" class="rounded-lg border px-3 py-2">
        <input type="file" name="image" class="rounded-lg border px-3 py-2 md:col-span-2">
        <button class="rounded-lg bg-emerald-600 px-4 py-2 text-white md:col-span-2">Tambah Destinasi</button>
    </form>

    <div class="mt-6 space-y-4">
        @foreach($destinations as $destination)
            <div class="rounded-xl bg-white p-4 shadow-sm">
                <form method="POST" action="{{ route('owner.destinations.update', $destination) }}" enctype="multipart/form-data" class="grid gap-3 md:grid-cols-2">
                    @csrf
                    @method('PUT')
                    <input name="name" value="{{ $destination->name }}" class="rounded-lg border px-3 py-2">
                    <input name="city" value="{{ $destination->city }}" class="rounded-lg border px-3 py-2">
                    <input name="address" value="{{ $destination->address }}" class="rounded-lg border px-3 py-2 md:col-span-2">
                    <textarea name="description" class="rounded-lg border px-3 py-2 md:col-span-2">{{ $destination->description }}</textarea>
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
