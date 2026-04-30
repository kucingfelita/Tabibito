@extends('layouts.app')

@section('content')
    <div class="mx-auto max-w-md rounded-2xl bg-white p-6 shadow-sm">
        <h1 class="text-xl font-semibold">Sign Up</h1>
        <form method="POST" action="{{ route('register.store') }}" class="mt-4 space-y-4">
            @csrf
            <input name="name" value="{{ old('name') }}" placeholder="Nama" class="w-full rounded-lg border px-3 py-2">
            <input name="username" value="{{ old('username') }}" placeholder="Username" class="w-full rounded-lg border px-3 py-2">
            <input name="phone" value="{{ old('phone') }}" placeholder="No HP" class="w-full rounded-lg border px-3 py-2">
            <input type="password" name="password" placeholder="Password" class="w-full rounded-lg border px-3 py-2">
            <input type="password" name="password_confirmation" placeholder="Konfirmasi Password" class="w-full rounded-lg border px-3 py-2">
            <button class="w-full rounded-lg bg-emerald-600 px-4 py-2 font-medium text-white">Daftar</button>
        </form>
        <a href="{{ route('google.redirect') }}" class="mt-3 block w-full rounded-lg border px-4 py-2 text-center text-sm">Sign Up with Google</a>
        <p class="mt-3 text-sm text-slate-500">Sudah punya akun? <a href="{{ route('login') }}" class="text-emerald-600">Login disini</a></p>
    </div>
@endsection
