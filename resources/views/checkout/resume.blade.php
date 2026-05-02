@extends('layouts.app')

@section('content')
    {{-- <nav class="mb-4 text-sm text-slate-500">Beranda > Riwayat > Lanjutkan Pembayaran</nav> --}}

    <!-- Responsive Checkout Form -->
    <div class="rounded-2xl md:rounded-3xl bg-white p-4 md:p-5 shadow-sm">
        <h2 class="text-lg font-semibold">Lanjutkan Pembayaran</h2>
        <p class="mt-1 text-sm text-slate-500">{{ $transaction->ticket->name }}</p>
        <p class="text-base md:text-lg font-semibold text-emerald-600">Rp {{ number_format($transaction->total_price, 0, ',', '.') }}</p>

        @if($transaction->snap_token)
        <!-- Responsive Grid Layout -->
        <div class="mt-4 md:mt-6 grid gap-4 md:grid-cols-2">
            <!-- Form Fields -->
            <div class="space-y-3 md:space-y-4">
                <div>
                    <label class="block text-sm font-medium text-slate-700">Nama</label>
                    <input type="text" value="{{ $transaction->user->name }}" readonly class="mt-1 md:mt-2 w-full rounded-xl md:rounded-2xl border px-3 md:px-4 py-2.5 md:py-3 bg-slate-50 text-slate-800">
                </div>
                <div>
                    <label class="block text-sm font-medium text-slate-700">Tanggal Kunjungan</label>
                    <input type="date" value="{{ $transaction->booking_date->format('Y-m-d') }}" readonly class="mt-1 md:mt-2 w-full rounded-xl md:rounded-2xl border px-3 md:px-4 py-2.5 md:py-3 bg-slate-50 text-slate-800">
                </div>
                <div>
                    <label class="block text-sm font-medium text-slate-700">Jumlah Tiket</label>
                    <input type="number" value="{{ $transaction->qty }}" readonly class="mt-1 md:mt-2 w-full rounded-xl md:rounded-2xl border px-3 md:px-4 py-2.5 md:py-3 bg-slate-50 text-slate-800">
                </div>
                <button id="pay-button" type="button" class="w-full rounded-xl md:rounded-2xl bg-emerald-600 px-4 py-2.5 md:py-3 text-sm font-semibold text-white">Lanjutkan Pembayaran</button>
            </div>

            <!-- Order Summary -->
            <div class="rounded-xl md:rounded-3xl bg-slate-50 p-4 md:p-5">
                <h3 class="font-semibold">Ringkasan Tiket</h3>
                <div class="mt-3 md:mt-4 space-y-2 text-sm text-slate-600">
                    <p>Nama tiket: {{ $transaction->ticket->name }}</p>
                    <p>Harga tiket: Rp {{ number_format($transaction->ticket->price, 0, ',', '.') }}</p>
                    <p>Jumlah: {{ $transaction->qty }}</p>
                    <p class="font-medium">Total: Rp {{ number_format($transaction->total_price, 0, ',', '.') }}</p>
                </div>
            </div>
        </div>
        @else
        <div class="mt-4 md:mt-6 rounded-xl md:rounded-3xl bg-red-50 p-4 md:p-5">
            <p class="text-sm text-red-600">Maaf, terjadi kesalahan dalam memuat pembayaran. Silakan coba lagi nanti atau hubungi support.</p>
        </div>
        @endif
    </div>

    @if($transaction->snap_token)
    <script src="{{ config('services.midtrans.snap_url') }}" data-client-key="{{ config('services.midtrans.client_key') }}"></script>
    <script>
        const payButton = document.getElementById('pay-button');
        payButton?.addEventListener('click', function (event) {
            event.preventDefault();

            window.snap.pay(@json($transaction->snap_token), {
                onSuccess: function (result) {
                    const params = new URLSearchParams({
                        order_id: result.order_id,
                        transaction_status: result.transaction_status || 'success',
                    });
                    window.location.href = '{{ route('checkout.finish') }}?' + params.toString();
                },
                onPending: function (result) {
                    const params = new URLSearchParams({
                        order_id: result.order_id,
                        transaction_status: result.transaction_status || 'pending',
                    });
                    window.location.href = '{{ route('checkout.finish') }}?' + params.toString();
                },
                onError: function (result) {
                    const params = new URLSearchParams({
                        order_id: result.order_id,
                        transaction_status: 'error',
                    });
                    window.location.href = '{{ route('checkout.finish') }}?' + params.toString();
                },
            });
        });
    </script>
    @endif
@endsection
