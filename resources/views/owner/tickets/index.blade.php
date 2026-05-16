@extends('layouts.app')

@section('content')
    @include('owner.partials.nav')
    <h1 class="text-xl font-semibold">Manajemen Tiket</h1>
    <form method="POST" action="{{ route('owner.tickets.store') }}" class="mt-4 grid gap-3 rounded-xl bg-white p-4 shadow-sm md:grid-cols-2">
        @csrf
        <select name="destination_id" class="rounded-lg border px-3 py-2">
            <option value="">Pilih destinasi</option>
            @foreach($destinations as $destination)
                <option value="{{ $destination->id }}">{{ $destination->name }}</option>
            @endforeach
        </select>
        <input name="name" placeholder="Nama paket tiket" class="rounded-lg border px-3 py-2" maxlength="120">
        <input type="number" name="price" placeholder="Harga" class="rounded-lg border px-3 py-2" min="1000" max="999999999">
        <input type="number" name="daily_quota" placeholder="Kuota harian" class="rounded-lg border px-3 py-2" min="1" max="1000000">
        <textarea name="benefit" placeholder="Benefit tiket" class="rounded-lg border px-3 py-2 md:col-span-2"></textarea>
        <button class="rounded-lg bg-emerald-600 px-4 py-2 text-white md:col-span-2">Tambah Tiket</button>
    </form>

    <div class="mt-6 space-y-4">
        @foreach($tickets as $ticket)
            <div class="rounded-xl bg-white p-4 shadow-sm">
                <form method="POST" action="{{ route('owner.tickets.update', $ticket) }}" class="grid gap-3 md:grid-cols-2">
                    @csrf
                    @method('PUT')
                    <select name="destination_id" class="rounded-lg border px-3 py-2">
                        @foreach($destinations as $destination)
                            <option value="{{ $destination->id }}" @selected($destination->id === $ticket->destination_id)>{{ $destination->name }}</option>
                        @endforeach
                    </select>
                    <input name="name" value="{{ $ticket->name }}" class="rounded-lg border px-3 py-2" maxlength="120">
                    <input type="number" name="price" value="{{ $ticket->price }}" class="rounded-lg border px-3 py-2" min="1000" max="999999999">
                    <input type="number" name="daily_quota" value="{{ $ticket->daily_quota }}" class="rounded-lg border px-3 py-2" min="1" max="1000000">
                    <textarea name="benefit" class="rounded-lg border px-3 py-2 md:col-span-2">{{ $ticket->benefit }}</textarea>
                    <button class="rounded-lg bg-cyan-600 px-4 py-2 text-white md:col-span-2">Simpan</button>
                </form>
                <div class="mt-2">
                    <form method="POST" action="{{ route('owner.tickets.destroy', $ticket) }}">
                        @csrf
                        @method('DELETE')
                        <button class="rounded-lg bg-rose-600 px-4 py-2 text-white">Hapus</button>
                    </form>
                </div>
                <p class="mt-2 text-xs text-slate-500">Destinasi: {{ $ticket->destination->name }} | Kuota Maksimal per Hari: {{ $ticket->daily_quota }}</p>
            </div>
        @endforeach
    </div>
    <div class="mt-4">{{ $tickets->links() }}</div>
@endsection
