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
                        <h1 class="text-3xl font-black text-slate-900 tracking-tight">Selamat Datang Kembali!</h1>
                        <p class="text-xs text-slate-400 font-bold uppercase tracking-wider">Silakan masuk untuk melanjutkan petualangan Anda</p>
                    </div>

                    <!-- Login Form -->
                    <form method="POST" action="{{ route('login.store') }}" class="space-y-5" id="login-form">
                        @csrf
                        
                        <!-- Input Username / Email -->
                        <div class="space-y-2">
                            <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest ml-1">Username atau Email</label>
                            <div class="relative group">
                                <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-slate-400 group-focus-within:text-primary-600 transition-colors">
                                    <i class="fa-regular fa-envelope text-sm"></i>
                                </div>
                                <input type="text" name="login" value="{{ old('login') }}" required placeholder="Masukkan username atau email Anda" 
                                       class="w-full bg-slate-50 border border-slate-100 rounded-2xl pl-11 pr-4 py-4 text-slate-800 font-bold focus:ring-2 focus:ring-primary-500/20 focus:border-primary-500 outline-none transition-all placeholder:text-slate-400/80">
                            </div>
                        </div>

                        <!-- Input Password -->
                        <div class="space-y-2">
                            <div class="flex justify-between items-center px-1">
                                <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest">Kata Sandi</label>
                            </div>
                            <div class="relative group" x-data="{ show: false }">
                                <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-slate-400 group-focus-within:text-primary-600 transition-colors">
                                    <i class="fa-solid fa-lock text-sm"></i>
                                </div>
                                <input :type="show ? 'text' : 'password'" name="password" required placeholder="••••••••" 
                                       class="w-full bg-slate-50 border border-slate-100 rounded-2xl pl-11 pr-12 py-4 text-slate-800 font-bold focus:ring-2 focus:ring-primary-500/20 focus:border-primary-500 outline-none transition-all placeholder:text-slate-400/80">
                                <button type="button" @click="show = !show" class="absolute inset-y-0 right-0 pr-4 flex items-center text-slate-400 hover:text-slate-600">
                                    <i class="fa-solid" :class="show ? 'fa-eye-slash' : 'fa-eye'"></i>
                                </button>
                            </div>
                        </div>

                        <!-- Action Submit Button -->
                        <button type="submit" class="w-full bg-primary-600 hover:bg-primary-700 text-white py-4 md:py-4.5 rounded-2xl shadow-xl shadow-primary-600/30 transition-all transform hover:-translate-y-1 active:translate-y-0 text-sm md:text-base font-extrabold uppercase tracking-wider flex items-center justify-center gap-2.5">
                            <i class="fa-solid fa-arrow-right-to-bracket text-base"></i> Masuk Sekarang
                        </button>
                    </form>

                    <!-- Divider -->
                    <div class="relative py-2">
                        <div class="absolute inset-0 flex items-center"><div class="w-full border-t border-slate-100"></div></div>
                        <div class="relative flex justify-center text-[10px] uppercase tracking-widest"><span class="bg-white px-4 text-slate-400 font-bold">Atau Masuk Melalui</span></div>
                    </div>

                    <!-- Social Google -->
                    <a href="{{ route('google.redirect') }}" class="w-full flex items-center justify-center gap-3 bg-white border border-slate-200 text-slate-700 py-4 md:py-4.5 rounded-2xl hover:bg-slate-50 transition-all active:scale-95 shadow-sm text-sm md:text-base font-extrabold">
                        <svg class="w-5 h-5 shrink-0" viewBox="0 0 24 24"><path fill="currentColor" d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z"/><path fill="currentColor" d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z"/><path fill="currentColor" d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.07H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.93l2.85-2.22.81-.62z"/><path fill="currentColor" d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.07l3.66 2.84c.87-2.6 3.3-4.53 6.16-4.53z"/></svg>
                        <span>Hubungkan Akun Google</span>
                    </a>

                    <!-- Redirection -->
                    <p class="text-center text-xs text-slate-500 font-semibold pt-4">
                        Belum memiliki akun Tabibito? 
                        <a href="{{ route('register') }}" class="text-primary-600 font-extrabold hover:underline">Daftar sekarang</a>
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
                        <h2 class="text-3xl font-black leading-tight tracking-tight">Jelajahi Indahnya Jawa Tengah bersama Tabibito.</h2>
                        <p class="text-slate-400 text-sm leading-relaxed font-semibold">Kami menghadirkan akses instan untuk pemesanan tiket wisata terbaik dengan mudah, cepat, dan terjamin aman.</p>
                    </div>

                    <!-- Bullet Info Blocks -->
                    <div class="space-y-5">
                        <div class="flex items-center gap-4">
                            <div class="w-10 h-10 rounded-xl bg-white/10 flex items-center justify-center text-primary-400 shrink-0">
                                <i class="fa-solid fa-ticket-simple"></i>
                            </div>
                            <div>
                                <h4 class="text-xs font-black uppercase tracking-wider">E-Tiket Instan</h4>
                                <p class="text-[11px] text-slate-400 font-semibold leading-normal">Tiket terbit seketika di email dan dashboard Anda.</p>
                            </div>
                        </div>

                        <div class="flex items-center gap-4">
                            <div class="w-10 h-10 rounded-xl bg-white/10 flex items-center justify-center text-primary-400 shrink-0">
                                <i class="fa-solid fa-shield-halved"></i>
                            </div>
                            <div>
                                <h4 class="text-xs font-black uppercase tracking-wider">Secure Payment Gateway</h4>
                                <p class="text-[11px] text-slate-400 font-semibold leading-normal">Transaksi aman didukung penuh oleh gateway Midtrans.</p>
                            </div>
                        </div>

                        <div class="flex items-center gap-4">
                            <div class="w-10 h-10 rounded-xl bg-white/10 flex items-center justify-center text-primary-400 shrink-0">
                                <i class="fa-solid fa-face-smile"></i>
                            </div>
                            <div>
                                <h4 class="text-xs font-black uppercase tracking-wider">24/7 Layanan Customer</h4>
                                <p class="text-[11px] text-slate-400 font-semibold leading-normal">Ada pertanyaan? Customer Service kami siap siaga membantu.</p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="text-center text-[10px] text-slate-500 font-bold uppercase tracking-wider relative z-10 pt-8 border-t border-white/5">
                    © {{ date('Y') }} Tabibito Jateng. Secure Platform.
                </div>
            </div>
            
        </div>
    </div>
</div>

@push('scripts')
<script>
    document.getElementById('login-form').addEventListener('submit', function() {
        const btn = this.querySelector('button[type="submit"]');
        if (btn) {
            setTimeout(() => {
                btn.disabled = true;
                btn.innerHTML = '<i class="fa-solid fa-spinner animate-spin"></i> Menyambungkan...';
            }, 10);
        }
    });
</script>
@endpush
@endsection
