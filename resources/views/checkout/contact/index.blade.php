@extends('layouts.app')

@section('content')
<!-- Breadcrumbs -->
<nav class="mb-8 flex items-center gap-2 text-sm">
    <a href="{{ route('home') }}" class="text-slate-400 hover:text-primary-600 transition-colors">Beranda</a>
    <svg class="w-4 h-4 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
    <span class="text-slate-900 font-bold">Hubungi Kami</span>
</nav>

<div class="grid gap-10 lg:grid-cols-2 items-start">
    <!-- Contact Info & CTA -->
    <div class="space-y-8">
        <div class="bg-white rounded-[2.5rem] p-10 border border-slate-100 shadow-sm relative overflow-hidden">
            <div class="absolute top-0 right-0 w-32 h-32 bg-primary-50 rounded-full -mr-16 -mt-16 opacity-50"></div>
            
            <h1 class="text-4xl font-black text-slate-900 mb-6 relative">Ada Pertanyaan?</h1>
            <p class="text-slate-500 leading-relaxed mb-10 relative">Kami siap membantu Anda. Jangan ragu untuk mengirimkan pesan, kritik, atau saran untuk layanan kami.</p>
            
            <div class="space-y-6 relative">
                <div class="flex items-center gap-5 group">
                    <div class="w-14 h-14 rounded-2xl bg-primary-50 flex items-center justify-center text-primary-600 group-hover:bg-primary-600 group-hover:text-white transition-all duration-300">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                    </div>
                    <div>
                        <p class="text-xs text-slate-400 font-bold uppercase tracking-widest mb-1">Email Resmi</p>
                        <p class="font-bold text-slate-900">support@tabibito.id</p>
                    </div>
                </div>
                
                <div class="flex items-center gap-5 group">
                    <div class="w-14 h-14 rounded-2xl bg-primary-50 flex items-center justify-center text-primary-600 group-hover:bg-primary-600 group-hover:text-white transition-all duration-300">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                    </div>
                    <div>
                        <p class="text-xs text-slate-400 font-bold uppercase tracking-widest mb-1">Kantor Pusat</p>
                        <p class="font-bold text-slate-900">Semarang, Jawa Tengah</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Owner CTA -->
        <div class="bg-primary-950 rounded-[2.5rem] p-10 text-white relative overflow-hidden group">
            <div class="absolute bottom-0 right-0 opacity-10 group-hover:scale-110 transition-transform duration-500">
                <svg class="w-48 h-48" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2L4.5 20.29l.71.71L12 18l6.79 3 .71-.71z"/></svg>
            </div>
            <h2 class="text-2xl font-black mb-4 relative">Punya Tempat Wisata?</h2>
            <p class="text-primary-100 opacity-70 mb-8 leading-relaxed relative">Daftarkan destinasi Anda sekarang dan jangkau jutaan wisatawan di seluruh Indonesia.</p>
            <a href="{{ route('owner.register.step1') }}" class="inline-flex items-center gap-3 bg-white text-primary-950 px-8 py-4 rounded-2xl font-black shadow-xl transition-all hover:scale-105 active:scale-95 relative">
                Ajukan Sekarang
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
            </a>
        </div>
    </div>

    <!-- Contact Form -->
    <div class="bg-white rounded-[2.5rem] p-10 md:p-12 border border-slate-100 shadow-xl shadow-slate-200/50">
        <h2 class="text-2xl font-black text-slate-900 mb-8">Kirim Pesan</h2>
        
        @if(session('success'))
            <div class="bg-emerald-50 border border-emerald-100 text-emerald-700 p-6 mb-8 rounded-[1.5rem] flex items-center gap-4 animate-bounce">
                <svg class="w-6 h-6 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                <p class="font-bold">{{ session('success') }}</p>
            </div>
        @endif

        <form action="{{ route('contact.store') }}" method="POST" class="space-y-6">
            @csrf
            <div>
                <label class="block text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-3 ml-1">Nama Anda</label>
                <input type="text" name="name" id="name" placeholder="John Doe" class="w-full bg-slate-50 border-none rounded-2xl px-6 py-4 text-slate-800 font-bold focus:ring-2 focus:ring-primary-500/20 transition-all" required>
            </div>
            
            <div>
                <label class="block text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-3 ml-1">Email</label>
                <input type="email" name="email" id="email" placeholder="john@example.com" class="w-full bg-slate-50 border-none rounded-2xl px-6 py-4 text-slate-800 font-bold focus:ring-2 focus:ring-primary-500/20 transition-all" required>
            </div>
            
            <div>
                <label class="block text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-3 ml-1">Pesan</label>
                <textarea name="message" id="message" rows="5" placeholder="Tuliskan pesan Anda di sini..." class="w-full bg-slate-50 border-none rounded-2xl px-6 py-4 text-slate-800 font-bold focus:ring-2 focus:ring-primary-500/20 transition-all resize-none" required></textarea>
            </div>
            
            <button type="submit" class="w-full bg-primary-600 hover:bg-primary-700 text-white font-black py-5 rounded-2xl shadow-xl shadow-primary-600/30 transition-all transform hover:-translate-y-1">
                Kirim Pesan Sekarang
            </button>
        </form>
    </div>
</div>
@endsection
