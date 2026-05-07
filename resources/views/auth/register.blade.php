@extends('layouts.app')

@section('content')
    <div class="min-h-[70vh] flex items-center justify-center py-12 px-4 sm:px-6 lg:px-8">
        <div class="max-w-md w-full">
            <div class="bg-white rounded-[2.5rem] p-10 md:p-12 border border-slate-100 shadow-xl shadow-slate-200/50">
                <div class="text-center mb-10">
                    <h1 class="text-3xl font-black text-slate-900 mb-2">Buat Akun</h1>
                    <p class="text-sm text-slate-500 font-medium">Mulai jelajahi wisata Jawa Tengah sekarang.</p>
                </div>

                <form method="POST" action="{{ route('register.store') }}" class="space-y-5">
                    @csrf
                    <div>
                        <label class="block text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-2 ml-1">Nama Lengkap</label>
                        <input name="name" value="{{ old('name') }}" placeholder="Masukkan nama Anda" class="w-full bg-slate-50 border-none rounded-2xl px-4 py-4 text-slate-800 font-bold focus:ring-2 focus:ring-primary-500/20 transition-all">
                    </div>

                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-2 ml-1">Username</label>
                            <input name="username" value="{{ old('username') }}" placeholder="username" class="w-full bg-slate-50 border-none rounded-2xl px-4 py-4 text-slate-800 font-bold focus:ring-2 focus:ring-primary-500/20 transition-all text-sm">
                        </div>
                        <div>
                            <label class="block text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-2 ml-1">No HP</label>
                            <input name="phone" value="{{ old('phone') }}" placeholder="0812..." class="w-full bg-slate-50 border-none rounded-2xl px-4 py-4 text-slate-800 font-bold focus:ring-2 focus:ring-primary-500/20 transition-all text-sm">
                        </div>
                    </div>

                    <div>
                        <label class="block text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-2 ml-1">Password</label>
                        <input type="password" name="password" placeholder="••••••••" class="w-full bg-slate-50 border-none rounded-2xl px-4 py-4 text-slate-800 font-bold focus:ring-2 focus:ring-primary-500/20 transition-all">
                    </div>

                    <div>
                        <label class="block text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-2 ml-1">Konfirmasi Password</label>
                        <input type="password" name="password_confirmation" placeholder="••••••••" class="w-full bg-slate-50 border-none rounded-2xl px-4 py-4 text-slate-800 font-bold focus:ring-2 focus:ring-primary-500/20 transition-all">
                    </div>

                    <button class="w-full bg-primary-600 hover:bg-primary-700 text-white font-bold py-4 rounded-2xl shadow-xl shadow-primary-600/30 transition-all transform hover:-translate-y-1 mt-4">
                        Daftar Sekarang
                    </button>
                </form>

                <div class="relative my-8">
                    <div class="absolute inset-0 flex items-center"><div class="w-full border-t border-slate-100"></div></div>
                    <div class="relative flex justify-center text-xs uppercase tracking-widest"><span class="bg-white px-4 text-slate-400 font-bold">Atau</span></div>
                </div>

                <a href="{{ route('google.redirect') }}" class="w-full flex items-center justify-center gap-3 bg-white border border-slate-200 text-slate-700 font-bold py-4 rounded-2xl hover:bg-slate-50 transition-all">
                    <svg class="w-5 h-5" viewBox="0 0 24 24"><path fill="currentColor" d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z"/><path fill="currentColor" d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z"/><path fill="currentColor" d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.07H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.93l2.85-2.22.81-.62z"/><path fill="currentColor" d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.07l3.66 2.84c.87-2.6 3.3-4.53 6.16-4.53z"/></svg>
                    Google
                </a>

                <p class="mt-8 text-center text-sm text-slate-500 font-medium">
                    Sudah punya akun? 
                    <a href="{{ route('login') }}" class="text-primary-600 font-bold hover:underline">Login disini</a>
                </p>
            </div>
        </div>
    </div>
@endsection
