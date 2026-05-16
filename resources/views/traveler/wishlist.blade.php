@extends('layouts.app')

@section('content')
    <div class="mb-10">
        <h1 class="text-3xl font-black text-slate-900 mb-2">Wishlist Saya</h1>
        <p class="text-slate-500 font-medium">Destinasi impian yang telah Anda simpan.</p>
    </div>

    @if($destinations->isEmpty())
        <div class="bg-white rounded-[2.5rem] p-12 text-center border border-slate-100 shadow-sm">
            <div class="w-20 h-20 bg-primary-50 rounded-3xl flex items-center justify-center text-primary-600 mx-auto mb-6">
                <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/></svg>
            </div>
            <h3 class="text-xl font-bold text-slate-900 mb-2">Belum ada wishlist</h3>
            <p class="text-slate-500 mb-8 max-w-md mx-auto">Mulai jelajahi destinasi menarik dan simpan yang Anda sukai di sini.</p>
            <a href="{{ route('destinations.index') }}" class="inline-flex items-center gap-2 bg-primary-600 hover:bg-primary-700 text-white px-8 py-3.5 rounded-2xl font-bold transition-all transform hover:-translate-y-1">
                Eksplor Wisata Sekarang
            </a>
        </div>
    @else
        <div class="max-w-5xl mx-auto space-y-6" id="destination-container">
            @include('destinations.partials.cards', ['destinations' => $destinations])
        </div>

        <div class="mt-12 flex justify-center">
            {{ $destinations->links() }}
        </div>
    @endif
@endsection
