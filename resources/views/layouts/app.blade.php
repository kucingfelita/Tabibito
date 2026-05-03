<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $title ?? 'Tabibito Jateng' }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<style>
        /* Mobile 640px | Tablet 768px | Desktop 1024px+ */
        @media (max-width: 639px) {
            .desktop-nav { display: none !important; }
            .mobile-menu { display: block; }
            .main-content { padding: 16px 12px; }
            .card-stack { flex-direction: column; }
            .card-img { width: 100%; height: 45vw; }
            .grid-2 { grid-template-columns: 1fr; }
            .filter-side { display: none; }
            .text-responsive { font-size: 1.125rem; }
            .btn-full { width: 100%; text-align: center; }
        }
        @media (min-width: 640px) and (max-width: 767px) {
            .main-content { padding: 20px 16px; }
            .grid-2 { grid-template-columns: repeat(2, 1fr); }
            .card-img { width: 110px; height: 85px; }
        }
        @media (min-width: 768px) {
            .mobile-toggle { display: none; }
            .grid-2 { grid-template-columns: repeat(4, 1fr); }
        }
    </style>
</head>
<body class="bg-slate-50 text-slate-800">
    <!-- Responsive Navigation -->
    <nav class="bg-white shadow-sm" x-data="{ navOpen: false }">
        <div class="mx-auto flex max-w-7xl items-center justify-between px-4 py-3 md:py-4">
            <a href="{{ route('home') }}" class="text-lg md:text-xl font-bold text-emerald-600">Tabibito Jateng</a>
            
            <!-- Desktop Menu -->
            <div class="desktop-nav flex items-center gap-3">
                <a href="{{ route('home') }}" class="text-sm text-slate-600 hover:text-emerald-600">Beranda</a>
                <a href="{{ route('destinations.index') }}" class="text-sm text-slate-600 hover:text-emerald-600">Wisata</a>
                <a href="{{ route('contact') }}" class="text-sm text-slate-600 hover:text-emerald-600">Kontak</a>
                @guest
                    <a href="{{ route('register') }}" class="rounded-lg border border-emerald-500 px-3 py-1.5 md:px-4 py-2 text-sm font-medium text-emerald-600">Sign Up</a>
                    <a href="{{ route('login') }}" class="rounded-lg bg-emerald-600 px-3 py-1.5 md:px-4 py-2 text-sm font-medium text-white">Login</a>
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
            
            <!-- Mobile Hamburger Button -->
            <button @click="navOpen = !navOpen" class="mobile-toggle p-2" aria-label="Menu">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                </svg>
            </button>
        </div>
        
        <!-- Mobile Dropdown Menu -->
        <div x-show="navOpen" x-transition class="mobile-menu bg-white border-t">
            <div class="px-4 py-3 space-y-2">
                <a href="{{ route('home') }}" class="block py-2 text-sm text-slate-600 hover:text-emerald-600">Beranda</a>
                <a href="{{ route('destinations.index') }}" class="block py-2 text-sm text-slate-600 hover:text-emerald-600">Wisata</a>
                <a href="{{ route('contact') }}" class="block py-2 text-sm text-slate-600 hover:text-emerald-600">Kontak</a>
                @guest
                    <div class="flex gap-2 pt-2">
                        <a href="{{ route('register') }}" class="flex-1 text-center rounded-lg border border-emerald-500 px-3 py-2 text-sm font-medium text-emerald-600">Sign Up</a>
                        <a href="{{ route('login') }}" class="flex-1 text-center rounded-lg bg-emerald-600 px-3 py-2 text-sm font-medium text-white">Login</a>
                    </div>
                @endauth
                @auth
                    <a href="{{ route('profile') }}" class="block py-2 text-sm text-slate-600 hover:bg-slate-100">Profile</a>
                    <a href="{{ route('history.index') }}" class="block py-2 text-sm text-slate-600 hover:bg-slate-100">Riwayat</a>
                    @if(in_array(auth()->user()->tipe_user, [1,3], true))
                        <a href="{{ auth()->user()->tipe_user === 1 ? route('admin.dashboard') : route('owner.dashboard') }}" class="block py-2 text-sm text-slate-600 hover:bg-slate-100">Dashboard</a>
                    @endif
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button class="w-full text-left py-2 text-sm text-rose-600 hover:bg-rose-50">Logout</button>
                    </form>
                @endauth
            </div>
        </div>
    </nav>

    <main class="mx-auto max-w-7xl main-content">
        @yield('content')
    </main>

    <footer class="mt-12 bg-white py-8">
        <div class="mx-auto flex max-w-7xl flex-wrap items-center justify-between gap-4 px-4 text-sm text-slate-500">
            <p>&copy; {{ date('Y') }} Tabibito Jateng</p>
            <div class="flex flex-wrap gap-4">
                <a href="https://instagram.com/kucing_felita" target="_blank" class="hover:text-emerald-600">Instagram</a>
                {{-- <a href="https://facebook.com" target="_blank" class="hover:text-emerald-600">Facebook</a> --}}
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
    @stack('scripts')
</body>
</html>
