@extends('layouts.app')

@section('content')
<div class="max-w-6xl mx-auto px-4 md:px-0 py-6">
    <div class="bg-white rounded-[2.5rem] border border-slate-100 shadow-xl shadow-slate-200/40 overflow-hidden relative">
        <div class="grid lg:grid-cols-12 min-h-[600px] items-stretch">
            
            <!-- Left Side: Form Section (Col span 7 on large screens) -->
            <div class="lg:col-span-7 p-8 md:p-14 flex flex-col justify-center relative">
                <!-- Sparkle Background -->
                <div class="absolute top-0 left-0 w-32 h-32 bg-primary-50 rounded-full -ml-16 -mt-16 opacity-40"></div>
                
                <div class="max-w-md w-full mx-auto relative z-10 space-y-8">
                    <!-- Heading -->
                    <div class="text-center lg:text-left space-y-2">
                        <span class="px-3 py-1 rounded-full bg-primary-50 text-primary-700 text-[10px] font-black uppercase tracking-wider">Mitra Wisata</span>
                        <h1 class="text-3xl font-black text-slate-900 tracking-tight">Gabung sebagai Mitra</h1>
                        <p class="text-xs text-slate-400 font-bold uppercase tracking-wider">Langkah 1: Lengkapi Kredensial Akun Anda</p>
                    </div>

                    <!-- Registration Form -->
                    <form method="POST" action="{{ route('owner.register.step1.store') }}" class="space-y-5" id="owner-reg-step1">
                        @csrf
                        
                        <!-- Input Username -->
                        <div class="space-y-2">
                            <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest ml-1">Username Pengelola</label>
                            <div class="relative group">
                                <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-slate-400 group-focus-within:text-primary-600 transition-colors">
                                    <i class="fa-solid fa-user-tag text-sm"></i>
                                </div>
                                <input type="text" name="username" id="username" value="{{ old('username') }}" required placeholder="Contoh: candisejahtera" 
                                       class="w-full bg-slate-50 border border-slate-100 rounded-2xl pl-11 pr-4 py-4 text-slate-800 font-bold focus:ring-2 focus:ring-primary-500/20 focus:border-primary-500 outline-none transition-all placeholder:text-slate-400/80">
                            </div>
                        </div>

                        <!-- Input Email -->
                        <div class="space-y-2">
                            <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest ml-1">Email Resmi Pengelola</label>
                            <div class="relative group">
                                <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-slate-400 group-focus-within:text-primary-600 transition-colors">
                                    <i class="fa-regular fa-envelope text-sm"></i>
                                </div>
                                <input type="email" name="email" id="email" value="{{ old('email') }}" required placeholder="Contoh: info@candisejahtera.com" 
                                       class="w-full bg-slate-50 border border-slate-100 rounded-2xl pl-11 pr-4 py-4 text-slate-800 font-bold focus:ring-2 focus:ring-primary-500/20 focus:border-primary-500 outline-none transition-all placeholder:text-slate-400/80">
                            </div>
                        </div>

                        <!-- Input Password -->
                        <div class="space-y-2">
                            <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest ml-1">Kata Sandi</label>
                            <div class="relative group" x-data="{ show: false }">
                                <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-slate-400 group-focus-within:text-primary-600 transition-colors">
                                    <i class="fa-solid fa-lock text-sm"></i>
                                </div>
                                <input :type="show ? 'text' : 'password'" name="password" id="password" required placeholder="••••••••" 
                                       class="w-full bg-slate-50 border border-slate-100 rounded-2xl pl-11 pr-12 py-4 text-slate-800 font-bold focus:ring-2 focus:ring-primary-500/20 focus:border-primary-500 outline-none transition-all placeholder:text-slate-400/80">
                                <button type="button" @click="show = !show" class="absolute inset-y-0 right-0 pr-4 flex items-center text-slate-400 hover:text-slate-600">
                                    <i class="fa-solid" :class="show ? 'fa-eye-slash' : 'fa-eye'"></i>
                                </button>
                            </div>
                        </div>

                        <!-- Input Confirm Password -->
                        <div class="space-y-2">
                            <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest ml-1">Konfirmasi Kata Sandi</label>
                            <div class="relative group" x-data="{ show: false }">
                                <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-slate-400 group-focus-within:text-primary-600 transition-colors">
                                    <i class="fa-solid fa-shield text-sm"></i>
                                </div>
                                <input :type="show ? 'text' : 'password'" name="password_confirmation" id="password_confirmation" required placeholder="••••••••" 
                                       class="w-full bg-slate-50 border border-slate-100 rounded-2xl pl-11 pr-12 py-4 text-slate-800 font-bold focus:ring-2 focus:ring-primary-500/20 focus:border-primary-500 outline-none transition-all placeholder:text-slate-400/80">
                                <button type="button" @click="show = !show" class="absolute inset-y-0 right-0 pr-4 flex items-center text-slate-400 hover:text-slate-600">
                                    <i class="fa-solid" :class="show ? 'fa-eye-slash' : 'fa-eye'"></i>
                                </button>
                            </div>
                        </div>

                        <!-- Action Submit Button -->
                        <button type="submit" class="w-full bg-primary-600 hover:bg-primary-700 text-white py-4 md:py-4.5 rounded-2xl shadow-xl shadow-primary-600/30 transition-all transform hover:-translate-y-1 active:translate-y-0 text-sm md:text-base font-extrabold uppercase tracking-wider flex items-center justify-center gap-2.5">
                            Langkah Selanjutnya <i class="fa-solid fa-arrow-right text-base animate-pulse"></i>
                        </button>
                    </form>

                    <!-- Redirection -->
                    <p class="text-center text-xs text-slate-500 font-semibold pt-4">
                        Sudah terdaftar sebagai pengelola? 
                        <a href="{{ route('login') }}" class="text-primary-600 font-extrabold hover:underline">Masuk di sini</a>
                    </p>
                </div>
            </div>
            
            <!-- Right Side: Visual Teaser (Col span 5, Hidden on mobile) -->
            <div class="hidden lg:col-span-5 bg-gradient-to-tr from-slate-950 via-slate-900 to-primary-950 p-12 lg:flex flex-col justify-between text-white relative overflow-hidden">
                <!-- Glowing Blurred Vector blobs -->
                <div class="absolute top-0 left-0 w-72 h-72 bg-primary-600/10 rounded-full blur-3xl -ml-20 -mt-20"></div>
                <div class="absolute bottom-0 right-0 w-72 h-72 bg-secondary-500/10 rounded-full blur-3xl -mr-20 -mb-20"></div>
                
                <div class="relative z-10 space-y-10 my-auto">
                    <!-- Welcoming Banner -->
                    <div class="space-y-4">
                        <h2 class="text-3xl font-black leading-tight tracking-tight">Kembangkan Bisnis Wisata Anda Bersama Tabibito</h2>
                        <p class="text-slate-400 text-sm leading-relaxed font-semibold">Bawa tempat wisata Anda menjangkau jutaan pelancong domestik dan mancanegara dengan digitalisasi tiket modern kami.</p>
                    </div>

                    <!-- Bullet Info Blocks -->
                    <div class="space-y-5">
                        <div class="flex items-center gap-4">
                            <div class="w-10 h-10 rounded-xl bg-white/10 flex items-center justify-center text-primary-400 shrink-0">
                                <i class="fa-solid fa-chart-line"></i>
                            </div>
                            <div>
                                <h4 class="text-xs font-black uppercase tracking-wider">Performa Penjualan Live</h4>
                                <p class="text-[11px] text-slate-400 font-semibold leading-normal">Pantau analitik, sisa kuota, dan total pendapatan secara instan di dashboard.</p>
                            </div>
                        </div>

                        <div class="flex items-center gap-4">
                            <div class="w-10 h-10 rounded-xl bg-white/10 flex items-center justify-center text-emerald-400 shrink-0">
                                <i class="fa-solid fa-cash-register"></i>
                            </div>
                            <div>
                                <h4 class="text-xs font-black uppercase tracking-wider">Pencairan Dana Fleksibel</h4>
                                <p class="text-[11px] text-slate-400 font-semibold leading-normal">Tarik pendapatan Anda dengan pengajuan pencairan dana yang mudah dan transparan.</p>
                            </div>
                        </div>

                        <div class="flex items-center gap-4">
                            <div class="w-10 h-10 rounded-xl bg-white/10 flex items-center justify-center text-amber-400 shrink-0">
                                <i class="fa-solid fa-mobile-screen-button"></i>
                            </div>
                            <div>
                                <h4 class="text-xs font-black uppercase tracking-wider">Aplikasi QR Scanner</h4>
                                <p class="text-[11px] text-slate-400 font-semibold leading-normal">Verifikasi boarding pass wisatawan dengan scanner web internal dalam hitungan detik.</p>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Footer Info -->
                <p class="text-center text-[10px] text-slate-500 font-semibold relative z-10 pt-4 border-t border-white/5">
                    Tabibito Jawa Tengah © 2026. Seluruh Transaksi Dilindungi.
                </p>
            </div>
            
        </div>
    </div>
</div>
@endsection