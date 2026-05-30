@extends('layouts.app')

@section('content')
<div class="max-w-5xl mx-auto px-4 md:px-0">
    <!-- Breadcrumbs -->
    <nav class="mb-8 flex items-center gap-2 text-sm">
        <a href="{{ route('home') }}" class="text-slate-400 hover:text-primary-600 transition-colors font-medium">Beranda</a>
        <svg class="w-4 h-4 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
        <span class="text-slate-900 font-bold">Wishlist</span>
    </nav>

    <!-- Header Section -->
    <div class="mb-10 md:flex md:items-center md:justify-between gap-6">
        <div>
            <h1 class="text-3xl font-black text-slate-900">Wishlist Saya</h1>
            <p class="text-xs text-slate-400 font-bold uppercase tracking-wider mt-1 flex items-center gap-1.5">
                <i class="fa-solid fa-heart text-rose-500 animate-pulse"></i> Destinasi impian yang Anda simpan
            </p>
        </div>
        
        @if(!$destinations->isEmpty())
            <div class="mt-4 md:mt-0 inline-flex items-center gap-2 px-4 py-2 bg-rose-50 border border-rose-100 rounded-2xl text-rose-700 text-xs font-black uppercase tracking-wider">
                <i class="fa-solid fa-heart"></i>
                {{ $destinations->total() }} Destinasi Tersimpan
            </div>
        @endif
    </div>

    @if($destinations->isEmpty())
        <!-- Premium Empty State -->
        <div class="bg-white rounded-[2.5rem] p-12 md:p-16 text-center border border-slate-100 shadow-sm max-w-2xl mx-auto">
            <div class="w-20 h-20 bg-rose-50 text-rose-600 rounded-[1.8rem] flex items-center justify-center mx-auto mb-8 border border-rose-100 shadow-inner">
                <i class="fa-regular fa-heart text-3xl animate-pulse"></i>
            </div>
            <h3 class="text-2xl font-black text-slate-900 mb-2.5">Belum Ada Wishlist</h3>
            <p class="text-xs text-slate-400 font-bold uppercase tracking-widest mb-4">Temukan Liburan Impian Anda</p>
            <p class="text-sm text-slate-500 font-medium leading-relaxed max-w-sm mx-auto mb-8">
                Jelajahi keindahan alam, budaya, dan tempat hiburan menarik di Jawa Tengah. Cukup tekan ikon hati di kartu wisata untuk menyimpannya di sini.
            </p>
            <a href="{{ route('destinations.index') }}" class="inline-flex items-center gap-2 bg-primary-600 hover:bg-primary-700 text-white px-8 py-4 rounded-2xl font-black shadow-xl shadow-primary-200 transition-all transform hover:-translate-y-1 active:translate-y-0 text-xs uppercase tracking-wider">
                <i class="fa-solid fa-compass"></i> Jelajahi Destinasi Sekarang
            </a>
        </div>
    @else
        <!-- Grid Items Container -->
        <div class="grid gap-6" id="destination-container">
            @include('destinations.partials.cards', ['destinations' => $destinations])
        </div>

        <!-- Beautiful Pagination -->
        @if($destinations->hasPages())
            <div class="mt-10 p-4 bg-white border border-slate-100 rounded-3xl flex justify-center shadow-sm">
                {{ $destinations->links() }}
            </div>
        @endif
    @endif
</div>
@endsection
