@extends('layouts.app')

@section('content')
    <!-- Breadcrumbs -->
    <nav class="mb-8 flex items-center gap-2 text-sm">
        <a href="{{ route('home') }}" class="text-slate-400 hover:text-primary-600 transition-colors">Beranda</a>
        <svg class="w-4 h-4 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
        <a href="{{ route('destinations.index') }}" class="text-slate-400 hover:text-primary-600 transition-colors">Eksplor Wisata</a>
        <svg class="w-4 h-4 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
        <span class="text-slate-900 font-bold">Checkout</span>
    </nav>

    <div class="grid gap-10 lg:grid-cols-[1.5fr_1fr]">
        <!-- Checkout Form -->
        <div class="space-y-8">
            <div class="bg-white rounded-[2.5rem] p-8 md:p-12 border border-slate-100 shadow-sm">
                <div class="flex items-center gap-4 mb-10">
                    <div class="w-12 h-12 rounded-2xl bg-primary-600 flex items-center justify-center text-white shadow-lg shadow-primary-200">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                    </div>
                    <div>
                        <h2 class="text-2xl font-black text-slate-900">Informasi Pemesan</h2>
                        <p class="text-sm text-slate-400 font-medium">Lengkapi detail pemesanan tiket Anda.</p>
                    </div>
                </div>

                <form method="POST" action="{{ route('checkout.store', $ticket) }}" class="space-y-8" id="checkout-form">
                    @csrf
                    
                    <div class="grid gap-8">
                        <div>
                            <label class="block text-xs font-bold text-slate-400 uppercase tracking-widest mb-3">Nama Pemesan</label>
                            <div class="relative group">
                                <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-slate-400 group-focus-within:text-primary-600 transition-colors">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                                </div>
                                <input type="text" name="name" value="{{ auth()->user()->name }}" readonly class="w-full bg-slate-50 border-none rounded-2xl pl-12 pr-4 py-4 text-slate-800 font-bold focus:ring-2 focus:ring-primary-500/20 transition-all opacity-70">
                            </div>
                        </div>

                        <div class="grid md:grid-cols-2 gap-8">
                            <div>
                                <label class="block text-xs font-bold text-slate-400 uppercase tracking-widest mb-3">Tanggal Kunjungan</label>
                                <div class="relative group">
                                    <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-slate-400 group-focus-within:text-primary-600 transition-colors">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                                    </div>
                                    <input type="date" id="booking_date" name="booking_date"
                                           min="{{ now()->toDateString() }}" required
                                           class="w-full bg-slate-50 border-none rounded-2xl pl-12 pr-4 py-4 text-slate-800 font-bold focus:ring-2 focus:ring-primary-500/20 transition-all">
                                </div>
                                <p class="mt-2 text-[10px] font-bold text-slate-400 uppercase tracking-wider flex items-center gap-1.5">
                                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                    Status Kuota: <span id="quota-info" class="text-slate-400">Pilih tanggal</span>
                                </p>
                            </div>

                            <div>
                                <label class="block text-xs font-bold text-slate-400 uppercase tracking-widest mb-3">Jumlah Tiket</label>
                                <div class="relative group">
                                    <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-slate-400 group-focus-within:text-primary-600 transition-colors">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/></svg>
                                    </div>
                                    <input type="number" id="qty" name="qty" min="1" max="{{ $ticket->daily_quota }}"
                                           value="1" required class="w-full bg-slate-50 border-none rounded-2xl pl-12 pr-4 py-4 text-slate-800 font-bold focus:ring-2 focus:ring-primary-500/20 transition-all">
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="pt-8 border-t border-slate-50">
                        <div class="flex flex-col items-center justify-center mb-8 p-6 bg-primary-50 rounded-3xl border border-primary-100 text-center">
                            <div class="mb-6">
                                <p class="text-xs text-primary-700 font-bold uppercase tracking-widest mb-1">Total Pembayaran</p>
                                <p id="total-display" class="text-4xl font-black text-primary-700">Rp {{ number_format($ticket->price, 0, ',', '.') }}</p>
                            </div>
                            @if(session('snap_token'))
                                <button type="button" disabled class="w-full sm:w-auto bg-slate-300 text-white px-12 py-4 rounded-2xl font-bold transition-all cursor-not-allowed">
                                    Menunggu Pembayaran
                                </button>
                            @else
                                <button type="submit" id="submit-btn" class="w-full sm:w-auto bg-primary-600 hover:bg-primary-700 text-white px-12 py-4 rounded-2xl font-bold shadow-xl shadow-primary-600/30 transition-all transform hover:-translate-y-1 disabled:opacity-70 disabled:cursor-not-allowed disabled:transform-none">
                                    Bayar Sekarang
                                </button>
                            @endif
                        </div>
                        <p class="text-center text-[10px] text-slate-400 font-medium">Dengan melanjutkan, Anda menyetujui kebijakan pembatalan dan ketentuan layanan kami.</p>
                    </div>
                </form>
            </div>
        </div>

        <!-- Summary Sidebar -->
        <aside class="space-y-8">
            <div class="sticky top-24 space-y-8">
                <div class="bg-white rounded-[2rem] border border-slate-100 p-8 shadow-sm overflow-hidden relative">
                    <!-- Decorative Background -->
                    <div class="absolute top-0 right-0 w-32 h-32 bg-primary-50 rounded-full -mr-16 -mt-16 opacity-50"></div>
                    
                    <h3 class="text-xl font-bold text-slate-900 mb-8 relative">Ringkasan Pesanan</h3>
                    
                    <div class="space-y-6 relative">
                        <div class="flex items-start gap-4">
                            <div class="shrink-0 w-16 h-16 rounded-2xl overflow-hidden bg-slate-100">
                                @if($ticket->destination->images->first()?->image_path)
                                    <img src="{{ asset('storage/' . $ticket->destination->images->first()->image_path) }}" class="w-full h-full object-cover">
                                @endif
                            </div>
                            <div>
                                <p class="text-sm font-black text-slate-900 leading-tight mb-1">{{ $ticket->destination->name }}</p>
                                <p class="text-xs text-slate-400 font-medium">{{ $ticket->destination->city }}</p>
                            </div>
                        </div>

                        <div class="pt-6 border-t border-slate-50 space-y-4">
                            <div class="flex justify-between items-center">
                                <span class="text-sm text-slate-500 font-medium">Tipe Tiket</span>
                                <span class="text-sm text-slate-900 font-bold">{{ $ticket->name }}</span>
                            </div>
                            <div class="flex justify-between items-center">
                                <span class="text-sm text-slate-500 font-medium">Harga Satuan</span>
                                <span class="text-sm text-slate-900 font-bold">Rp {{ number_format($ticket->price, 0, ',', '.') }}</span>
                            </div>
                            <div class="flex justify-between items-center pt-4 border-t border-dashed border-slate-200">
                                <span class="text-base font-black text-slate-900">Total</span>
                                <span id="summary-total" class="text-xl font-black text-primary-600">Rp {{ number_format($ticket->price, 0, ',', '.') }}</span>
                            </div>
                        </div>
                    </div>

                    @if(session('snap_token'))
                        <div class="mt-8 pt-8 border-t border-slate-50">
                            <button id="pay-button" type="button" class="w-full bg-cyan-600 hover:bg-cyan-700 text-white font-bold py-5 rounded-2xl shadow-xl shadow-cyan-600/30 transition-all flex items-center justify-center gap-3">
                                <svg class="w-5 h-5 animate-pulse" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M4 4a2 2 0 00-2 2v4a2 2 0 002 2V6h10a2 2 0 00-2-2H4zm2 6a2 2 0 012-2h8a2 2 0 012 2v4a2 2 0 01-2 2H8a2 2 0 01-2-2v-4zm6 4a2 2 0 100-4 2 2 0 000 4z" clip-rule="evenodd"/></svg>
                                Lanjutkan Pembayaran
                            </button>
                        </div>
                    @endif
                </div>

                <!-- Trust Badge -->
                <div class="bg-slate-900 rounded-[2rem] p-8 text-white relative overflow-hidden">
                    <svg class="absolute bottom-[-20px] right-[-20px] w-32 h-32 text-white/5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M2.166 4.9L10 1.154l7.834 3.746A2 2 0 0119 6.753V14c0 1.171-.779 2.123-1.877 2.4l-6.523 1.63a1.996 1.996 0 01-1.2 0l-6.523-1.63A2.001 2.001 0 011 14V6.753c0-.795.474-1.514 1.166-1.853zM10 9a3 3 0 100-6 3 3 0 000 6z" clip-rule="evenodd"/></svg>
                    <div class="flex items-center gap-4 mb-4">
                        <div class="w-10 h-10 rounded-xl bg-white/10 flex items-center justify-center">
                            <svg class="w-6 h-6 text-primary-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/></svg>
                        </div>
                        <h4 class="font-bold text-sm">Secure Checkout</h4>
                    </div>
                    <p class="text-xs text-slate-400 leading-relaxed">Seluruh data transaksi dan pembayaran Anda diproses melalui gateway Midtrans yang aman dan terpercaya.</p>
                </div>
            </div>
        </aside>
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

        const quotaUrl = '/checkout/' + ticketId + '/quota';

        function formatRupiah(number) {
            return 'Rp ' + Math.round(number).toLocaleString('id-ID');
        }

        function updateTotal() {
            const qty = parseInt(qtyInput.value) || 1;
            const total = price * qty;
            totalDisplay.textContent = formatRupiah(total);
            summaryTotal.textContent = formatRupiah(total);
        }

        function updateQuota(date) {
            if (!date) return;
            quotaInfo.textContent = 'Memuat...';
            quotaInfo.className = 'text-slate-400';

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
                quotaInfo.className = avail > 0 ? 'text-emerald-500' : 'text-rose-500';
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
                quotaInfo.className = 'text-rose-500';
                console.error('Quota fetch error:', err);
            });
        }

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

        window.addEventListener('beforeunload', saveToStorage);

        document.getElementById('checkout-form').addEventListener('submit', function() {
            saveToStorage();
            const submitBtn = document.getElementById('submit-btn');
            if (submitBtn) {
                setTimeout(() => {
                    submitBtn.disabled = true;
                    submitBtn.innerHTML = '<svg class="w-5 h-5 animate-spin mx-auto inline-block mr-2" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg> Memproses...';
                }, 10);
            }
        });

        qtyInput.addEventListener('input', function() {
            updateTotal();
            saveToStorage();
        });

        dateInput.addEventListener('change', function() {
            updateQuota(this.value);
        });

        restoreFromStorage();
        updateTotal();
    </script>

    @if(session('snap_token'))
        <script src="{{ config('services.midtrans.snap_url') }}" data-client-key="{{ config('services.midtrans.client_key') }}"></script>
        <script>
            window.onload = function() {
                const payBtn = document.getElementById('pay-button');
                if (payBtn) {
                    payBtn.scrollIntoView({ behavior: 'smooth', block: 'center' });
                }
            };

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
