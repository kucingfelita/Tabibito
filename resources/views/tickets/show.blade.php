@extends('layouts.app')

@section('content')
    <!-- Breadcrumbs -->
    <nav class="mb-8 flex items-center gap-2.5 text-xs font-semibold px-4 md:px-0">
        <a href="{{ route('home') }}" class="text-slate-400 hover:text-primary-600 transition-colors flex items-center gap-1.5"><i class="fa-solid fa-house"></i> Beranda</a>
        <i class="fa-solid fa-chevron-right text-slate-300 text-[10px]"></i>
        <a href="{{ route('destinations.index') }}" class="text-slate-400 hover:text-primary-600 transition-colors">Eksplor Wisata</a>
        <i class="fa-solid fa-chevron-right text-slate-300 text-[10px]"></i>
        <a href="{{ route('destinations.show', $ticket->destination) }}" class="text-slate-400 hover:text-primary-600 transition-colors truncate max-w-[100px] md:max-w-none">{{ $ticket->destination->name }}</a>
        <i class="fa-solid fa-chevron-right text-slate-300 text-[10px]"></i>
        <span class="text-slate-900 font-bold truncate">{{ $ticket->name }}</span>
    </nav>

    <div class="grid gap-10 lg:grid-cols-[1.8fr_1fr] px-4 md:px-0">
        <!-- Main Content -->
        <div class="space-y-8">
            <div class="bg-white rounded-[2.5rem] p-8 md:p-12 border border-slate-100/80 shadow-sm relative overflow-hidden">
                <!-- Premium Background Deco -->
                <div class="absolute top-0 right-0 w-36 h-36 bg-gradient-to-bl from-primary-500/10 to-transparent rounded-full blur-xl pointer-events-none"></div>

                <div class="flex items-center gap-4 mb-8">
                    <div class="w-14 h-14 rounded-2xl bg-gradient-to-tr from-primary-600 to-primary-500 flex items-center justify-center text-white shadow-lg shadow-primary-200">
                        <i class="fa-solid fa-ticket text-2xl"></i>
                    </div>
                    <div>
                        <h1 class="text-2xl md:text-3xl font-black text-slate-900 tracking-tight">{{ $ticket->name }}</h1>
                        <p class="text-slate-400 font-semibold text-xs md:text-sm mt-0.5"><i class="fa-solid fa-location-dot text-secondary-500 mr-1"></i> {{ $ticket->destination->name }} • {{ $ticket->destination->city }}</p>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-10">
                    <div class="bg-slate-50 rounded-2xl p-6 border border-slate-100">
                        <p class="text-[9px] text-slate-400 font-extrabold uppercase tracking-widest mb-1.5">Harga Per Orang</p>
                        <p class="text-3xl font-black text-primary-600">
                            <span class="text-sm font-semibold">Rp</span> {{ number_format($ticket->price, 0, ',', '.') }}
                        </p>
                    </div>
                    <div class="bg-slate-50 rounded-2xl p-6 border border-slate-100">
                        <p class="text-[9px] text-slate-400 font-extrabold uppercase tracking-widest mb-1.5">Kuota Kapasitas Harian</p>
                        <p class="text-3xl font-black text-slate-800">
                            {{ $ticket->daily_quota }} <span class="text-xs font-semibold text-slate-400">Tiket / Hari</span>
                        </p>
                    </div>
                </div>

                <div class="space-y-8">
                    <div>
                        <h2 class="text-base font-bold text-slate-900 mb-4 flex items-center gap-2 tracking-tight">
                            <i class="fa-solid fa-circle-check text-primary-500"></i> Manfaat & Fasilitas Tiket
                        </h2>
                        <p class="text-slate-600 text-sm leading-relaxed bg-slate-50 rounded-2xl p-6 border border-slate-100 font-medium">{{ $ticket->benefit }}</p>
                    </div>

                    <div>
                        <h2 class="text-base font-bold text-slate-900 mb-4 flex items-center gap-2 tracking-tight">
                            <i class="fa-solid fa-circle-info text-primary-500"></i> Informasi Penting Kunjungan
                        </h2>
                        <div class="grid gap-4">
                            <div class="flex gap-4 p-4 rounded-2xl border border-slate-100">
                                <div class="w-10 h-10 shrink-0 rounded-xl bg-amber-50 flex items-center justify-center text-amber-600 shadow-sm shadow-amber-100">
                                    <i class="fa-solid fa-clock"></i>
                                </div>
                                <div>
                                    <p class="text-xs font-bold text-slate-900 uppercase tracking-wide">Jam Operasional Destinasi</p>
                                    <p class="text-sm text-slate-500 font-semibold mt-0.5">{{ $ticket->destination->open_time }} - {{ $ticket->destination->close_time }} WIB</p>
                                </div>
                            </div>
                            <div class="flex gap-4 p-4 rounded-2xl border border-slate-100">
                                <div class="w-10 h-10 shrink-0 rounded-xl bg-emerald-50 flex items-center justify-center text-emerald-600 shadow-sm shadow-emerald-100">
                                    <i class="fa-solid fa-bolt animate-pulse"></i>
                                </div>
                                <div>
                                    <p class="text-xs font-bold text-slate-900 uppercase tracking-wide">Konfirmasi & E-Ticket Instan</p>
                                    <p class="text-sm text-slate-500 font-semibold mt-0.5">E-Ticket dikirim otomatis ke email dan menu pesanan setelah pembayaran terverifikasi.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Sidebar / Booking Summary -->
        <aside>
            <div class="sticky top-24 bg-white rounded-[2rem] border border-slate-100 p-8 shadow-xl shadow-slate-200/40">
                <h3 class="text-lg font-bold text-slate-900 mb-6 tracking-tight">Ringkasan Pembelian</h3>
                
                <div class="space-y-6 mb-8">
                    <div class="flex items-start gap-4">
                        <div class="shrink-0 w-16 h-12 rounded-xl overflow-hidden bg-slate-100">
                             @php
                                 $coverImg = $ticket->destination->coverImage ?? $ticket->destination->images->first();
                             @endphp
                             @if($coverImg?->image_path)
                                 <img src="{{ asset('storage/' . $coverImg->image_path) }}" 
                                      alt="{{ $ticket->destination->name }}"
                                      class="w-full h-full object-cover">
                             @else
                                 <div class="w-full h-full bg-slate-100 flex items-center justify-center">
                                     <i class="fa-regular fa-image text-slate-300"></i>
                                 </div>
                             @endif
                        </div>
                        <div class="min-w-0">
                            <p class="text-sm font-bold text-slate-900 leading-tight mb-1 truncate">{{ $ticket->destination->name }}</p>
                            <p class="text-xs text-slate-400 font-semibold"><i class="fa-solid fa-location-dot text-secondary-500 mr-1"></i>{{ $ticket->destination->city }}</p>
                        </div>
                    </div>
                    
                    <div class="pt-6 border-t border-slate-100">
                        <div class="flex justify-between items-center mb-3">
                            <span class="text-xs text-slate-500 font-semibold">Tipe Tiket</span>
                            <span class="text-xs text-slate-800 font-bold bg-slate-50 px-2.5 py-1 rounded-md border border-slate-100">{{ $ticket->name }}</span>
                        </div>
                        <div class="flex justify-between items-center mb-6">
                            <span class="text-xs text-slate-500 font-semibold">Status Ketersediaan</span>
                            <span class="text-xs text-emerald-600 font-bold bg-emerald-50 px-2.5 py-1 rounded-md border border-emerald-100 flex items-center gap-1"><i class="fa-solid fa-circle text-[6px]"></i> Tersedia Hari Ini</span>
                        </div>
                        
                        <div class="p-5 rounded-2xl bg-primary-50 border border-primary-100">
                            <div class="flex justify-between items-end">
                                <span class="text-xs text-primary-700 font-extrabold uppercase tracking-wider">Total Pembayaran</span>
                                <p class="text-2xl font-black text-primary-700">
                                    <span class="text-xs font-semibold">Rp</span> {{ number_format($ticket->price, 0, ',', '.') }}
                                </p>
                            </div>
                        </div>
                    </div>
                </div>

                <a href="{{ route('checkout.show', $ticket) }}" class="btn-premium flex items-center justify-center w-full bg-gradient-to-r from-primary-600 to-primary-500 hover:from-primary-700 hover:to-primary-600 text-white font-bold py-4 rounded-2xl shadow-xl shadow-primary-600/20">
                    Beli Tiket Sekarang
                </a>
                
                <p class="text-center text-[10px] text-slate-400 mt-5 font-semibold leading-relaxed">
                    Dengan menekan tombol di atas, Anda menyetujui <br> 
                    <a href="#" class="underline hover:text-primary-600">Syarat & Ketentuan</a> yang berlaku di Tabibito.
                </p>
            </div>
        </aside>
    </div>
@endsection