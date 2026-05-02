<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $title ?? 'Tiket Wisata Marketplace' }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body class="bg-slate-50 text-slate-800">
    <nav class="bg-white shadow-sm">
        <div class="mx-auto flex max-w-7xl items-center justify-between px-4 py-4">
            <a href="{{ route('home') }}" class="text-lg font-bold text-emerald-600">Tabibito Jateng</a>
            <div class="flex items-center gap-3">
                <a href="{{ route('home') }}" class="text-sm text-slate-600 hover:text-emerald-600">Beranda</a>
                <a href="{{ route('destinations.index') }}" class="text-sm text-slate-600 hover:text-emerald-600">Wisata</a>
                <a href="{{ route('contact') }}" class="text-sm text-slate-600 hover:text-emerald-600">Kontak</a>
                @guest
                    <a href="{{ route('register') }}" class="rounded-lg border border-emerald-500 px-4 py-2 text-sm font-medium text-emerald-600">Sign Up</a>
                    <a href="{{ route('login') }}" class="rounded-lg bg-emerald-600 px-4 py-2 text-sm font-medium text-white">Login</a>
                @endguest
                @auth
                    <div x-data="{open:false}" class="relative">
                        <button @click="open=!open" class="flex h-10 w-10 items-center justify-center rounded-full bg-emerald-100 font-bold text-emerald-700">
                            {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                        </button>
                        <div x-show="open" @click.outside="open=false" class="absolute right-0 z-10 mt-2 w-48 rounded-xl border bg-white p-2 shadow-lg">
                            <a href="{{ route('profile') }}" class="block rounded-md px-3 py-2 text-sm hover:bg-slate-100">Profile</a>
                            <a href="{{ route('history.index') }}" class="block rounded-md px-3 py-2 text-sm hover:bg-slate-100">Riwayat</a>
                            @if(in_array(auth()->user()->tipe_user, [1,3], true))
                                <a href="{{ auth()->user()->tipe_user === 1 ? route('admin.dashboard') : route('owner.dashboard') }}" class="block rounded-md px-3 py-2 text-sm hover:bg-slate-100">Dashboard</a>
                            @endif
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button class="mt-1 w-full rounded-md px-3 py-2 text-left text-sm text-rose-600 hover:bg-rose-50">Logout</button>
                            </form>
                        </div>
                    </div>
                @endauth
            </div>
        </div>
    </nav>

    <main class="mx-auto max-w-7xl px-4 py-8">
        @yield('content')
    </main>

    <footer class="mt-12 bg-white py-8">
        <div class="mx-auto flex max-w-7xl flex-wrap items-center justify-between gap-4 px-4 text-sm text-slate-500">
            <p>&copy; {{ date('Y') }} TiketWisata Marketplace</p>
            <div class="flex flex-wrap gap-4">
                <a href="https://instagram.com" target="_blank" class="hover:text-emerald-600">Instagram</a>
                <a href="https://facebook.com" target="_blank" class="hover:text-emerald-600">Facebook</a>
                <a href="{{ route('destinations.index') }}" class="hover:text-emerald-600">Wisata</a>
                <a href="{{ route('contact') }}" class="hover:text-emerald-600">Kontak</a>
            </div>
        </div>
    </footer>

    @if(session('success'))
        <script>Swal.fire({icon:'success',title:'Berhasil',text:@json(session('success')),timer:2200,showConfirmButton:false});</script>
    @endif
    @if($errors->any())
        <script>Swal.fire({icon:'error',title:'Oops',text:@json($errors->first())});</script>
    @endif
</body>
</html>
