@extends('layouts.app')

@section('content')
    <nav class="mb-4 text-sm text-slate-500">Beranda > Wisata > Checkout</nav>
    <div class="grid gap-6 md:grid-cols-2">
        <form method="POST" action="{{ route('checkout.store', $ticket) }}" class="rounded-3xl bg-white p-5 shadow-sm" id="checkout-form">
            @csrf
            <h2 class="text-lg font-semibold">Checkout Tiket</h2>
            <p class="mt-1 text-sm text-slate-500">{{ $ticket->name }}</p>
            <p class="text-sm font-semibold text-emerald-600">Rp {{ number_format($ticket->price, 0, ',', '.') }} / tiket</p>
            <div class="mt-6 space-y-4">
                <div>
                    <label class="block text-sm font-medium text-slate-700">Nama</label>
                    <input type="text" name="name" value="{{ auth()->user()->name }}" readonly class="mt-2 w-full rounded-2xl border px-4 py-3 bg-slate-50 text-slate-800">
                </div>
                <div>
                    <label class="block text-sm font-medium text-slate-700">Tanggal Berwisata</label>
                    <input type="date" id="booking_date" name="booking_date"
                           min="{{ now()->toDateString() }}" required
                           class="mt-2 w-full rounded-2xl border px-4 py-3">
                    <p class="mt-1 text-xs text-slate-500">
                        Kuota tersisa:
                        <span id="quota-info" class="font-semibold text-slate-400">Pilih tanggal dulu</span>
                    </p>
                </div>
                <div>
                    <label class="block text-sm font-medium text-slate-700">Jumlah Tiket</label>
                    <input type="number" id="qty" name="qty" min="1" max="{{ $ticket->daily_quota }}"
                           value="1" required class="mt-2 w-full rounded-2xl border px-4 py-3">
                </div>

                <div class="rounded-2xl bg-emerald-50 px-4 py-3">
                    <p class="text-sm text-slate-600">Total Pembayaran:</p>
                    <p id="total-display" class="text-xl font-bold text-emerald-700">Rp {{ number_format($ticket->price, 0, ',', '.') }}</p>
                </div>

                <button type="submit" class="w-full rounded-2xl bg-emerald-600 px-4 py-3 text-sm font-semibold text-white">Bayar</button>
            </div>
        </form>

        <div class="rounded-3xl bg-white p-5 shadow-sm">
            <h3 class="font-semibold">Ringkasan Tiket</h3>
            <div class="mt-4 space-y-3 text-sm text-slate-600">
                <p>Nama tiket: {{ $ticket->name }}</p>
                <p>Harga tiket: Rp {{ number_format($ticket->price, 0, ',', '.') }} / orang</p>
                <p>Kuota per hari: {{ $ticket->daily_quota }}</p>
                <p id="summary-total" class="text-base font-semibold text-slate-900">Total: Rp {{ number_format($ticket->price, 0, ',', '.') }}</p>
                @if(session('snap_token'))
                    <button id="pay-button" type="button" class="mt-4 w-full rounded-2xl bg-cyan-600 px-4 py-3 text-sm font-semibold text-white">Lanjutkan Pembayaran</button>
                @endif
            </div>
        </div>
    </div>

    <script>
        const price = {{ $ticket->price }};
        const ticketId = {{ $ticket->id }};
        const storageKey = 'checkout_ticket_' + ticketId;

        const qtyInput = document.getElementById('qty');
        const dateInput = document.getElementById('booking_date');
        const quotaInfo = document.getElementById('quota-info');
        const totalDisplay = document.getElementById('total-display');
        const summaryTotal = document.getElementById('summary-total');

        // Build quota check URL manually to avoid Blade issues
        const quotaUrl = '/checkout/' + ticketId + '/quota';

        function formatRupiah(number) {
            return 'Rp ' + Math.round(number).toLocaleString('id-ID');
        }

        function updateTotal() {
            const qty = parseInt(qtyInput.value) || 1;
            const total = price * qty;
            totalDisplay.textContent = formatRupiah(total);
            summaryTotal.textContent = 'Total: ' + formatRupiah(total);
        }

        function updateQuota(date) {
            if (!date) return;
            quotaInfo.textContent = 'Memuat...';
            quotaInfo.className = 'font-semibold text-slate-400';

            fetch(quotaUrl + '?date=' + encodeURIComponent(date), {
                headers: { 'Accept': 'application/json' }
            })
            .then(function(r) {
                if (!r.ok) throw new Error('HTTP ' + r.status);
                return r.json();
            })
            .then(function(data) {
                const avail = parseInt(data.available);
                quotaInfo.textContent = avail + ' tiket tersedia';
                quotaInfo.className = avail > 0 ? 'font-semibold text-emerald-700' : 'font-semibold text-red-600';
                qtyInput.max = avail > 0 ? avail : 1;
                if (avail <= 0) {
                    qtyInput.value = 0;
                } else if (parseInt(qtyInput.value) > avail) {
                    qtyInput.value = avail;
                }
                updateTotal();
                saveToStorage();
            })
            .catch(function(err) {
                quotaInfo.textContent = 'Gagal memuat kuota';
                quotaInfo.className = 'font-semibold text-red-500';
                console.error('Quota fetch error:', err);
            });
        }

        // ---- localStorage: save & restore form values ----
        function saveToStorage() {
            localStorage.setItem(storageKey, JSON.stringify({
                date: dateInput.value,
                qty: qtyInput.value
            }));
        }

        function restoreFromStorage() {
            try {
                const saved = JSON.parse(localStorage.getItem(storageKey));
                if (!saved) return;
                if (saved.date) {
                    dateInput.value = saved.date;
                    updateQuota(saved.date);
                }
                if (saved.qty) {
                    qtyInput.value = saved.qty;
                    updateTotal();
                }
            } catch(e) {}
        }

        // Clear storage when navigating away (not on submit)
        window.addEventListener('beforeunload', saveToStorage);

        // Save when submitting so it survives redirect
        document.getElementById('checkout-form').addEventListener('submit', function() {
            saveToStorage();
        });

        // Events
        qtyInput.addEventListener('input', function() {
            updateTotal();
            saveToStorage();
        });

        dateInput.addEventListener('change', function() {
            updateQuota(this.value);
        });

        // On page load: restore saved values
        restoreFromStorage();
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
                        localStorage.removeItem('checkout_ticket_' + ticketId);
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
