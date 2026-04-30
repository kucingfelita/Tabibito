@extends('layouts.app')

@section('content')
    <div class="mx-auto max-w-md rounded-2xl bg-white p-6 shadow-sm">
        <h1 class="text-xl font-semibold">Login</h1>
        <form method="POST" action="{{ route('login.store') }}" class="mt-4 space-y-4">
            @csrf
            <input name="login" value="{{ old('login') }}" placeholder="Username atau Email" class="w-full rounded-lg border px-3 py-2">
            <input type="password" name="password" placeholder="Password" class="w-full rounded-lg border px-3 py-2">
            <button class="w-full rounded-lg bg-emerald-600 px-4 py-2 font-medium text-white">Login</button>
        </form>
        <a href="{{ route('google.redirect') }}" class="mt-3 block w-full rounded-lg border px-4 py-2 text-center text-sm">Login with Google</a>
    </div>
@endsection
