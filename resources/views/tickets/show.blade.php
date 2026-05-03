@extends('layouts.app')

@section('content')
    <nav class="mb-4 text-sm text-slate-500">Beranda > Wisata > {{ $ticket->destination->name }} > {{ $ticket->name }}</nav>

    <div class="grid gap-6 lg:grid-cols-[2fr_1fr]">
        <div class="rounded-3xl bg-white p-5 shadow-sm">
            <h1 class="text-3xl font-bold">{{ $ticket->name }}</h1>
            <p class="mt-2 text-sm text-slate-500">{{ $ticket->destination->name }} - {{ $ticket->destination->city }}</p>
            <p class="mt-4 text-sm leading-7 text-slate-600">{{ $ticket->benefit }}</p>

            <div class="mt-8 grid gap-4 md:grid-cols-2">
                <div class="rounded-3xl bg-slate-50 p-5">
                    <p class="text-sm text-slate-500">Harga Tiket</p>
                    <p class="mt-2 text-2xl font-semibold text-emerald-600">Rp {{ number_format($ticket->price, 0, ',', '.') }}</p>
                </div>
                <div class="rounded-3xl bg-slate-50 p-5">
                    <p class="text-sm text-slate-500">Kuota per Hari</p>
                    <p class="mt-2 text-2xl font-semibold text-slate-700">{{ $ticket->daily_quota }}</p>
                </div>
            </div>

            <div class="mt-8 rounded-3xl bg-slate-50 p-5">
                <h2 class="text-lg font-semibold">Detail Destinasi</h2>
                <p class="mt-2 text-sm text-slate-600">{{ $ticket->destination->name }}</p>
                <p class="mt-1 text-sm text-slate-500">{{ $ticket->destination->address }}, {{ $ticket->destination->city }}</p>
                <p class="mt-3 text-sm text-slate-500">Jam buka: {{ $ticket->destination->open_time }} - {{ $ticket->destination->close_time }}</p>
            </div>

            <div class="mt-8 flex flex-wrap gap-2">
                @foreach($ticket->destination->tags as $tag)
                    <span class="rounded-full bg-emerald-100 px-3 py-1 text-xs text-emerald-700">{{ $tag->name }}</span>
                @endforeach
            </div>
        </div>

        <aside class="rounded-3xl bg-white p-5 shadow-sm">
            <h2 class="text-lg font-semibold">Pilih Tiket</h2>
            <p class="mt-3 text-sm text-slate-600">Silakan lanjutkan ke checkout untuk memilih tanggal dan jumlah tiket.</p>
            <div class="mt-6 space-y-4 text-sm text-slate-600">
                <div class="rounded-2xl bg-slate-50 p-4">
                    <p class="font-semibold">Destinasi</p>
                    <p class="mt-1">{{ $ticket->destination->name }}</p>
                </div>
                <div class="rounded-2xl bg-slate-50 p-4">
                    <p class="font-semibold">Kuota Harian</p>
                    <p class="mt-1">{{ $ticket->daily_quota }} tiket</p>
                </div>
                <div class="rounded-2xl bg-slate-50 p-4">
                    <p class="font-semibold">Harga</p>
                    <p class="mt-1">Rp {{ number_format($ticket->price, 0, ',', '.') }}</p>
                </div>
            </div>

            <a href="{{ route('checkout.show', $ticket) }}" class="mt-6 inline-flex w-full items-center justify-center rounded-2xl bg-emerald-600 px-4 py-3 text-sm font-semibold text-white">Beli Tiket Sekarang</a>
        </aside>
    </div>
@endsection