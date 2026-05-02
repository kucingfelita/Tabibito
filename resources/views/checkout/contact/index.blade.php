@extends('layouts.app')

@section('content')
<div class="container mx-auto p-4">
    <h1 class="text-2xl font-bold mb-4">Kontak Kami</h1>

    @if(session('success'))
        <div class="bg-green-100 text-green-700 p-4 mb-4 rounded">
            {{ session('success') }}
        </div>
    @endif

    <div class="mb-8">
        <h2 class="text-xl mb-2">Kirim Kritik/Saran</h2>
        <form action="{{ route('contact.store') }}" method="POST">
            @csrf
            <div class="mb-4">
                <label for="name" class="block">Nama</label>
                <input type="text" name="name" id="name" class="border p-2 w-full" required>
            </div>
            <div class="mb-4">
                <label for="email" class="block">Email</label>
                <input type="email" name="email" id="email" class="border p-2 w-full" required>
            </div>
            <div class="mb-4">
                <label for="message" class="block">Pesan</label>
                <textarea name="message" id="message" class="border p-2 w-full" rows="5" required></textarea>
            </div>
            <button type="submit" class="bg-blue-500 text-white px-4 py-2">Kirim</button>
        </form>
    </div>

    <div>
        <h2 class="text-xl mb-2">Pengajuan Tempat Wisata</h2>
        <p>Jika Anda pemilik wisata, klik tombol di bawah untuk mengajukan tempat wisata Anda.</p>
        <a href="{{ route('owner.register.step1') }}" class="bg-green-500 text-white px-4 py-2 inline-block mt-2">Ajukan Tempat Wisata</a>
    </div>
</div>
@endsection