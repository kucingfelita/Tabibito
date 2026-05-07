@extends('layouts.app')

@section('content')
    <!-- Breadcrumbs -->
    <nav class="mb-8 flex items-center gap-2 text-sm">
        <a href="{{ route('home') }}" class="text-slate-400 hover:text-primary-600 transition-colors">Beranda</a>
        <svg class="w-4 h-4 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
        <a href="{{ route('destinations.index') }}" class="text-slate-400 hover:text-primary-600 transition-colors">Eksplor Wisata</a>
        <svg class="w-4 h-4 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
        <a href="{{ route('destinations.show', $ticket->destination) }}" class="text-slate-400 hover:text-primary-600 transition-colors truncate max-w-[100px] md:max-w-none block">{{ $ticket->destination->name }}</a>
        <svg class="w-4 h-4 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
        <span class="text-slate-900 font-bold truncate">{{ $ticket->name }}</span>
    </nav>

    <div class="grid gap-10 lg:grid-cols-[1.8fr_1fr]">
        <!-- Main Content -->
        <div class="space-y-8">
            <div class="bg-white rounded-[2.5rem] p-8 md:p-12 border border-slate-100 shadow-sm">
                <div class="flex items-center gap-4 mb-8">
                    <div class="w-14 h-14 rounded-2xl bg-primary-600 flex items-center justify-center text-white shadow-lg shadow-primary-200">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 5v2m0 4v2m0 4v2M5 5a2 2 0 00-2 2v3a2 2 0 110 4v3a2 2 0 002 2h14a2 2 0 002-2v-3a2 2 0 110-4V7a2 2 0 00-2-2H5z"/></svg>
                    </div>
                    <div>
                        <h1 class="text-3xl font-black text-slate-900">{{ $ticket->name }}</h1>
                        <p class="text-slate-400 font-medium">{{ $ticket->destination->name }} • {{ $ticket->destination->city }}</p>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-12">
                    <div class="bg-slate-50 rounded-3xl p-6 border border-slate-100">
                        <p class="text-xs text-slate-400 font-bold uppercase tracking-widest mb-2">Harga Per Orang</p>
                        <p class="text-3xl font-black text-primary-600">
                            <span class="text-sm font-medium">Rp</span> {{ number_format($ticket->price, 0, ',', '.') }}
                        </p>
                    </div>
                    <div class="bg-slate-50 rounded-3xl p-6 border border-slate-100">
                        <p class="text-xs text-slate-400 font-bold uppercase tracking-widest mb-2">Kuota Tersedia</p>
                        <p class="text-3xl font-black text-slate-800">
                            {{ $ticket->daily_quota }} <span class="text-sm font-medium text-slate-400">Tiket / Hari</span>
                        </p>
                    </div>
                </div>

                <div class="space-y-8">
                    <div>
                        <h2 class="text-lg font-bold text-slate-900 mb-4 flex items-center gap-2">
                            <svg class="w-5 h-5 text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                            Manfaat & Fasilitas
                        </h2>
                        <p class="text-slate-600 leading-relaxed bg-slate-50 rounded-2xl p-6 border border-slate-100">{{ $ticket->benefit }}</p>
                    </div>

                    <div>
                        <h2 class="text-lg font-bold text-slate-900 mb-4 flex items-center gap-2">
                            <svg class="w-5 h-5 text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                            Informasi Penting
                        </h2>
                        <div class="grid gap-4">
                            <div class="flex gap-4 p-4 rounded-2xl border border-slate-100">
                                <div class="w-10 h-10 shrink-0 rounded-xl bg-amber-50 flex items-center justify-center text-amber-600">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                </div>
                                <div>
                                    <p class="text-sm font-bold text-slate-900">Jam Operasional</p>
                                    <p class="text-xs text-slate-500">{{ $ticket->destination->open_time }} - {{ $ticket->destination->close_time }} WIB</p>
                                </div>
                            </div>
                            <div class="flex gap-4 p-4 rounded-2xl border border-slate-100">
                                <div class="w-10 h-10 shrink-0 rounded-xl bg-emerald-50 flex items-center justify-center text-emerald-600">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/></svg>
                                </div>
                                <div>
                                    <p class="text-sm font-bold text-slate-900">Konfirmasi Instan</p>
                                    <p class="text-xs text-slate-500">Tiket akan langsung dikirim ke email Anda setelah pembayaran berhasil.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Sidebar / Booking Summary -->
        <aside>
            <div class="sticky top-24 bg-white rounded-[2rem] border border-slate-100 p-8 shadow-lg shadow-slate-200/50">
                <h3 class="text-xl font-bold text-slate-900 mb-8">Ringkasan Tiket</h3>
                
                <div class="space-y-6 mb-8">
                    <div class="flex items-start gap-4">
                        <div class="shrink-0 w-12 h-12 rounded-2xl overflow-hidden bg-slate-100">
                            @if($ticket->destination->images->first()?->image_path)
                                <img src="{{ asset('storage/' . $ticket->destination->images->first()->image_path) }}" class="w-full h-full object-cover">
                            @endif
                        </div>
                        <div>
                            <p class="text-sm font-bold text-slate-900 leading-tight mb-1">{{ $ticket->destination->name }}</p>
                            <p class="text-xs text-slate-500">{{ $ticket->destination->city }}</p>
                        </div>
                    </div>
                    
                    <div class="pt-6 border-t border-slate-50">
                        <div class="flex justify-between items-center mb-2">
                            <span class="text-sm text-slate-500 font-medium">Tipe Tiket</span>
                            <span class="text-sm text-slate-900 font-bold">{{ $ticket->name }}</span>
                        </div>
                        <div class="flex justify-between items-center mb-6">
                            <span class="text-sm text-slate-500 font-medium">Ketersediaan</span>
                            <span class="text-sm text-emerald-600 font-bold italic">Tersedia Hari Ini</span>
                        </div>
                        
                        <div class="p-4 rounded-2xl bg-primary-50 border border-primary-100">
                            <div class="flex justify-between items-end">
                                <span class="text-xs text-primary-700 font-bold uppercase tracking-widest mb-1">Total Harga</span>
                                <p class="text-2xl font-black text-primary-700">
                                    <span class="text-xs font-medium">Rp</span> {{ number_format($ticket->price, 0, ',', '.') }}
                                </p>
                            </div>
                        </div>
                    </div>
                </div>

                <a href="{{ route('checkout.show', $ticket) }}" class="btn-premium flex items-center justify-center w-full bg-primary-600 hover:bg-primary-700 text-white font-bold py-5 rounded-2xl shadow-xl shadow-primary-600/30">
                    Beli Tiket Sekarang
                </a>
                
                <p class="text-center text-[10px] text-slate-400 mt-6 font-medium leading-relaxed">
                    Dengan menekan tombol di atas, Anda menyetujui <br> 
                    <a href="#" class="underline hover:text-primary-600">Syarat & Ketentuan</a> yang berlaku.
                </p>
            </div>
        </aside>
    </div>
@endsection