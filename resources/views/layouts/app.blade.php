<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $title ?? 'Tabibito Jateng' }}</title>
    <link rel="icon" href="{{ asset('assets/images/tabibito_T_v3.svg') }}">
    
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <!-- Styles & Scripts -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['Outfit', 'sans-serif'],
                    },
                    colors: {
                        primary: {
                            50: '#f0f7ff',
                            100: '#e0effe',
                            200: '#bae0fd',
                            300: '#7cc7fb',
                            400: '#38a9f8',
                            500: '#0e8ce9',
                            600: '#026ec7',
                            700: '#0358a1',
                            800: '#074a85',
                            900: '#0c3f6f',
                            950: '#082849',
                        },
                        secondary: {
                            50: '#fff7ed',
                            100: '#ffedd5',
                            200: '#fed7aa',
                            300: '#fdba74',
                            400: '#fb923c',
                            500: '#f97316',
                            600: '#ea580c',
                            700: '#c2410c',
                            800: '#9a3412',
                            900: '#7c2d12',
                            950: '#431407',
                        },
                    }
                }
            }
        }
    </script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    
    <style>
        [x-cloak] { display: none !important; }
        
        .glass-nav {
            background: rgba(255, 255, 255, 0.8);
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
        }

        .btn-premium {
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .btn-premium:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
        }

        @media (max-width: 639px) {
            .main-content { padding: 16px 16px; }
        }
    </style>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />
    @stack('styles')
