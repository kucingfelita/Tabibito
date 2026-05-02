@extends('layouts.app')

@section('content')
<div class="container mx-auto p-4">
    <h1 class="text-2xl font-bold mb-4">Daftar sebagai Pemilik Wisata - Langkah 2</h1>
    <form action="{{ route('owner.register.step2.store') }}" method="POST">
        @csrf
        <div class="mb-4">
            <label for="nama_tempat" class="block">Nama Tempat Wisata</label>
            <input type="text" name="nama_tempat" id="nama_tempat" class="border p-2 w-full" required>
        </div>
        <div class="mb-4">
            <label for="nama_pemilik" class="block">Nama Pemilik</label>
            <input type="text" name="nama_pemilik" id="nama_pemilik" class="border p-2 w-full" required>
        </div>
        <div class="mb-4">
            <label class="block">Tag Wisata</label>
            <div class="grid gap-2 sm:grid-cols-2 lg:grid-cols-3">
                @foreach($tags as $tag)
                    <label class="inline-flex items-center gap-2 rounded-lg border px-3 py-2 transition hover:bg-slate-50">
                        <input type="checkbox" name="tag_ids[]" value="{{ $tag->id }}" class="form-checkbox" {{ in_array($tag->id, old('tag_ids', [])) ? 'checked' : '' }}>
                        <span>{{ $tag->name }}</span>
                    </label>
                @endforeach
            </div>
            <p class="mt-1 text-sm text-slate-500">Centang lebih dari satu tag yang sesuai.</p>
        </div>
        <div class="mb-4">
            <label for="custom_tags" class="block">Tag Baru</label>
            <input type="text" name="custom_tags" id="custom_tags" class="border p-2 w-full" placeholder="Pisahkan dengan koma, misal: alam, keluarga, edukasi" value="{{ old('custom_tags') }}">
            <p class="mt-1 text-sm text-slate-500">Masukkan tag baru jika tag yang diinginkan tidak tersedia.</p>
        </div>
        <div class="mb-4">
            <label for="description" class="block">Deskripsi Tempat</label>
            <textarea name="description" id="description" rows="4" class="border p-2 w-full" required></textarea>
        </div>
        <div class="mb-4">
            <label for="domisili" class="block">Alamat</label>
            <input type="text" name="domisili" id="domisili" class="border p-2 w-full" required>
        </div>
        <div class="mb-4">
            <label for="city" class="block">Kota</label>
            <input type="text" name="city" id="city" class="border p-2 w-full" required>
        </div>
        <div class="mb-4 grid gap-4 md:grid-cols-2">
            <div>
                <label for="open_time" class="block">Jam Buka</label>
                <input type="time" name="open_time" id="open_time" class="border p-2 w-full" required>
            </div>
            <div>
                <label for="close_time" class="block">Jam Tutup</label>
                <input type="time" name="close_time" id="close_time" class="border p-2 w-full" required>
            </div>
        </div>
        <button type="submit" class="bg-blue-500 text-white px-4 py-2">Ajukan</button>
    </form>
</div>
@endsection