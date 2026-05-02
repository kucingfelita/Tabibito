@extends('layouts.app')

@section('content')
    {{-- <nav class="mb-4 text-sm text-slate-500">Beranda > Checkout > Selesai</nav> --}}

    <!-- Responsive Finish Page -->
    <div class="rounded-2xl md:rounded-3xl bg-white p-5 md:p-6 shadow-sm">
        <div class="space-y-3 md:space-y-4">
            <h1 class="text-2xl md:text-3xl font-bold">Pembayaran selesai</h1>
            <p class="text-sm md:text-base text-slate-600">Terima kasih! Pembayaran Anda telah berhasil diproses. Silakan periksa detail transaksi di bawah ini atau kunjungi riwayat pembelian Anda.</p>
        </div>

        @if($transaction)
            <!-- Responsive Grid -->
            <div class="mt-6 md:mt-8 grid grid-2 gap-3 md:gap-4 lg:grid-cols-2">
                <div class="rounded-xl md:rounded-3xl bg-slate-50 p-4 md:p-5">
                    <p class="text-xs uppercase tracking-wide text-slate-500">Order ID</p>
                    <p class="mt-1 md:mt-2 text-base md:text-lg font-semibold text-slate-900 truncate">{{ $transaction->order_id }}</p>
                </div>
                <div class="rounded-xl md:rounded-3xl bg-slate-50 p-4 md:p-5">
                    <p class="text-xs uppercase tracking-wide text-slate-500">Status Pembayaran</p>
                    <p class="mt-1 md:mt-2 text-base md:text-lg font-semibold text-emerald-600">{{ ucfirst($status) }}</p>
                </div>
                <div class="rounded-xl md:rounded-3xl bg-slate-50 p-4 md:p-5">
                    <p class="text-xs uppercase tracking-wide text-slate-500">Destinasi</p>
                    <p class="mt-1 md:mt-2 text-sm text-slate-700">{{ $transaction->ticket ? optional($transaction->ticket->destination)->name : 'N/A' }}</p>
                </div>
                <div class="rounded-xl md:rounded-3xl bg-slate-50 p-4 md:p-5">
                    <p class="text-xs uppercase tracking-wide text-slate-500">Tanggal Kunjungan</p>
                    <p class="mt-1 md:mt-2 text-sm text-slate-700">{{ optional($transaction->booking_date)->format('d M Y') }}</p>
                </div>
            </div>

            <!-- Total Payment -->
            <div class="mt-4 md:mt-6 rounded-xl md:rounded-3xl bg-slate-50 p-4 md:p-5">
                <p class="text-xs uppercase tracking-wide text-slate-500">Total Pembayaran</p>
                <p class="mt-1 md:mt-2 text-xl md:text-2xl font-semibold text-slate-900">Rp {{ number_format($transaction->total_price, 0, ',', '.') }}</p>
            </div>
        @else
            <div class="mt-6 md:mt-8 rounded-xl md:rounded-3xl bg-slate-50 p-4 md:p-5">
                <p class="text-sm text-slate-600">Transaksi tidak ditemukan. Silakan periksa riwayat pembelian Anda untuk memastikan pembayaran sudah tercatat.</p>
            </div>
        @endif

        <!-- Action Buttons -->
        <div class="mt-6 md:mt-8 flex flex-col sm:flex-row gap-3">
            <a href="{{ route('history.index') }}" class="inline-flex items-center justify-center rounded-xl md:rounded-2xl bg-emerald-600 px-5 py-2.5 md:py-3 text-sm font-semibold text-white">Lihat Riwayat</a>
            <a href="{{ route('home') }}" class="inline-flex items-center justify-center rounded-xl md:rounded-2xl bg-slate-100 px-5 py-2.5 md:py-3 text-sm font-semibold text-slate-700">Kembali ke Beranda</a>
        </div>
    </div>
@endsection
