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
            <label for="tag_ids" class="block">Tag Wisata</label>
            <select name="tag_ids[]" id="tag_ids" multiple class="border p-2 w-full" required>
                @foreach($tags as $tag)
                    <option value="{{ $tag->id }}">{{ $tag->name }}</option>
                @endforeach
            </select>
        </div>
        <div class="mb-4">
            <label for="domisili" class="block">Domisili</label>
            <input type="text" name="domisili" id="domisili" class="border p-2 w-full" required>
        </div>
        <button type="submit" class="bg-blue-500 text-white px-4 py-2">Ajukan</button>
    </form>
</div>
@endsection