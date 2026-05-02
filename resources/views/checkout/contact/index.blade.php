@extends('layouts.app')

@section('content')
<!-- Responsive Contact Page -->
<div class="container mx-auto p-3 md:p-4">
    <h1 class="text-xl md:text-2xl font-bold mb-4">Kontak Kami</h1>

    @if(session('success'))
        <div class="bg-green-100 text-green-700 p-3 md:p-4 mb-4 rounded-lg">
            {{ session('success') }}
        </div>
    @endif

    <!-- Contact Form -->
    <div class="mb-6 md:mb-8">
        <h2 class="text-lg md:text-xl mb-3">Kirim Kritik/Saran</h2>
        <form action="{{ route('contact.store') }}" method="POST">
            @csrf
            <div class="mb-3 md:mb-4">
                <label for="name" class="block text-sm font-medium mb-1">Nama</label>
                <input type="text" name="name" id="name" class="border p-2.5 md:p-2 w-full rounded-lg" required>
            </div>
            <div class="mb-3 md:mb-4">
                <label for="email" class="block text-sm font-medium mb-1">Email</label>
                <input type="email" name="email" id="email" class="border p-2.5 md:p-2 w-full rounded-lg" required>
            </div>
            <div class="mb-3 md:mb-4">
                <label for="message" class="block text-sm font-medium mb-1">Pesan</label>
                <textarea name="message" id="message" class="border p-2.5 md:p-2 w-full rounded-lg" rows="4 md:5" required></textarea>
            </div>
            <button type="submit" class="bg-emerald-600 text-white px-4 py-2.5 md:py-2 rounded-lg text-sm font-medium w-full md:w-auto">Kirim</button>
        </form>
    </div>

    <!-- Owner Registration CTA -->
    <div class="rounded-xl md:rounded-2xl bg-white p-4 md:p-5 shadow-sm">
        <h2 class="text-lg md:text-xl mb-2">Pengajuan Tempat Wisata</h2>
        <p class="text-sm text-slate-600 mb-3">Jika Anda pemilik wisata, klik tombol di bawah untuk mengajukan tempat wisata Anda.</p>
        <a href="{{ route('owner.register.step1') }}" class="bg-emerald-600 text-white px-4 py-2.5 md:py-2 inline-block rounded-lg text-sm font-medium">Ajukan Tempat Wisata</a>
    </div>
</div>
@endsection