</head>
<body class="bg-[#F8FAFC] text-slate-900 font-sans antialiased">
    <!-- Premium Navigation -->
    <nav class="sticky top-0 z-50 glass-nav border-b border-slate-200/60" x-data="{ navOpen: false }">
        <div class="mx-auto flex max-w-7xl items-center justify-between px-4 h-16 md:h-20">
            <!-- Logo -->
            <a href="{{ route('home') }}" class="flex items-center gap-2 group">
                <div class="bg-primary-600 p-1.5 rounded-lg group-hover:rotate-12 transition-transform">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
                <span class="text-xl md:text-2xl font-bold bg-gradient-to-r from-primary-700 to-primary-500 bg-clip-text text-transparent">Tabibito</span>
            </a>
            
            <!-- Desktop Menu -->
            <div class="hidden md:flex items-center gap-8">
                @if(auth()->guest() || auth()->user()->tipe_user === \App\Models\User::TYPE_USER)
                <div class="flex items-center gap-6">
                    <a href="{{ route('home') }}" class="text-[15px] font-medium {{ request()->routeIs('home') ? 'text-primary-600' : 'text-slate-600 hover:text-primary-600' }} transition-colors">Beranda</a>
                    <a href="{{ route('destinations.index') }}" class="text-[15px] font-medium {{ request()->routeIs('destinations.*') ? 'text-primary-600' : 'text-slate-600 hover:text-primary-600' }} transition-colors">Wisata</a>
                    <a href="{{ route('contact') }}" class="text-[15px] font-medium {{ request()->routeIs('contact') ? 'text-primary-600' : 'text-slate-600 hover:text-primary-600' }} transition-colors">Kontak</a>
                </div>
                @else
                <div class="flex items-center gap-6">
                    @if(auth()->user()->tipe_user === \App\Models\User::TYPE_ADMIN)
                        <a href="{{ route('admin.dashboard') }}" class="text-[15px] font-medium {{ request()->routeIs('admin.dashboard') ? 'text-primary-600' : 'text-slate-600 hover:text-primary-600' }} transition-colors">Dashboard Admin</a>
                    @elseif(auth()->user()->tipe_user === \App\Models\User::TYPE_OWNER)
                        <a href="{{ route('owner.dashboard') }}" class="text-[15px] font-medium {{ request()->routeIs('owner.dashboard') ? 'text-primary-600' : 'text-slate-600 hover:text-primary-600' }} transition-colors">Dashboard Owner</a>
                    @elseif(auth()->user()->tipe_user === \App\Models\User::TYPE_EMPLOYEE)
                        <a href="{{ route('owner.scanner') }}" class="text-[15px] font-medium {{ request()->routeIs('owner.scanner') ? 'text-primary-600' : 'text-slate-600 hover:text-primary-600' }} transition-colors">Scanner Tiket</a>
                        <a href="{{ route('owner.scan-history') }}" class="text-[15px] font-medium {{ request()->routeIs('owner.scan-history') ? 'text-primary-600' : 'text-slate-600 hover:text-primary-600' }} transition-colors">Riwayat Scan</a>
                    @endif
                </div>
                @endif

                <div class="h-6 w-px bg-slate-200"></div>

                @guest
                    <div class="flex items-center gap-3">
                        <a href="{{ route('login') }}" class="text-[15px] font-semibold text-primary-600 hover:text-primary-700 px-4 py-2">Masuk</a>
                        <a href="{{ route('register') }}" class="btn-premium bg-primary-600 hover:bg-primary-700 text-white px-6 py-2.5 rounded-xl text-[15px] font-semibold shadow-md shadow-primary-200">Daftar Sekarang</a>
                    </div>
                @endguest

                @auth
                    <div x-data="{open:false}" class="relative">
                        <button @click="open=!open" class="flex items-center gap-2 group">
                            <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-primary-50 font-bold text-primary-600 border border-primary-100 group-hover:bg-primary-100 transition-colors">
                                {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                            </div>
                            <svg class="w-4 h-4 text-slate-400 group-hover:text-primary-600 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                            </svg>
                        </button>
                        <div x-show="open" x-cloak @click.outside="open=false" x-transition:enter="transition ease-out duration-100" x-transition:enter-start="transform opacity-0 scale-95" x-transition:enter-end="transform opacity-100 scale-100" class="absolute right-0 z-10 mt-3 w-60 rounded-2xl border border-slate-100 bg-white p-2 shadow-xl ring-1 ring-black/5">
                            <div class="px-3 py-2 mb-2 border-b border-slate-50">
                                <p class="text-xs font-black text-slate-800 truncate">{{ auth()->user()->name }}</p>
                                @if(auth()->user()->tipe_user === \App\Models\User::TYPE_EMPLOYEE)
                                    <p class="text-[10px] text-violet-500 font-bold uppercase tracking-widest mt-0.5">Karyawan</p>
                                @elseif(auth()->user()->tipe_user === \App\Models\User::TYPE_OWNER)
                                    <p class="text-[10px] text-primary-500 font-bold uppercase tracking-widest mt-0.5">Owner</p>
                                @elseif(auth()->user()->tipe_user === \App\Models\User::TYPE_ADMIN)
                                    <p class="text-[10px] text-amber-500 font-bold uppercase tracking-widest mt-0.5">Admin</p>
                                @endif
                            </div>

                            @if(auth()->user()->tipe_user === \App\Models\User::TYPE_EMPLOYEE)
                                {{-- Karyawan: link pindah ke navbar utama, dropdown cukup info profil & logout saja --}}
                                <div class="px-3 py-2 text-xs text-slate-500 font-medium">Menu Karyawan</div>
                            @else
                                {{-- User, Owner, Admin --}}
                                <a href="{{ route('profile') }}" class="flex items-center gap-3 rounded-xl px-3 py-2.5 text-sm text-slate-600 hover:bg-slate-50 hover:text-primary-600 transition-colors">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                                    Profile Saya
                                </a>
                                @if(auth()->user()->tipe_user === \App\Models\User::TYPE_USER)
                                    <a href="{{ route('wishlist.index') }}" class="flex items-center gap-3 rounded-xl px-3 py-2.5 text-sm text-slate-600 hover:bg-slate-50 hover:text-primary-600 transition-colors">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/></svg>
                                        Wishlist Saya
                                    </a>
                                    <a href="{{ route('history.index') }}" class="flex items-center gap-3 rounded-xl px-3 py-2.5 text-sm text-slate-600 hover:bg-slate-50 hover:text-primary-600 transition-colors">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                        Riwayat Pesanan
                                    </a>
                                @endif
                            @endif

                            <div class="my-2 border-t border-slate-50"></div>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button class="flex w-full items-center gap-3 rounded-xl px-3 py-2.5 text-left text-sm text-rose-600 hover:bg-rose-50 transition-colors font-medium">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/></svg>
                                    Keluar
                                </button>
                            </form>
                        </div>
                    </div>
                @endauth
            </div>
            
            <!-- Mobile Toggle -->
            <button @click="navOpen = !navOpen" class="md:hidden p-2 text-slate-600 hover:bg-slate-100 rounded-xl transition-colors">
                <svg x-show="!navOpen" class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/></svg>
                <svg x-show="navOpen" x-cloak class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
            </button>
        </div>
        
        <!-- Mobile Menu -->
        <div x-show="navOpen" x-cloak x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 -translate-y-4" x-transition:enter-end="opacity-100 translate-y-0" class="md:hidden bg-white border-t border-slate-100 shadow-xl overflow-hidden">
            <div class="px-4 py-6 space-y-4">
                @if(auth()->guest() || auth()->user()->tipe_user === \App\Models\User::TYPE_USER)
                <div class="grid gap-2 pb-4 border-b border-slate-100">
                    <a href="{{ route('home') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl {{ request()->routeIs('home') ? 'bg-primary-50 text-primary-700 font-bold' : 'text-slate-600 hover:bg-slate-50' }}">Beranda</a>
                    <a href="{{ route('destinations.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl {{ request()->routeIs('destinations.*') ? 'bg-primary-50 text-primary-700 font-bold' : 'text-slate-600 hover:bg-slate-50' }}">Wisata</a>
                    <a href="{{ route('contact') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl {{ request()->routeIs('contact') ? 'bg-primary-50 text-primary-700 font-bold' : 'text-slate-600 hover:bg-slate-50' }}">Kontak</a>
                </div>
                @endif
                
                <div>
                    @guest
                        <div class="grid grid-cols-2 gap-3">
                            <a href="{{ route('login') }}" class="flex items-center justify-center px-4 py-3 rounded-xl border border-primary-200 text-primary-600 font-bold">Masuk</a>
                            <a href="{{ route('register') }}" class="flex items-center justify-center px-4 py-3 rounded-xl bg-primary-600 text-white font-bold shadow-lg shadow-primary-200">Daftar</a>
                        </div>
                    @endguest
                    @auth
                        <div class="space-y-1">
                            @if(auth()->user()->tipe_user === \App\Models\User::TYPE_EMPLOYEE)
                                {{-- Karyawan: langsung ke scanner & riwayat --}}
                                <div class="px-4 py-2">
                                    <span class="text-[10px] font-black text-violet-500 uppercase tracking-widest">Karyawan</span>
                                </div>
                                <a href="{{ route('owner.scanner') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl text-slate-600 hover:bg-violet-50 hover:text-violet-700 font-medium">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16 20h4M4 12h4m12 0h.01M5 8h2a1 1 0 001-1V5a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1zm12 0h2a1 1 0 001-1V5a1 1 0 00-1-1h-2a1 1 0 00-1 1v2a1 1 0 001 1zM5 20h2a1 1 0 001-1v-2a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1z"/></svg>
                                    Scanner Tiket
                                </a>
                                <a href="{{ route('owner.scan-history') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl text-slate-600 hover:bg-violet-50 hover:text-violet-700 font-medium">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg>
                                    Riwayat Scan
                                </a>
                            @else
                                <a href="{{ route('profile') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl text-slate-600 hover:bg-slate-50 font-medium">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                                    Profile Saya
                                </a>
                                
                                @if(auth()->user()->tipe_user === \App\Models\User::TYPE_USER)
                                    <a href="{{ route('wishlist.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl text-slate-600 hover:bg-slate-50 font-medium">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/></svg>
                                        Wishlist Saya
                                    </a>
                                    <a href="{{ route('history.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl text-slate-600 hover:bg-slate-50 font-medium">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg>
                                        Riwayat Pesanan
                                    </a>
                                @endif

                                @if(in_array(auth()->user()->tipe_user, [1,3], true))
                                    <a href="{{ auth()->user()->tipe_user === 1 ? route('admin.dashboard') : route('owner.dashboard') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl text-primary-600 hover:bg-primary-50 font-bold border-t border-slate-50 mt-1 pt-4">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"/></svg>
                                        Dashboard {{ auth()->user()->tipe_user === 1 ? 'Admin' : 'Owner' }}
                                    </a>
                                @endif
                            @endif
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button class="w-full text-left px-4 py-3 rounded-xl text-rose-600 hover:bg-rose-50 font-bold">Keluar</button>
                            </form>
                        </div>
                    @endauth
                </div>
            </div>
        </div>
    </nav>

    <main class="mx-auto max-w-7xl main-content py-8 md:py-12">
        @yield('content')
    </main>

    <footer class="mt-20 bg-white border-t border-slate-200 pt-16 pb-8">
        <div class="mx-auto max-w-7xl px-4">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-12 mb-12">
                <div class="col-span-1 md:col-span-1">
                    <a href="{{ route('home') }}" class="flex items-center gap-2 mb-6">
                        <div class="bg-primary-600 p-1 rounded-lg">
                            <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        </div>
                        <span class="text-xl font-bold text-slate-900">Tabibito</span>
                    </a>
                    <p class="text-slate-500 text-sm leading-relaxed">Platform pemesanan tiket wisata terlengkap dan terpercaya di Jawa Tengah. Jelajahi keindahan alam dan budaya bersama kami.</p>
                </div>
                
                <div>
                    <h4 class="font-bold text-slate-900 mb-6 uppercase text-xs tracking-widest">Menu Cepat</h4>
                    <ul class="space-y-4 text-sm">
                        <li><a href="{{ route('home') }}" class="text-slate-500 hover:text-primary-600 transition-colors">Beranda</a></li>
                        <li><a href="{{ route('destinations.index') }}" class="text-slate-500 hover:text-primary-600 transition-colors">Cari Wisata</a></li>
                        <li><a href="{{ route('contact') }}" class="text-slate-500 hover:text-primary-600 transition-colors">Hubungi Kami</a></li>
                    </ul>
                </div>

                <div>
                    <h4 class="font-bold text-slate-900 mb-6 uppercase text-xs tracking-widest">Dukungan</h4>
                    <ul class="space-y-4 text-sm">
                        <li><a href="{{ route('contact') }}" class="text-slate-500 hover:text-primary-600 transition-colors">Pusat Bantuan</a></li>
                        <li><a href="{{ route('terms') }}" class="text-slate-500 hover:text-primary-600 transition-colors">Syarat & Ketentuan</a></li>
                        <li><a href="{{ route('privacy') }}" class="text-slate-500 hover:text-primary-600 transition-colors">Kebijakan Privasi</a></li>
                    </ul>
                </div>

                <div>
                    <h4 class="font-bold text-slate-900 mb-6 uppercase text-xs tracking-widest">Ikuti Kami</h4>
                    <div class="flex gap-4">
                        <a href="https://instagram.com/kucing_felita" target="_blank" class="w-10 h-10 flex items-center justify-center rounded-xl bg-slate-50 text-slate-400 hover:bg-primary-50 hover:text-primary-600 transition-all">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"/></svg>
                        </a>
                        <a href="#" class="w-10 h-10 flex items-center justify-center rounded-xl bg-slate-50 text-slate-400 hover:bg-primary-50 hover:text-primary-600 transition-all">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M24 4.557c-.883.392-1.832.656-2.828.775 1.017-.609 1.798-1.574 2.165-2.724-.951.564-2.005.974-3.127 1.195-.897-.957-2.178-1.555-3.594-1.555-3.179 0-5.515 2.966-4.797 6.045-4.091-.205-7.719-2.165-10.148-5.144-1.29 2.213-.669 5.108 1.523 6.574-.806-.026-1.566-.247-2.229-.616-.054 2.281 1.581 4.415 3.949 4.89-.693.188-1.452.232-2.224.084.626 1.956 2.444 3.379 4.6 3.419-2.07 1.623-4.678 2.348-7.29 2.04 2.179 1.397 4.768 2.212 7.548 2.212 9.142 0 14.307-7.721 13.995-14.646.962-.695 1.797-1.562 2.457-2.549z"/></svg>
                        </a>
                    </div>
                </div>
            </div>
            
            <div class="pt-8 border-t border-slate-100 flex flex-col md:flex-row justify-between items-center gap-4">
                <p class="text-slate-400 text-xs tracking-wide">© {{ date('Y') }} Tabibito Jateng. All rights reserved.</p>
                <div class="flex gap-6">
                    <!-- <img src="https://upload.wikimedia.org/wikipedia/commons/b/b5/Midtrans_Logo.png" alt="Midtrans" class="h-4 grayscale opacity-50 hover:opacity-100 transition-opacity"> -->
                </div>
            </div>
        </div>
    </footer>

    @if(session('success'))
        <script>Swal.fire({icon:'success',title:'Berhasil',text:@json(session('success')),timer:2200,showConfirmButton:false,customClass:{popup:'rounded-3xl'}});</script>
    @endif
    @if($errors->any())
        <script>Swal.fire({icon:'error',title:'Oops',text:@json($errors->first()),customClass:{popup:'rounded-3xl'}});</script>
    @endif
    @stack('scripts')
    @auth
    <script>
        function toggleWishlist(event, destinationId) {
            event.preventDefault();
            event.stopPropagation();
            
            const btn = document.getElementById('wishlist-btn-' + destinationId);
            const svg = btn.querySelector('svg');
            
            fetch('/wishlist/' + destinationId + '/toggle', {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Accept': 'application/json'
                }
            })
            .then(res => res.json())
            .then(data => {
                if (data.status === 'added') {
                    btn.className = 'absolute -top-2 -right-2 w-10 h-10 rounded-xl flex items-center justify-center transition-all shadow-lg z-10 bg-primary-600 text-white shadow-primary-200';
                    svg.classList.replace('fill-none', 'fill-current');
                } else {
                    btn.className = 'absolute -top-2 -right-2 w-10 h-10 rounded-xl flex items-center justify-center transition-all shadow-lg z-10 bg-white text-slate-400 hover:text-primary-600 shadow-slate-200';
                    svg.classList.replace('fill-current', 'fill-none');
                }
                
                // If we are on the wishlist page, and it's removed, hide the card
                if (window.location.pathname === '/wishlist' && data.status === 'removed') {
                    btn.closest('.group').remove();
                    if (document.querySelectorAll('#destination-container > div').length === 0) {
                        location.reload();
                    }
                }
            })
            .catch(err => {
                console.error(err);
                Swal.fire({icon:'error',title:'Gagal',text:'Terjadi kesalahan saat memproses wishlist.'});
            });
        }
    </script>
    @endauth
    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    @stack('scripts')
</body>
</html>

