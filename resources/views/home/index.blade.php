
@extends('layouts.app')

@section('content')
    <!-- Hero Section - Responsive -->
    <section class="rounded-2xl bg-gradient-to-r from-emerald-600 to-cyan-600 p-6 md:p-8 text-white">
        <h1 class="text-2xl md:text-3xl font-bold">Tabibito Jateng</h1>
        <p class="mt-2 max-w-2xl text-sm md:text-base text-emerald-50">Temukan destinasi terbaik, pesan tiket online, dan scan QR saat tiba di lokasi.</p>
        <form action="{{ route('destinations.index') }}" class="mt-4 md:mt-6">
            <input type="text" name="city" placeholder="Cari kota wisata..." class="w-full rounded-xl border-0 px-4 py-3 text-slate-700">
        </form>
    </section>

    <!-- Recommendations - Responsive Grid -->
    <section class="mt-8 md:mt-10">
        <h2 class="text-xl font-semibold">Rekomendasi</h2>
        <div class="mt-4 grid grid-2 gap-4 md:grid-cols-3">
            @forelse($recommendations as $destination)
                <a href="{{ route('destinations.show', $destination) }}" class="rounded-2xl md:rounded-3xl bg-white p-4 md:p-6 shadow-sm hover:-translate-y-1 transition">
                    <div class="h-32 md:h-40 overflow-hidden rounded-2xl md:rounded-3xl bg-slate-200">
                        @if($destination->images->first()?->image_path)
                            <img src="{{ asset('storage/' . $destination->images->first()->image_path) }}" alt="{{ $destination->name }}" class="h-full w-full object-cover">
                        @endif
                    </div>
                    <h3 class="mt-3 md:mt-4 text-base md:text-lg font-semibold truncate">{{ $destination->name }}</h3>
                    <p class="mt-1 text-sm text-slate-500">{{ $destination->city }}</p>
                    <p class="mt-2 md:mt-3 text-sm md:text-base font-medium text-emerald-600">
                        Mulai dari Rp {{ number_format(optional($destination->tickets->sortBy('price')->first())->price ?? 0, 0, ',', '.') }}
                    </p>
                </a>
            @empty
                <div class="col-span-full rounded-xl bg-white p-6 text-sm text-slate-500 text-center">Belum ada rekomendasi wisata.</div>
            @endforelse
        </div>
    </section>

    <!-- How to Buy - Responsive Steps -->
    <section class="mt-8 md:mt-10 rounded-2xl bg-white p-6 md:p-8 shadow-sm">
        <h2 class="text-xl font-semibold">Cara Membeli Tiket</h2>
        <div class="mt-4 md:mt-6 grid grid-2 gap-4 md:grid-cols-3">
            <div class="rounded-2xl md:rounded-3xl border border-slate-200 p-4 md:p-5">
                <h3 class="font-semibold">1. Pilih Destinasi</h3>
                <p class="mt-2 text-sm text-slate-500">Cari dan pilih wisata yang ingin dikunjungi di halaman Wifi ata.</p>
            </div>
            <div class="rounded-2xl md:rounded-3xl border border-slate-200 p-4 md:p-5">
                <h3 class="font-semibold">2. Pilih Tiket</h3>
                <p class="mt-2 text-sm text-slate-500">Pilih paket tiket yang sesuai, lalu klik detail tiket.</p>
            </div>
            <div class="rounded-2xl md:rounded-3xl border border-slate-200 p-4 md:p-5">
                <h3 class="font-semibold">3. Bayar & Konfirmasi</h3>
                <p class="mt-2 text-sm text-slate-500">Isi tanggal dan jumlah, lalu lakukan pembayaran via Midtrans.</p>
            </div>
        </div>
    </section>
@endsection
