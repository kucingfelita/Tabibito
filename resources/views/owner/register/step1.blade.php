@extends('layouts.app')

@section('content')
<div class="container mx-auto p-4">
    <h1 class="text-2xl font-bold mb-4">Daftar sebagai Pemilik Wisata - Langkah 1</h1>
    <form action="{{ route('owner.register.step1.store') }}" method="POST">
        @csrf
        <div class="mb-4">
            <label for="username" class="block">Username</label>
            <input type="text" name="username" id="username" class="border p-2 w-full" required>
        </div>
        <div class="mb-4">
            <label for="email" class="block">Email</label>
            <input type="email" name="email" id="email" class="border p-2 w-full" required>
        </div>
        <div class="mb-4">
            <label for="password" class="block">Password</label>
            <input type="password" name="password" id="password" class="border p-2 w-full" required>
        </div>
        <div class="mb-4">
            <label for="password_confirmation" class="block">Konfirmasi Password</label>
            <input type="password" name="password_confirmation" id="password_confirmation" class="border p-2 w-full" required>
        </div>
        <button type="submit" class="bg-blue-500 text-white px-4 py-2">Lanjut</button>
    </form>
</div>
@endsection