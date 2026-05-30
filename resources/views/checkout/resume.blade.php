@extends('layouts.app')

@section('content')
    <!-- Breadcrumbs -->
    <nav class="mb-8 flex items-center gap-2 text-sm px-4 md:px-0">
        <a href="{{ route('home') }}" class="text-slate-400 hover:text-primary-600 transition-colors font-medium">Beranda</a>
        <svg class="w-4 h-4 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
        <span class="text-slate-950 font-bold">Resume Pembayaran</span>
    </nav>

    <!-- Step Progress Bar -->
    <div class="mb-10 bg-white rounded-3xl border border-slate-100 p-6 md:p-8 shadow-sm mx-4 md:mx-0">
        <div class="max-w-4xl mx-auto">
            <div class="grid grid-cols-2 md:grid-cols-4 gap-6 md:gap-8">
                <!-- Step 1 -->
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-2xl bg-emerald-50 text-emerald-600 flex items-center justify-center font-bold text-sm shadow-sm shrink-0 border border-emerald-100">
                        <i class="fa-solid fa-check text-xs"></i>
                    </div>
                    <div>
                        <p class="text-[10px] text-slate-400 font-bold uppercase tracking-widest">Langkah 1</p>
                        <p class="text-xs md:text-sm font-bold text-slate-700">Pilih Wisata</p>
                    </div>
                </div>
                
                <!-- Step 2 -->
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-2xl bg-emerald-50 text-emerald-600 flex items-center justify-center font-bold text-sm shadow-sm shrink-0 border border-emerald-100">
                        <i class="fa-solid fa-check text-xs"></i>
                    </div>
                    <div>
                        <p class="text-[10px] text-slate-400 font-bold uppercase tracking-widest">Langkah 2</p>
                        <p class="text-xs md:text-sm font-bold text-slate-700">Isi Data & Tanggal</p>
                    </div>
                </div>
                
                <!-- Step 3 -->
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-2xl bg-primary-600 text-white flex items-center justify-center font-bold text-sm shadow-lg shadow-primary-200 shrink-0">
                        3
                    </div>
                    <div>
                        <p class="text-[10px] text-primary-500 font-bold uppercase tracking-widest">Langkah 3</p>
                        <p class="text-xs md:text-sm font-black text-slate-900">Pembayaran</p>
                    </div>
                </div>
                
                <!-- Step 4 -->
                <div class="flex items-center gap-3 opacity-50 md:opacity-60">
                    <div class="w-10 h-10 rounded-2xl bg-slate-100 text-slate-500 flex items-center justify-center font-bold text-sm shrink-0 border border-slate-200/50">
                        4
                    </div>
                    <div>
                        <p class="text-[10px] text-slate-400 font-bold uppercase tracking-widest">Langkah 4</p>
                        <p class="text-xs md:text-sm font-semibold text-slate-600">Tiket Terbit</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="max-w-5xl mx-auto px-4 md:px-0">
        @if($transaction->snap_token)
            <div class="grid gap-8 lg:grid-cols-[1.5fr_1fr] items-start">
                
                <!-- Payment Action & Guide Section -->
                <div class="space-y-6">
                    
                    <!-- Countdown Timer Card -->
                    <div class="bg-amber-50 border border-amber-100 rounded-3xl p-6 flex items-center gap-5 shadow-sm">
                        <div class="w-14 h-14 rounded-2xl bg-amber-500 text-white flex items-center justify-center text-xl shrink-0 shadow-md shadow-amber-200 animate-pulse">
                            <i class="fa-solid fa-clock"></i>
                        </div>
                        <div>
                            <p class="text-xs font-bold text-amber-800 uppercase tracking-widest mb-0.5">Selesaikan Pembayaran Dalam</p>
                            <div class="flex items-center gap-2">
                                <span id="countdown-timer" class="text-2xl font-black text-amber-900">15:00</span>
                                <span class="text-xs font-semibold text-amber-700/80">Menit sebelum tiket dibatalkan</span>
                            </div>
                        </div>
                    </div>

                    <!-- Client Detail Card -->
                    <div class="bg-white rounded-[2rem] p-8 border border-slate-100 shadow-sm space-y-6">
                        <div class="flex items-center gap-4 pb-4 border-b border-slate-50">
                            <div class="w-11 h-11 rounded-xl bg-primary-50 text-primary-600 flex items-center justify-center">
                                <i class="fa-solid fa-user-check"></i>
                            </div>
                            <div>
                                <h3 class="text-lg font-black text-slate-900">Konfirmasi Pemesan</h3>
                                <p class="text-xs text-slate-400 font-semibold">Pastikan data berikut sudah benar</p>
                            </div>
                        </div>

                        <div class="grid md:grid-cols-2 gap-4">
                            <div class="bg-slate-50 rounded-2xl p-4 flex items-center gap-3.5 border border-slate-100/50">
                                <div class="w-10 h-10 rounded-xl bg-white flex items-center justify-center text-slate-400 border border-slate-100 shadow-sm shrink-0">
                                    <i class="fa-solid fa-id-card text-xs"></i>
                                </div>
                                <div>
                                    <p class="text-[10px] font-bold text-slate-400 uppercase tracking-wider">Nama Pemesan</p>
                                    <p class="font-extrabold text-slate-800 text-sm">{{ $transaction->user->name }}</p>
                                </div>
                            </div>

                            <div class="bg-slate-50 rounded-2xl p-4 flex items-center gap-3.5 border border-slate-100/50">
                                <div class="w-10 h-10 rounded-xl bg-white flex items-center justify-center text-slate-400 border border-slate-100 shadow-sm shrink-0">
                                    <i class="fa-solid fa-calendar-day text-xs"></i>
                                </div>
                                <div>
                                    <p class="text-[10px] font-bold text-slate-400 uppercase tracking-wider">Tanggal Kunjungan</p>
                                    <p class="font-extrabold text-slate-800 text-sm">{{ $transaction->booking_date->format('d M Y') }}</p>
                                </div>
                            </div>
                        </div>

                        <!-- CTA Pay Button -->
                        <div class="pt-4">
                            <button id="pay-button" type="button" class="w-full bg-primary-600 hover:bg-primary-700 text-white font-black py-5 rounded-2xl shadow-xl shadow-primary-600/30 transition-all transform hover:-translate-y-1 active:translate-y-0 flex items-center justify-center gap-3 text-base">
                                <i class="fa-solid fa-wallet text-lg"></i>
                                Bayar Sekarang
                            </button>
                        </div>
                    </div>

                    <!-- Payment Instructions Accordions -->
                    <div class="bg-white rounded-[2rem] p-8 border border-slate-100 shadow-sm space-y-6" x-data="{ activeAccordion: null }">
                        <div class="flex items-center gap-4 pb-4 border-b border-slate-50">
                            <div class="w-11 h-11 rounded-xl bg-secondary-50 text-secondary-600 flex items-center justify-center">
                                <i class="fa-solid fa-circle-question"></i>
                            </div>
                            <div>
                                <h3 class="text-lg font-black text-slate-900">Petunjuk Pembayaran</h3>
                                <p class="text-xs text-slate-400 font-semibold font-sans">Cara melakukan pembayaran melalui Midtrans</p>
                            </div>
                        </div>

                        <div class="space-y-3">
                            <!-- Accordion 1: Virtual Account -->
                            <div class="border border-slate-100 rounded-2xl overflow-hidden">
                                <button @click="activeAccordion = activeAccordion === 1 ? null : 1" class="w-full flex items-center justify-between px-6 py-4 bg-slate-50/50 hover:bg-slate-50 transition-colors text-left">
                                    <span class="text-xs font-black text-slate-800 flex items-center gap-2.5">
                                        <i class="fa-solid fa-building-columns text-primary-500 w-4"></i> Virtual Account (Transfer Bank)
                                    </span>
                                    <i class="fa-solid text-xs text-slate-400 transition-transform duration-300" :class="activeAccordion === 1 ? 'fa-chevron-up' : 'fa-chevron-down'"></i>
                                </button>
                                <div x-show="activeAccordion === 1" x-cloak x-transition.opacity class="px-6 py-5 border-t border-slate-100 bg-white text-xs text-slate-600 space-y-3 font-semibold leading-relaxed">
                                    <p class="font-bold text-slate-800">Langkah Transfer VA:</p>
                                    <ol class="list-decimal pl-4 space-y-2">
                                        <li>Klik tombol <span class="text-primary-600 font-bold">"Bayar Sekarang"</span> di atas.</li>
                                        <li>Pilih metode pembayaran <span class="font-bold text-slate-800">"Transfer Bank / Virtual Account"</span>.</li>
                                        <li>Pilih bank yang Anda gunakan (BCA, Mandiri, BNI, BRI, dll).</li>
                                        <li>Salin nomor Virtual Account yang muncul di layar.</li>
                                        <li>Lakukan transfer menggunakan m-banking, e-banking, atau ATM terdekat sebelum waktu batas pembayaran habis.</li>
                                    </ol>
                                </div>
                            </div>

                            <!-- Accordion 2: QRIS / GoPay -->
                            <div class="border border-slate-100 rounded-2xl overflow-hidden">
                                <button @click="activeAccordion = activeAccordion === 2 ? null : 2" class="w-full flex items-center justify-between px-6 py-4 bg-slate-50/50 hover:bg-slate-50 transition-colors text-left">
                                    <span class="text-xs font-black text-slate-800 flex items-center gap-2.5">
                                        <i class="fa-solid fa-qrcode text-secondary-500 w-4"></i> QRIS / Dompet Digital
                                    </span>
                                    <i class="fa-solid text-xs text-slate-400 transition-transform duration-300" :class="activeAccordion === 2 ? 'fa-chevron-up' : 'fa-chevron-down'"></i>
                                </button>
                                <div x-show="activeAccordion === 2" x-cloak x-transition.opacity class="px-6 py-5 border-t border-slate-100 bg-white text-xs text-slate-600 space-y-3 font-semibold leading-relaxed">
                                    <p class="font-bold text-slate-800">Langkah Pembayaran QRIS / GoPay / ShopeePay:</p>
                                    <ol class="list-decimal pl-4 space-y-2">
                                        <li>Klik tombol <span class="text-primary-600 font-bold">"Bayar Sekarang"</span> di atas.</li>
                                        <li>Pilih <span class="font-bold text-slate-800">"GoPay / QRIS"</span>.</li>
                                        <li>Pindai (scan) kode QR yang muncul di layar menggunakan aplikasi GoPay, OVO, ShopeePay, Dana, LinkAja, atau aplikasi m-banking pendukung QRIS Anda.</li>
                                        <li>Konfirmasi pembayaran di ponsel Anda.</li>
                                    </ol>
                                </div>
                            </div>

                            <!-- Accordion 3: Kartu Kredit -->
                            <div class="border border-slate-100 rounded-2xl overflow-hidden">
                                <button @click="activeAccordion = activeAccordion === 3 ? null : 3" class="w-full flex items-center justify-between px-6 py-4 bg-slate-50/50 hover:bg-slate-50 transition-colors text-left">
                                    <span class="text-xs font-black text-slate-800 flex items-center gap-2.5">
                                        <i class="fa-regular fa-credit-card text-emerald-500 w-4"></i> Kartu Kredit / Debit Online
                                    </span>
                                    <i class="fa-solid text-xs text-slate-400 transition-transform duration-300" :class="activeAccordion === 3 ? 'fa-chevron-up' : 'fa-chevron-down'"></i>
                                </button>
                                <div x-show="activeAccordion === 3" x-cloak x-transition.opacity class="px-6 py-5 border-t border-slate-100 bg-white text-xs text-slate-600 space-y-3 font-semibold leading-relaxed">
                                    <p class="font-bold text-slate-800">Langkah Pembayaran Kartu Kredit:</p>
                                    <ol class="list-decimal pl-4 space-y-2">
                                        <li>Klik tombol <span class="text-primary-600 font-bold">"Bayar Sekarang"</span>.</li>
                                        <li>Pilih opsi <span class="font-bold text-slate-800">"Kartu Kredit"</span>.</li>
                                        <li>Masukkan nomor kartu kredit, masa berlaku, dan kode CVV Anda.</li>
                                        <li>Masukkan kode OTP yang dikirimkan bank penerbit kartu ke ponsel Anda untuk verifikasi.</li>
                                    </ol>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Ticket Summary Card (Sticky Right Side) -->
                <aside class="space-y-6">
                    <div class="bg-slate-900 text-white rounded-[2.5rem] p-8 relative overflow-hidden shadow-xl shadow-slate-900/10">
                        <!-- Elegant abstract background curves -->
                        <div class="absolute top-0 right-0 w-36 h-36 bg-white/5 rounded-full -mr-16 -mt-16"></div>
                        <div class="absolute -bottom-10 -left-10 w-24 h-24 bg-primary-500/15 rounded-full blur-xl"></div>
                        
                        <h3 class="text-lg font-black mb-6 relative flex items-center gap-2">
                            <i class="fa-solid fa-receipt text-primary-400"></i> Ringkasan Tiket
                        </h3>
                        
                        <div class="space-y-5 relative">
                            <!-- Destination title block -->
                            <div class="pb-5 border-b border-white/10 space-y-1">
                                <span class="px-2 py-0.5 rounded-full bg-white/10 text-primary-300 text-[9px] font-black uppercase tracking-wider">Destinasi</span>
                                <h4 class="text-lg font-black leading-snug">{{ optional($transaction->ticket->destination)->name }}</h4>
                                <p class="text-xs text-slate-400 font-bold flex items-center gap-1">
                                    <i class="fa-solid fa-location-dot text-rose-500"></i> {{ optional($transaction->ticket->destination)->city }}
                                </p>
                            </div>
                            
                            <!-- Detailed pricing parameters -->
                            <div class="space-y-3.5">
                                <div class="flex justify-between items-center text-xs">
                                    <span class="text-slate-400 font-semibold uppercase tracking-wider">Tipe Tiket</span>
                                    <span class="font-bold">{{ $transaction->ticket->name }}</span>
                                </div>
                                <div class="flex justify-between items-center text-xs">
                                    <span class="text-slate-400 font-semibold uppercase tracking-wider">Harga Satuan</span>
                                    <span class="font-bold">Rp {{ number_format($transaction->ticket->price, 0, ',', '.') }}</span>
                                </div>
                                <div class="flex justify-between items-center text-xs">
                                    <span class="text-slate-400 font-semibold uppercase tracking-wider">Jumlah Tiket</span>
                                    <span class="font-black bg-white/10 px-2.5 py-0.5 rounded-lg text-primary-300">{{ $transaction->qty }}x</span>
                                </div>
                            </div>
                            
                            <!-- Total price field -->
                            <div class="pt-5 border-t border-dashed border-white/20">
                                <p class="text-slate-400 text-[10px] font-black uppercase tracking-widest mb-1">Total Pembayaran</p>
                                <p class="text-3xl font-black text-primary-400 tracking-tight">Rp {{ number_format($transaction->total_price, 0, ',', '.') }}</p>
                                <p class="text-[9px] text-slate-500 font-semibold mt-1">Harga final sudah termasuk PPN & biaya admin</p>
                            </div>
                        </div>
                    </div>

                    <!-- Secure trust footer -->
                    <div class="bg-white rounded-3xl p-6 border border-slate-100 shadow-sm flex items-start gap-4">
                        <div class="w-10 h-10 rounded-xl bg-emerald-50 text-emerald-600 flex items-center justify-center shrink-0">
                            <i class="fa-solid fa-circle-check text-base"></i>
                        </div>
                        <div>
                            <h5 class="text-xs font-black text-slate-900 mb-1">Tiket Instan & Aman</h5>
                            <p class="text-[10px] text-slate-400 leading-relaxed font-semibold">Setelah transaksi dikonfirmasi oleh sistem, e-tiket akan otomatis terbit di akun Anda dan dapat discan langsung di pintu masuk wisata.</p>
                        </div>
                    </div>
                </aside>
            </div>
        @else
            <!-- Error State -->
            <div class="bg-rose-50 border border-rose-100 p-10 rounded-[2.5rem] text-center max-w-xl mx-auto shadow-sm">
                <div class="w-16 h-16 rounded-full bg-rose-100 flex items-center justify-center text-rose-600 mx-auto mb-6">
                    <i class="fa-solid fa-circle-exclamation text-2xl"></i>
                </div>
                <h4 class="text-rose-950 font-black text-lg mb-2">Terjadi Kesalahan Pembayaran</h4>
                <p class="text-rose-700/80 font-semibold text-sm leading-relaxed mb-6">Maaf, token pembayaran dari gateway Midtrans tidak dapat dimuat atau telah kedaluwarsa. Silakan coba membuat pesanan kembali.</p>
                <a href="{{ route('home') }}" class="inline-flex items-center gap-2 bg-rose-600 hover:bg-rose-700 text-white font-bold px-8 py-3 rounded-2xl shadow-lg shadow-rose-600/25 transition-all text-xs uppercase tracking-wider">
                    Kembali ke Beranda
                </a>
            </div>
        @endif
    </div>

    @if($transaction->snap_token)
    <script src="{{ config('services.midtrans.snap_url') }}" data-client-key="{{ config('services.midtrans.client_key') }}"></script>
    <script>
        const orderId = @json($transaction->order_id);
        const countdownKey = 'payment_countdown_' + orderId;
        const countdownElement = document.getElementById('countdown-timer');

        // Simulated persistent countdown timer
        let targetTime = sessionStorage.getItem(countdownKey);
        if (!targetTime) {
            // Set 15 minutes from now
            targetTime = new Date().getTime() + (15 * 60 * 1000);
            sessionStorage.setItem(countdownKey, targetTime);
        } else {
            targetTime = parseInt(targetTime);
        }

        function runTimer() {
            const now = new Date().getTime();
            const diff = targetTime - now;

            if (diff <= 0) {
                countdownElement.textContent = "00:00";
                countdownElement.className = "text-rose-600 animate-pulse text-2xl font-black";
                const payBtn = document.getElementById('pay-button');
                if (payBtn) {
                    payBtn.disabled = true;
                    payBtn.className = "w-full bg-slate-200 text-slate-400 font-black py-5 rounded-2xl cursor-not-allowed text-center";
                    payBtn.innerHTML = '<i class="fa-solid fa-circle-xmark"></i> Waktu Bayar Habis';
                }
                sessionStorage.removeItem(countdownKey);
                return;
            }

            const minutes = Math.floor((diff % (1000 * 60 * 60)) / (1000 * 60));
            const seconds = Math.floor((diff % (1000 * 60)) / 1000);

            const displayMinutes = String(minutes).padStart(2, '0');
            const displaySeconds = String(seconds).padStart(2, '0');

            countdownElement.textContent = displayMinutes + ":" + displaySeconds;
            setTimeout(runTimer, 1000);
        }

        runTimer();

        // Midtrans pay button trigger
        const payButton = document.getElementById('pay-button');
        payButton?.addEventListener('click', function (event) {
            event.preventDefault();

            window.snap.pay(@json($transaction->snap_token), {
                onSuccess: function (result) {
                    sessionStorage.removeItem(countdownKey);
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
