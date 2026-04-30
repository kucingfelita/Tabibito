@extends('layouts.app')

@section('content')
    <div class="mx-auto max-w-xl rounded-xl bg-white p-6 shadow-sm">
        <h1 class="text-xl font-semibold">Profile</h1>
        <form method="POST" action="{{ route('profile.update') }}" class="mt-4 space-y-3">
            @csrf
            @method('PUT')
            <input name="name" value="{{ auth()->user()->name }}" class="w-full rounded-lg border px-3 py-2">
            <input name="phone" value="{{ auth()->user()->phone }}" placeholder="No HP" class="w-full rounded-lg border px-3 py-2">
            <input type="password" name="password" placeholder="Password baru (opsional)" class="w-full rounded-lg border px-3 py-2">
            <input type="password" name="password_confirmation" placeholder="Konfirmasi password baru" class="w-full rounded-lg border px-3 py-2">
            <button class="rounded-lg bg-emerald-600 px-4 py-2 text-white">Simpan</button>
        </form>
    </div>
@endsection
