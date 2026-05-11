@extends('layouts.app')

@section('content')
    <div class="min-h-[70vh] flex items-center justify-center py-12 px-4 sm:px-6 lg:px-8">
        <div class="max-w-md w-full">
            <div class="bg-white rounded-[2.5rem] p-10 md:p-12 border border-slate-100 shadow-xl shadow-slate-200/50">
                <div class="text-center mb-10">
                    <h1 class="text-3xl font-black text-slate-900 mb-2">Buat Password</h1>
                    <p class="text-sm text-slate-500 font-medium">Satu langkah lagi. Buat password Anda untuk login manual nanti.</p>
                </div>

                <form method="POST" action="{{ route('google.set-password.store') }}" class="space-y-5">
                    @csrf
                    <div>
                        <label class="block text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-2 ml-1">Password</label>
                        <input type="password" name="password" placeholder="Minimal 8 karakter" class="w-full bg-slate-50 border-none rounded-2xl px-4 py-4 text-slate-800 font-bold focus:ring-2 focus:ring-primary-500/20 transition-all" required minlength="8">
                    </div>

                    <div>
                        <label class="block text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-2 ml-1">Konfirmasi Password</label>
                        <input type="password" name="password_confirmation" placeholder="Ulangi password" class="w-full bg-slate-50 border-none rounded-2xl px-4 py-4 text-slate-800 font-bold focus:ring-2 focus:ring-primary-500/20 transition-all" required minlength="8">
                    </div>

                    <button class="w-full bg-primary-600 hover:bg-primary-700 text-white font-bold py-4 rounded-2xl shadow-xl shadow-primary-600/30 transition-all transform hover:-translate-y-1 mt-4">
                        Simpan Password & Mulai
                    </button>
                </form>
            </div>
        </div>
    </div>
@endsection
