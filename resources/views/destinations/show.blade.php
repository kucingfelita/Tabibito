@extends('layouts.app')

@section('content')
    <nav class="mb-4 text-sm text-slate-500">Beranda > Wisata > {{ $destination->name }}</nav>
    <div class="rounded-3xl bg-white p-5 shadow-sm">
        <div class="grid gap-6 lg:grid-cols-[1.5fr_1fr]">
            <div>
                <div class="h-72 overflow-hidden rounded-3xl bg-slate-200">
                    @if($destination->images->first()?->image_path)
                        <img src="{{ asset('storage/' . $destination->images->first()->image_path) }}" alt="{{ $destination->name }}" class="h-full w-full object-cover">
                    @endif
                </div>
                <div class="mt-5 flex flex-wrap gap-2">
                    @foreach($destination->tags as $tag)
                        <span class="rounded-full bg-emerald-100 px-3 py-1 text-xs text-emerald-700">{{ $tag->name }}</span>
                    @endforeach
                </div>
            </div>
            <div>
                <h1 class="text-3xl font-bold">{{ $destination->name }}</h1>
                <p class="mt-3 text-sm text-slate-500">{{ $destination->address }}, {{ $destination->city }}</p>
                <p class="mt-2 text-sm text-slate-500">Jam buka: {{ $destination->open_time }} - {{ $destination->close_time }}</p>
                <a href="{{ $destination->map_link }}" target="_blank" class="mt-4 inline-flex items-center rounded-full bg-cyan-600 px-4 py-2 text-sm text-white">Arahkan via Google Maps</a>
                <p class="mt-6 text-sm leading-7 text-slate-600">{{ $destination->description }}</p>
            </div>
        </div>
    </div>

    <h2 class="mt-10 text-xl font-semibold">Tiket</h2>
    <div class="mt-4 grid gap-4 md:grid-cols-2">
        @foreach($destination->tickets as $ticket)
            <a href="{{ route('tickets.show', $ticket) }}" class="rounded-3xl bg-white p-5 shadow-sm transition hover:-translate-y-1">
                <div class="flex items-center justify-between gap-4">
                    <div>
                        <h3 class="text-lg font-semibold">{{ $ticket->name }}</h3>
                        <p class="mt-2 text-sm text-slate-500">{{ $ticket->benefit }}</p>
                    </div>
                    <span class="rounded-full bg-emerald-100 px-3 py-1 text-sm text-emerald-700">Rp {{ number_format($ticket->price, 0, ',', '.') }}</span>
                </div>
                <div class="mt-4 flex items-center justify-between gap-3 text-sm text-slate-500">
                    <p>Kuota: {{ $ticket->daily_quota }} per hari</p>
                    <p>{{ $destination->city }}</p>
                </div>
                <div class="mt-4 text-right">
                    <span class="inline-flex rounded-full bg-slate-100 px-4 py-2 text-sm font-medium text-slate-700">Lihat Tiket</span>
                </div>
            </a>
        @endforeach
    </div>

    <div class="mt-10 rounded-3xl bg-white p-5 shadow-sm">
        <h2 class="text-lg font-semibold">Kontak Tempat Wisata</h2>
        <p class="mt-3 text-sm text-slate-600">Untuk informasi lebih lanjut, silakan hubungi pemilik destinasi atau cek pada halaman detail tempat wisata.</p>
        <p class="mt-3 text-sm text-slate-500">Pemilik: {{ $destination->owner?->name ?? 'Admin' }}</p>
        <p class="text-sm text-slate-500">Email: {{ $destination->owner?->email ?? 'tidak tersedia' }}</p>
    </div>
@endsection
