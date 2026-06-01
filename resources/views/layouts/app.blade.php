<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $title ?? 'Tabibito Jateng' }}</title>
    <meta name="description" content="{{ $meta_description ?? 'Tabibito Jateng adalah platform pemesanan tiket wisata online terlengkap dan terpercaya di Jawa Tengah. Jelajahi keindahan alam dan budaya Jateng sekarang.' }}">
    <meta name="keywords" content="tabibito, tabibito jateng, tiket wisata, wisata jawa tengah, tiket online wisata, booking tiket jawa tengah, pariwisata jateng">
    
    <!-- Open Graph / Facebook -->
    <meta property="og:type" content="website">
    <meta property="og:url" content="{{ request()->url() }}">
    <meta property="og:title" content="{{ $title ?? 'Tabibito Jateng - Pemesanan Tiket Wisata Online' }}">
    <meta property="og:description" content="{{ $meta_description ?? 'Tabibito Jateng adalah platform pemesanan tiket wisata online terlengkap dan terpercaya di Jawa Tengah.' }}">
    <meta property="og:image" content="{{ asset('assets/images/hero.webp') }}">

    <!-- Twitter -->
    <meta property="twitter:card" content="summary_large_image">
    <meta property="twitter:url" content="{{ request()->url() }}">
    <meta property="twitter:title" content="{{ $title ?? 'Tabibito Jateng - Pemesanan Tiket Wisata Online' }}">
    <meta property="twitter:description" content="{{ $meta_description ?? 'Tabibito Jateng adalah platform pemesanan tiket wisata online terlengkap dan terpercaya di Jawa Tengah.' }}">
    <meta property="twitter:image" content="{{ asset('assets/images/hero.webp') }}">

    <link rel="icon" href="{{ asset('assets/images/tabibito_T_v3.svg') }}">
    
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&family=Outfit:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- Preload LCP Image -->
    @if(request()->routeIs('home'))
        <link rel="preload" as="image" href="{{ asset('assets/images/hero.webp') }}" fetchpriority="high">
    @endif

    <!-- Icon Libraries -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">

    <!-- Styles & Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    
    <!-- Flatpickr (Global Datepicker) -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    
    <style>
        [x-cloak] { display: none !important; }
        
        .glass-nav {
            background: rgba(255, 255, 255, 0.85);
            backdrop-filter: blur(16px);
            -webkit-backdrop-filter: blur(16px);
        }

        .btn-premium {
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .btn-premium:hover {
            transform: translateY(-2px);
            box-shadow: 0 12px 20px -3px rgba(14, 140, 233, 0.25), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
        }

        @media (max-width: 639px) {
            .main-content { padding: 16px 16px; }
        }

        /* Shimmer Loading Animations */
        @keyframes shimmer {
            0% { background-position: -200% 0; }
            100% { background-position: 200% 0; }
        }
        .shimmer {
            background: linear-gradient(90deg, #f1f5f9 25%, #e2e8f0 50%, #f1f5f9 75%);
            background-size: 200% 100%;
            animation: shimmer 1.5s infinite linear;
        }

        /* Premium Nav Link Underline Hover */
        .nav-link-hover {
            position: relative;
        }
        .nav-link-hover::after {
            content: '';
            position: absolute;
            width: 100%;
            transform: scaleX(0);
            height: 2.5px;
            bottom: -6px;
            left: 0;
            background: linear-gradient(90deg, #0e8ce9, #f97316);
            transform-origin: bottom right;
            transition: transform 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            border-radius: 9999px;
        }
        .nav-link-hover:hover::after, .nav-link-active::after {
            transform: scaleX(1);
            transform-origin: bottom left;
        }
        
        .nav-link-active::after {
            content: '';
            position: absolute;
            width: 100%;
            height: 2.5px;
            bottom: -6px;
            left: 0;
            background: linear-gradient(90deg, #0e8ce9, #f97316);
            border-radius: 9999px;
        }

        /* Custom Scrollbar */
        .custom-scrollbar::-webkit-scrollbar {
            width: 8px;
            height: 8px;
        }
        .custom-scrollbar::-webkit-scrollbar-track {
            background: #f1f5f9;
            border-radius: 10px;
        }
        .custom-scrollbar::-webkit-scrollbar-thumb {
            background: #cbd5e1;
            border-radius: 10px;
        }
        .custom-scrollbar::-webkit-scrollbar-thumb:hover {
            background: #94a3b8;
        }
    </style>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />
    @stack('styles')
</head>
<body class="bg-[#F8FAFC] text-slate-900 font-sans antialiased min-h-screen flex flex-col">
    <!-- Premium Navigation -->
    <nav class="sticky top-0 z-50 glass-nav border-b border-slate-100" x-data="{ navOpen: false }">
        <div class="mx-auto flex max-w-7xl items-center justify-between px-4 h-16 md:h-20">
            <!-- Logo -->
            <a href="{{ route('home') }}" class="flex items-center gap-2 group">
                <div class="bg-gradient-to-tr from-primary-600 to-primary-500 p-2 rounded-xl group-hover:rotate-12 transition-transform duration-300 shadow-md shadow-primary-200">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
                <div class="flex flex-col">
                    <span class="text-xl md:text-2xl font-bold bg-gradient-to-r from-slate-900 via-primary-700 to-primary-600 bg-clip-text text-transparent tracking-tight">Tabibito<span class="text-secondary-500">.</span></span>
                    <span class="text-[9px] text-slate-400 font-bold uppercase tracking-widest -mt-1">Jateng Ticket</span>
                </div>
            </a>
            
            <!-- Desktop Menu -->
            <div class="hidden md:flex items-center gap-8">
                @if(auth()->guest() || auth()->user()->tipe_user === \App\Models\User::TYPE_USER)
                <div class="flex items-center gap-8">
                    <a href="{{ route('home') }}" class="text-[15px] font-semibold nav-link-hover {{ request()->routeIs('home') ? 'text-primary-600 nav-link-active' : 'text-slate-600 hover:text-primary-600' }} transition-colors">Beranda</a>
                    <a href="{{ route('destinations.index') }}" class="text-[15px] font-semibold nav-link-hover {{ request()->routeIs('destinations.*') ? 'text-primary-600 nav-link-active' : 'text-slate-600 hover:text-primary-600' }} transition-colors">Wisata</a>
                    <a href="{{ route('contact') }}" class="text-[15px] font-semibold nav-link-hover {{ request()->routeIs('contact') ? 'text-primary-600 nav-link-active' : 'text-slate-600 hover:text-primary-600' }} transition-colors">Kontak</a>
                </div>
                @else
                <div class="flex items-center gap-6">
                    @if(auth()->user()->tipe_user === \App\Models\User::TYPE_ADMIN)
                        <a href="{{ route('admin.dashboard') }}" class="text-[15px] font-semibold nav-link-hover {{ request()->routeIs('admin.dashboard') ? 'text-primary-600 nav-link-active' : 'text-slate-600 hover:text-primary-600' }} transition-colors">Dashboard</a>
                        <a href="{{ route('admin.destinations.index') }}" class="text-[15px] font-semibold nav-link-hover {{ request()->routeIs('admin.destinations.*') ? 'text-primary-600 nav-link-active' : 'text-slate-600 hover:text-primary-600' }} transition-colors">Destinasi</a>
                    @elseif(auth()->user()->tipe_user === \App\Models\User::TYPE_OWNER)
                        <a href="{{ route('owner.dashboard') }}" class="text-[15px] font-semibold nav-link-hover {{ request()->routeIs('owner.dashboard') ? 'text-primary-600 nav-link-active' : 'text-slate-600 hover:text-primary-600' }} transition-colors">Dashboard Owner</a>
                    @elseif(auth()->user()->tipe_user === \App\Models\User::TYPE_EMPLOYEE)
                        <a href="{{ route('owner.scanner') }}" class="text-[15px] font-semibold nav-link-hover {{ request()->routeIs('owner.scanner') ? 'text-primary-600 nav-link-active' : 'text-slate-600 hover:text-primary-600' }} transition-colors">Scanner Tiket</a>
                        <a href="{{ route('owner.scan-history') }}" class="text-[15px] font-semibold nav-link-hover {{ request()->routeIs('owner.scan-history') ? 'text-primary-600 nav-link-active' : 'text-slate-600 hover:text-primary-600' }} transition-colors">Riwayat Scan</a>
                    @endif
                </div>
                @endif

                <div class="h-6 w-px bg-slate-200"></div>

                @guest
                    <div class="flex items-center gap-3">
                        <a href="{{ route('login') }}" class="text-[15px] font-bold text-slate-700 hover:text-primary-600 px-4 py-2 transition-colors">Masuk</a>
                        <a href="{{ route('register') }}" class="btn-premium bg-gradient-to-r from-primary-600 to-primary-500 hover:from-primary-700 hover:to-primary-600 text-white px-6 py-2.5 rounded-xl text-[15px] font-bold shadow-md shadow-primary-200">Daftar Sekarang</a>
                    </div>
                @endguest

                @auth
                    <div x-data="{open:false}" class="relative">
                        <button @click="open=!open" class="flex items-center gap-3 group bg-slate-50 border border-slate-200/80 rounded-2xl px-3 py-1.5 hover:bg-slate-100 transition-colors">
                            <div class="flex h-8 w-8 items-center justify-center rounded-xl bg-gradient-to-tr from-primary-600 to-primary-500 font-bold text-white shadow-sm">
                                {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                            </div>
                            <span class="text-sm font-semibold text-slate-700 group-hover:text-primary-600 transition-colors max-w-[120px] truncate">{{ auth()->user()->name }}</span>
                            <svg class="w-4 h-4 text-slate-400 group-hover:text-primary-600 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                            </svg>
                        </button>
                        <div x-show="open" x-cloak @click.outside="open=false" x-transition:enter="transition ease-out duration-100" x-transition:enter-start="transform opacity-0 scale-95" x-transition:enter-end="transform opacity-100 scale-100" class="absolute right-0 z-10 mt-3 w-60 rounded-2xl border border-slate-100 bg-white p-2 shadow-xl ring-1 ring-black/5">
                            <div class="px-3 py-2.5 mb-2 border-b border-slate-50">
                                <p class="text-xs font-black text-slate-800 truncate">{{ auth()->user()->name }}</p>
                                @if(auth()->user()->tipe_user === \App\Models\User::TYPE_EMPLOYEE)
                                    <p class="text-[10px] text-violet-500 font-bold uppercase tracking-widest mt-0.5"><i class="fa-solid fa-user-gear mr-1"></i>Karyawan</p>
                                @elseif(auth()->user()->tipe_user === \App\Models\User::TYPE_OWNER)
                                    <p class="text-[10px] text-primary-500 font-bold uppercase tracking-widest mt-0.5"><i class="fa-solid fa-user-tie mr-1"></i>Owner</p>
                                @elseif(auth()->user()->tipe_user === \App\Models\User::TYPE_ADMIN)
                                    <p class="text-[10px] text-amber-500 font-bold uppercase tracking-widest mt-0.5"><i class="fa-solid fa-user-shield mr-1"></i>Admin</p>
                                @else
                                    <p class="text-[10px] text-emerald-500 font-bold uppercase tracking-widest mt-0.5"><i class="fa-solid fa-user mr-1"></i>Traveler</p>
                                @endif
                            </div>

                            @if(auth()->user()->tipe_user === \App\Models\User::TYPE_EMPLOYEE)
                                <div class="px-3 py-2 text-xs text-slate-400 font-bold uppercase tracking-wider">Menu Karyawan</div>
                                <a href="{{ route('owner.scanner') }}" class="flex items-center gap-3 rounded-xl px-3 py-2.5 text-sm text-slate-600 hover:bg-slate-50 hover:text-primary-600 transition-colors">
                                    <i class="fa-solid fa-barcode text-slate-400 w-4"></i> Scanner Tiket
                                </a>
                                <a href="{{ route('owner.scan-history') }}" class="flex items-center gap-3 rounded-xl px-3 py-2.5 text-sm text-slate-600 hover:bg-slate-50 hover:text-primary-600 transition-colors">
                                    <i class="fa-solid fa-clock-rotate-left text-slate-400 w-4"></i> Riwayat Scan
                                </a>
                            @else
                                <a href="{{ route('profile') }}" class="flex items-center gap-3 rounded-xl px-3 py-2.5 text-sm text-slate-600 hover:bg-slate-50 hover:text-primary-600 transition-colors">
                                    <i class="fa-regular fa-user text-slate-400 w-4"></i> Profil Saya
                                </a>
                                @if(auth()->user()->tipe_user === \App\Models\User::TYPE_USER)
                                    <a href="{{ route('wishlist.index') }}" class="flex items-center gap-3 rounded-xl px-3 py-2.5 text-sm text-slate-600 hover:bg-slate-50 hover:text-primary-600 transition-colors">
                                        <i class="fa-regular fa-heart text-slate-400 w-4"></i> Wishlist Saya
                                    </a>
                                    <a href="{{ route('history.index') }}" class="flex items-center gap-3 rounded-xl px-3 py-2.5 text-sm text-slate-600 hover:bg-slate-50 hover:text-primary-600 transition-colors">
                                        <i class="fa-solid fa-receipt text-slate-400 w-4"></i> Riwayat Pesanan
                                    </a>
                                @endif
                            @endif

                            <div class="my-2 border-t border-slate-50"></div>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button class="flex w-full items-center gap-3 rounded-xl px-3 py-2.5 text-left text-sm text-rose-600 hover:bg-rose-50 transition-colors font-semibold">
                                    <i class="fa-solid fa-arrow-right-from-bracket w-4"></i> Keluar
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
                                <div class="px-4 py-2">
                                    <span class="text-[10px] font-black text-violet-500 uppercase tracking-widest">Karyawan</span>
                                </div>
                                <a href="{{ route('owner.scanner') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl text-slate-600 hover:bg-violet-50 hover:text-violet-700 font-medium">
                                    <i class="fa-solid fa-barcode"></i> Scanner Tiket
                                </a>
                                <a href="{{ route('owner.scan-history') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl text-slate-600 hover:bg-violet-50 hover:text-violet-700 font-medium">
                                    <i class="fa-solid fa-clock-rotate-left"></i> Riwayat Scan
                                </a>
                            @else
                                <a href="{{ route('profile') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl text-slate-600 hover:bg-slate-50 font-medium">
                                    <i class="fa-regular fa-user"></i> Profil Saya
                                </a>
                                
                                @if(auth()->user()->tipe_user === \App\Models\User::TYPE_USER)
                                    <a href="{{ route('wishlist.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl text-slate-600 hover:bg-slate-50 font-medium">
                                        <i class="fa-regular fa-heart"></i> Wishlist Saya
                                    </a>
                                    <a href="{{ route('history.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl text-slate-600 hover:bg-slate-50 font-medium">
                                        <i class="fa-solid fa-receipt"></i> Riwayat Pesanan
                                    </a>
                                @endif
 
                                @if(in_array(auth()->user()->tipe_user, [1,3], true))
                                    <a href="{{ auth()->user()->tipe_user === 1 ? route('admin.dashboard') : route('owner.dashboard') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl text-primary-600 hover:bg-primary-50 font-bold border-t border-slate-50 mt-1 pt-4">
                                        <i class="fa-solid fa-chart-line"></i> Dashboard {{ auth()->user()->tipe_user === 1 ? 'Admin' : 'Owner' }}
                                    </a>
                                    @if(auth()->user()->tipe_user === \App\Models\User::TYPE_ADMIN)
                                        <a href="{{ route('admin.destinations.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl text-slate-600 hover:bg-primary-50 font-medium">
                                            <i class="fa-solid fa-map-location-dot"></i> Kelola Destinasi
                                        </a>
                                    @endif
                                @endif
                            @endif
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button class="w-full text-left px-4 py-3 rounded-xl text-rose-600 hover:bg-rose-50 font-bold mt-2">Keluar</button>
                            </form>
                        </div>
                    @endauth
                </div>
            </div>
        </div>
    </nav>

    <!-- Main Content Area -->
    <main class="mx-auto max-w-7xl w-full main-content py-6 md:py-10 flex-1">
        @yield('content')
    </main>

    <!-- Premium Footer -->
    <footer class="bg-slate-900 border-t border-slate-800 text-slate-400 mt-auto pt-16 pb-8">
        <div class="mx-auto max-w-7xl px-4">
            <div class="grid grid-cols-1 md:grid-cols-12 gap-8 mb-16">
                <!-- Branding column -->
                <div class="col-span-1 md:col-span-4">
                    <a href="{{ route('home') }}" class="flex items-center gap-2 mb-6">
                        <div class="bg-primary-600 p-2 rounded-xl">
                            <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        </div>
                        <span class="text-xl font-bold text-white tracking-tight">Tabibito<span class="text-secondary-500">.</span></span>
                    </a>
                    <p class="text-slate-400 text-sm leading-relaxed mb-6">Platform pemesanan tiket wisata terlengkap dan terpercaya di Jawa Tengah. Jelajahi keindahan alam dan warisan budaya Jawa Tengah bersama kemudahan pemesanan digital.</p>
                    
                    <!-- Social icons -->
                    <div class="flex gap-3">
                        <a href="https://instagram.com/" target="_blank" class="w-9 h-9 flex items-center justify-center rounded-xl bg-slate-800 text-slate-400 hover:bg-gradient-to-tr hover:from-primary-600 hover:to-primary-500 hover:text-white transition-all duration-300">
                            <i class="fa-brands fa-instagram text-lg"></i>
                        </a>
                        <a href="https://facebook.com/" class="w-9 h-9 flex items-center justify-center rounded-xl bg-slate-800 text-slate-400 hover:bg-gradient-to-tr hover:from-primary-600 hover:to-primary-500 hover:text-white transition-all duration-300">
                            <i class="fa-brands fa-facebook-f text-base"></i>
                        </a>
                        <a href="https://x.com/" class="w-9 h-9 flex items-center justify-center rounded-xl bg-slate-800 text-slate-400 hover:bg-gradient-to-tr hover:from-primary-600 hover:to-primary-500 hover:text-white transition-all duration-300">
                            <i class="fa-brands fa-x-twitter text-base"></i>
                        </a>
                    </div>
                </div>
                
                <!-- Quick links -->
                <div class="col-span-1 md:col-span-2">
                    <h4 class="font-bold text-white mb-6 uppercase text-[10px] tracking-widest">Jelajahi</h4>
                    <ul class="space-y-3.5 text-sm">
                        <li><a href="{{ route('home') }}" class="hover:text-primary-400 transition-colors">Beranda</a></li>
                        <li><a href="{{ route('destinations.index') }}" class="hover:text-primary-400 transition-colors">Semua Wisata</a></li>
                        <li><a href="{{ route('contact') }}" class="hover:text-primary-400 transition-colors">Hubungi Kami</a></li>
                    </ul>
                </div>

                <!-- Support links -->
                <div class="col-span-1 md:col-span-2">
                    <h4 class="font-bold text-white mb-6 uppercase text-[10px] tracking-widest">Informasi</h4>
                    <ul class="space-y-3.5 text-sm">
                        <li><a href="{{ route('contact') }}" class="hover:text-primary-400 transition-colors">Pusat Bantuan</a></li>
                        <li><a href="{{ route('terms') }}" class="hover:text-primary-400 transition-colors">Syarat & Ketentuan</a></li>
                        <li><a href="{{ route('privacy') }}" class="hover:text-primary-400 transition-colors">Kebijakan Privasi</a></li>
                    </ul>
                </div>

                <!-- Newsletter subscription -->
                <div class="col-span-1 md:col-span-4" x-data="{
                    email: '',
                    loading: false,
                    success: false,
                    error: '',
                    successMsg: '',
                    async subscribe() {
                        if (!this.email || !this.email.includes('@')) {
                            this.error = 'Masukkan alamat email yang valid.';
                            return;
                        }
                        this.loading = true;
                        this.error = '';
                        this.success = false;
                        try {
                            const res = await fetch('{{ route('newsletter.subscribe') }}', {
                                method: 'POST',
                                headers: {
                                    'Content-Type': 'application/json',
                                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                                    'Accept': 'application/json'
                                },
                                body: JSON.stringify({ email: this.email })
                            });
                            const data = await res.json();
                            if (res.ok && data.success) {
                                this.success = true;
                                this.successMsg = data.message;
                                this.email = '';
                            } else {
                                this.error = data.message || 'Gagal berlangganan. Coba lagi.';
                            }
                        } catch (e) {
                            this.error = 'Terjadi kesalahan jaringan. Coba lagi.';
                        } finally {
                            this.loading = false;
                        }
                    }
                }">
                    <h4 class="font-bold text-white mb-6 uppercase text-[10px] tracking-widest">Langganan Info Wisata</h4>
                    <p class="text-sm text-slate-400 mb-4 leading-relaxed">Dapatkan promo spesial tiket wisata dan panduan liburan Jawa Tengah langsung di kotak masuk Anda.</p>

                    <!-- Success State -->
                    <div x-show="success" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100" x-cloak class="flex items-start gap-3 bg-emerald-500/10 border border-emerald-500/20 rounded-xl px-4 py-3.5">
                        <div class="flex-shrink-0 w-8 h-8 rounded-full bg-emerald-500/20 flex items-center justify-center mt-0.5">
                            <i class="fa-solid fa-check text-emerald-400 text-sm"></i>
                        </div>
                        <div>
                            <p class="text-emerald-400 text-sm font-semibold" x-text="successMsg"></p>
                            <button @click="success = false" class="text-xs text-slate-500 hover:text-slate-300 mt-1.5 transition-colors">Tutup</button>
                        </div>
                    </div>

                    <!-- Form State -->
                    <div x-show="!success">
                        <form @submit.prevent="subscribe()" class="flex gap-2">
                            <input type="email" x-model="email" placeholder="Alamat email Anda" @keydown="error = ''" class="flex-1 bg-slate-800 border border-slate-700 rounded-xl px-4 py-2.5 text-sm text-white placeholder-slate-500 focus:ring-2 focus:ring-primary-500 focus:border-primary-500 transition-all" :class="error ? 'border-red-500/50 focus:ring-red-500' : 'border-slate-700'" required>
                            <button type="submit" :disabled="loading" class="bg-primary-600 hover:bg-primary-700 disabled:opacity-50 text-white font-bold px-4 py-2.5 rounded-xl text-sm transition-all hover:scale-105 active:scale-95">
                                <i x-show="!loading" class="fa-solid fa-paper-plane"></i>
                                <i x-show="loading" x-cloak class="fa-solid fa-spinner fa-spin"></i>
                            </button>
                        </form>
                        <p x-show="error" x-transition x-cloak class="text-red-400 text-xs mt-2 flex items-center gap-1.5"><i class="fa-solid fa-circle-exclamation"></i> <span x-text="error"></span></p>
                    </div>
                </div>
            </div>
            
            <div class="pt-8 border-t border-slate-800 flex flex-col md:flex-row justify-between items-center gap-6">
                <div class="text-center md:text-left">
                    <p class="text-slate-500 text-xs">© {{ date('Y') }} Tabibito Jateng. Dibuat dengan penuh dedikasi.</p>
                </div>
                <!-- Payment Partner Icons -->
                <div class="flex flex-wrap justify-center gap-4 text-slate-600 text-2xl">
                    <i class="fa-brands fa-cc-visa hover:text-slate-400 transition-colors" title="Visa"></i>
                    <i class="fa-brands fa-cc-mastercard hover:text-slate-400 transition-colors" title="Mastercard"></i>
                    <i class="fa-brands fa-cc-apple-pay hover:text-slate-400 transition-colors" title="Apple Pay"></i>
                    <i class="fa-brands fa-cc-paypal hover:text-slate-400 transition-colors" title="Paypal"></i>
                    <span class="text-xs font-bold text-slate-500 self-center px-2 py-1 rounded bg-slate-800 uppercase tracking-widest"><i class="fa-solid fa-shield-halved mr-1"></i> Midtrans Secure</span>
                </div>
            </div>
        </div>
    </footer>

    @if(session('success'))
        <script>
            Swal.fire({
                icon: 'success',
                title: 'Berhasil',
                text: @json(session('success')),
                timer: 2500,
                showConfirmButton: false,
                customClass: {
                    popup: 'rounded-3xl border border-slate-100 shadow-xl'
                }
            });
        </script>
    @endif
    @if($errors->any())
        <script>
            Swal.fire({
                icon: 'error',
                title: 'Oops',
                text: @json($errors->first()),
                customClass: {
                    popup: 'rounded-3xl border border-slate-100 shadow-xl'
                }
            });
        </script>
    @endif
    
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
                    // Remove default/inactive colors and shadows
                    btn.classList.remove('bg-white', 'bg-white/80', 'bg-white/90', 'text-slate-400', 'hover:text-primary-600', 'hover:text-rose-500', 'shadow-slate-200');
                    // Add active wishlist colors (rose)
                    btn.classList.add('bg-rose-500', 'text-white', 'shadow-rose-200');
                    svg.classList.replace('fill-none', 'fill-current');
                    Swal.fire({
                        icon: 'success',
                        title: 'Ditambahkan ke Wishlist',
                        timer: 1500,
                        showConfirmButton: false,
                        customClass: { popup: 'rounded-2xl' }
                    });
                } else {
                    // Remove active colors
                    btn.classList.remove('bg-rose-500', 'bg-primary-600', 'text-white', 'shadow-rose-200', 'shadow-primary-200');
                    // Add default/inactive colors
                    btn.classList.add('bg-white', 'text-slate-400', 'hover:text-rose-500', 'shadow-slate-200');
                    svg.classList.replace('fill-current', 'fill-none');
                    Swal.fire({
                        icon: 'info',
                        title: 'Dihapus dari Wishlist',
                        timer: 1500,
                        showConfirmButton: false,
                        customClass: { popup: 'rounded-2xl' }
                    });
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
    @stack('modals')
</body>
</html>

