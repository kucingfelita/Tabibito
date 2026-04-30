@extends('layouts.app')

@section('content')
    <nav class="mb-4 text-sm text-slate-500">Beranda > Wisata > Checkout</nav>
    <div class="grid gap-6 md:grid-cols-2">
        <form method="POST" action="{{ route('checkout.store', $ticket) }}" class="rounded-3xl bg-white p-5 shadow-sm">
            @csrf
            <h2 class="text-lg font-semibold">Checkout Tiket</h2>
            <p class="mt-1 text-sm text-slate-500">{{ $ticket->name }}</p>
            <p class="text-sm font-semibold text-emerald-600">Rp {{ number_format($ticket->price, 0, ',', '.') }}</p>
            <div class="mt-6 space-y-4">
                <div>
                    <label class="block text-sm font-medium text-slate-700">Nama</label>
                    <input type="text" name="name" value="{{ auth()->user()->name }}" readonly class="mt-2 w-full rounded-2xl border px-4 py-3 bg-slate-50 text-slate-800">
                </div>
                <div>
                    <label class="block text-sm font-medium text-slate-700">Tanggal Berwisata</label>
                    <input type="date" name="booking_date" min="{{ now()->toDateString() }}" required class="mt-2 w-full rounded-2xl border px-4 py-3">
                </div>
                <div>
                    <label class="block text-sm font-medium text-slate-700">Jumlah Tiket</label>
                    <input type="number" name="qty" min="1" max="{{ $ticket->current_quota }}" value="1" required class="mt-2 w-full rounded-2xl border px-4 py-3">
                </div>
                <button class="w-full rounded-2xl bg-emerald-600 px-4 py-3 text-sm font-semibold text-white">Bayar</button>
            </div>
        </form>
        <div class="rounded-3xl bg-white p-5 shadow-sm">
            <h3 class="font-semibold">Ringkasan Tiket</h3>
            <div class="mt-4 space-y-3 text-sm text-slate-600">
                <p>Nama tiket: {{ $ticket->name }}</p>
                <p>Harga tiket: Rp {{ number_format($ticket->price, 0, ',', '.') }}</p>
                <p>Kuota tersisa: {{ $ticket->current_quota }}</p>
                <p class="text-slate-500">Total akan dihitung saat Anda memasukkan jumlah tiket.</p>
                @if(session('snap_token'))
                    <button id="pay-button" type="button" class="mt-4 w-full rounded-2xl bg-cyan-600 px-4 py-3 text-sm font-semibold text-white">Lanjutkan Pembayaran</button>
                @endif
            </div>
        </div>
    </div>
    <script>
        const price = {{ $ticket->price }};
        const qtyInput = document.querySelector('input[name="qty"]');
        const totalEl = document.createElement('p');
        totalEl.className = 'mt-4 text-base font-semibold text-slate-900';
        const summary = document.querySelector('.rounded-3xl.bg-white.p-5.shadow-sm');
        if (summary) {
            summary.appendChild(totalEl);
        }
        function updateTotal() {
            const qty = Number(qtyInput.value) || 1;
            totalEl.textContent = 'Total: Rp ' + (price * qty).toLocaleString('id-ID');
        }
        qtyInput?.addEventListener('input', updateTotal);
        updateTotal();
    </script>

    @if(session('snap_token'))
        <script src="{{ config('services.midtrans.snap_url') }}" data-client-key="{{ config('services.midtrans.client_key') }}"></script>
        <script>
            const payButton = document.getElementById('pay-button');
            payButton?.addEventListener('click', function (event) {
                event.preventDefault();

                window.snap.pay(@json(session('snap_token')), {
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
