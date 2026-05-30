@extends('layouts.app')

@push('styles')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
<style>
    /* Custom Flatpickr styles to look super premium */
    .flatpickr-calendar {
        background: #ffffff !important;
        border: 1px solid #e2e8f0 !important;
        box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.05), 0 4px 6px -2px rgba(0, 0, 0, 0.02) !important;
        border-radius: 1.5rem !important;
        padding: 0.5rem !important;
        font-family: inherit !important;
        width: 100% !important;
    }
    .flatpickr-calendar.inline {
        width: 100% !important;
        box-sizing: border-box !important;
        display: block !important;
    }
    .flatpickr-days {
        width: 100% !important;
    }
    .dayContainer {
        width: 100% !important;
        min-width: 100% !important;
        max-width: 100% !important;
    }
    .flatpickr-day {
        border-radius: 0.75rem !important;
        font-weight: 600 !important;
        margin: 2px auto !important;
        max-width: 38px !important;
        height: 38px !important;
        line-height: 38px !important;
        transition: all 0.2s ease;
    }
    .flatpickr-day.selected {
        background: #0e8ce9 !important;
        border-color: #0e8ce9 !important;
        color: #ffffff !important;
    }
    
    /* Quota Color States */
    .day-quota-safe {
        background-color: #f0fdf4 !important;
        color: #166534 !important;
    }
    .day-quota-safe:hover {
        background-color: #dcfce7 !important;
    }
    .day-quota-warning {
        background-color: #fff7ed !important;
        color: #9a3412 !important;
    }
    .day-quota-warning:hover {
        background-color: #ffedd5 !important;
    }
    .day-quota-danger {
        background-color: #fef2f2 !important;
        color: #991b1b !important;
        cursor: not-allowed !important;
    }
    .flatpickr-day.disabled, .flatpickr-day.flatpickr-disabled {
        background-color: #f1f5f9 !important;
        color: #cbd5e1 !important;
        cursor: not-allowed !important;
        text-decoration: line-through;
    }
    
    /* Custom style to clean input number spinners */
    input[type=number]::-webkit-inner-spin-button, 
    input[type=number]::-webkit-outer-spin-button { 
        -webkit-appearance: none; 
        margin: 0; 
    }
    input[type=number] {
        -moz-appearance: textfield;
    }
</style>
@endpush

@section('content')
    <!-- Breadcrumbs -->
    <nav class="mb-8 flex items-center gap-2 text-sm px-4 md:px-0">
        <a href="{{ route('home') }}" class="text-slate-400 hover:text-primary-600 transition-colors font-medium">Beranda</a>
        <svg class="w-4 h-4 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
        <a href="{{ route('destinations.index') }}" class="text-slate-400 hover:text-primary-600 transition-colors font-medium">Eksplor Wisata</a>
        <svg class="w-4 h-4 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
        <span class="text-slate-900 font-bold">Checkout</span>
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
                    <div class="w-10 h-10 rounded-2xl bg-primary-600 text-white flex items-center justify-center font-bold text-sm shadow-lg shadow-primary-200 shrink-0">
                        2
                    </div>
                    <div>
                        <p class="text-[10px] text-primary-500 font-bold uppercase tracking-widest">Langkah 2</p>
                        <p class="text-xs md:text-sm font-black text-slate-900">Isi Data & Tanggal</p>
                    </div>
                </div>
                
                <!-- Step 3 -->
                <div class="flex items-center gap-3 opacity-50 md:opacity-60">
                    <div class="w-10 h-10 rounded-2xl bg-slate-100 text-slate-500 flex items-center justify-center font-bold text-sm shrink-0 border border-slate-200/50">
                        3
                    </div>
                    <div>
                        <p class="text-[10px] text-slate-400 font-bold uppercase tracking-widest">Langkah 3</p>
                        <p class="text-xs md:text-sm font-semibold text-slate-600">Pembayaran</p>
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

    <div class="grid gap-8 lg:grid-cols-[1.6fr_1fr] px-4 md:px-0 items-start">
        <!-- Checkout Form -->
        <div class="space-y-8">
            <div class="bg-white rounded-[2.5rem] p-8 md:p-10 border border-slate-100 shadow-sm relative overflow-hidden">
                <!-- Sparkle Decors -->
                <div class="absolute top-0 right-0 w-32 h-32 bg-primary-50 rounded-full -mr-16 -mt-16 opacity-40"></div>
                
                <div class="flex items-center gap-4 mb-8 pb-6 border-b border-slate-50">
                    <div class="w-12 h-12 rounded-2xl bg-primary-50 flex items-center justify-center text-primary-600 shadow-sm shrink-0">
                        <i class="fa-solid fa-user-pen text-lg"></i>
                    </div>
                    <div>
                        <h2 class="text-2xl font-black text-slate-900">Informasi Pemesan</h2>
                        <p class="text-xs text-slate-400 font-semibold tracking-wide">Detail data kunjungan dan pemesan tiket</p>
                    </div>
                </div>

                <form method="POST" action="{{ route('checkout.store', $ticket) }}" class="space-y-8" id="checkout-form">
                    @csrf
                    
                    <div class="grid gap-6">
                        <!-- Nama Pemesan -->
                        <div>
                            <label class="block text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-2.5 ml-1">Nama Pemesan</label>
                            <div class="relative group">
                                <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-slate-400 group-focus-within:text-primary-600 transition-colors">
                                    <i class="fa-solid fa-user text-sm"></i>
                                </div>
                                <input type="text" name="name" value="{{ auth()->user()->name }}" readonly class="w-full bg-slate-50 border border-slate-100 rounded-2xl pl-11 pr-4 py-4 text-slate-800 font-bold focus:ring-2 focus:ring-primary-500/20 transition-all cursor-not-allowed opacity-75">
                            </div>
                            <p class="mt-1.5 text-[10px] text-slate-400 font-semibold flex items-center gap-1.5 ml-1">
                                <i class="fa-solid fa-circle-info"></i>
                                Nama pemesan diambil dari detail akun Anda dan tidak dapat diubah di formulir ini.
                            </p>
                        </div>

                        <!-- Date and Quantity Grid -->
                        <div class="grid md:grid-cols-2 gap-8 pt-4">
                            <!-- Tanggal Kunjungan -->
                            <div class="space-y-3">
                                <label class="block text-[10px] font-bold text-slate-400 uppercase tracking-widest ml-1">Pilih Tanggal Kunjungan</label>
                                <div class="bg-white rounded-3xl border border-slate-100 overflow-hidden p-2">
                                    <input type="text" id="booking_date" name="booking_date" required class="hidden">
                                </div>
                                <div class="p-3 bg-slate-50 rounded-2xl flex items-center gap-2.5 border border-slate-100">
                                    <span id="quota-indicator" class="w-2.5 h-2.5 rounded-full bg-slate-300 animate-pulse shrink-0"></span>
                                    <p class="text-xs font-bold text-slate-600">
                                        Status Kuota: <span id="quota-info" class="text-slate-400">Pilih tanggal pada kalender</span>
                                    </p>
                                </div>
                            </div>

                            <!-- Jumlah Tiket -->
                            <div class="space-y-4">
                                <div>
                                    <label class="block text-[10px] font-bold text-slate-400 uppercase tracking-widest ml-1 mb-3">Jumlah Tiket</label>
                                    
                                    <!-- Beautiful Interactive Spinner -->
                                    <div class="flex items-center gap-4 bg-slate-50 border border-slate-100 rounded-2xl p-2.5 max-w-[200px]">
                                        <button type="button" id="qty-dec" class="w-11 h-11 rounded-xl bg-white hover:bg-slate-100 text-slate-800 font-extrabold flex items-center justify-center transition-all border border-slate-100 shadow-sm active:scale-95">
                                            <i class="fa-solid fa-minus text-xs"></i>
                                        </button>
                                        <input type="number" id="qty" name="qty" min="1" max="{{ $ticket->daily_quota }}"
                                               value="1" required class="w-12 text-center bg-transparent border-none text-slate-900 font-black text-lg focus:ring-0">
                                        <button type="button" id="qty-inc" class="w-11 h-11 rounded-xl bg-primary-600 hover:bg-primary-700 text-white font-extrabold flex items-center justify-center transition-all shadow-md shadow-primary-200 active:scale-95">
                                            <i class="fa-solid fa-plus text-xs"></i>
                                        </button>
                                    </div>
                                    
                                    <p class="mt-3 text-[10px] text-slate-400 font-bold uppercase tracking-wider flex items-center gap-1.5 ml-1">
                                        <i class="fa-solid fa-ticket text-primary-500"></i>
                                        Batas maksimal per hari: {{ $ticket->daily_quota }} tiket
                                    </p>
                                </div>
                                
                                <!-- Ticket Detail Info Box -->
                                <div class="bg-primary-50/50 border border-primary-100/50 rounded-2xl p-5 space-y-2">
                                    <p class="text-xs font-bold text-primary-900 flex items-center gap-2">
                                        <i class="fa-solid fa-tags text-primary-600"></i>
                                        Informasi Kategori Tiket
                                    </p>
                                    <p class="text-[11px] text-primary-700/80 leading-relaxed font-semibold">
                                        Tiket ini berlaku untuk 1 (satu) orang pengunjung pada tanggal terpilih. Anak-anak di atas 3 tahun wajib memiliki tiket sendiri.
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Payment Button & Live Total Display -->
                    <div class="pt-8 border-t border-slate-100">
                        <div class="flex flex-col items-stretch sm:items-center justify-center p-6 bg-gradient-to-br from-slate-900 to-slate-800 rounded-3xl text-center relative overflow-hidden shadow-xl shadow-slate-950/20">
                            <!-- Background elements -->
                            <div class="absolute -bottom-10 -left-10 w-24 h-24 bg-white/5 rounded-full"></div>
                            <div class="absolute -top-10 -right-10 w-24 h-24 bg-primary-500/10 rounded-full blur-xl"></div>
                            
                            <div class="mb-6 relative z-10">
                                <p class="text-[10px] text-slate-400 font-black uppercase tracking-widest mb-1.5">Total Estimasi Pembayaran</p>
                                <p id="total-display" class="text-4xl font-black text-white bg-gradient-to-r from-white via-primary-100 to-primary-400 bg-clip-text text-transparent">Rp {{ number_format($ticket->price, 0, ',', '.') }}</p>
                            </div>
                            
                            <div class="w-full sm:w-auto relative z-10">
                                @if(session('snap_token'))
                                    <button type="button" disabled class="w-full bg-slate-700 text-slate-400 px-6 sm:px-12 py-4 md:py-5 rounded-2xl font-extrabold text-sm md:text-base transition-all cursor-not-allowed border border-slate-600 flex items-center justify-center gap-2.5">
                                        <i class="fa-solid fa-spinner animate-spin text-base"></i> Menunggu Pembayaran
                                    </button>
                                @else
                                    <button type="submit" id="submit-btn" class="w-full bg-primary-500 hover:bg-primary-600 text-white px-6 py-4 md:py-5 rounded-2xl font-extrabold shadow-lg shadow-primary-500/20 transition-all transform hover:-translate-y-1 active:translate-y-0 disabled:opacity-50 disabled:cursor-not-allowed disabled:transform-none flex items-center justify-center gap-2.5 text-sm md:text-base tracking-wide">
                                        Bayar Sekarang <i class="fa-solid fa-arrow-right"></i>
                                    </button>
                                @endif
                            </div>
                        </div>
                        <p class="text-center text-[10px] text-slate-400 font-semibold mt-4">Dengan melanjutkan pemesanan, Anda menyetujui syarat & ketentuan pengembalian dana.</p>
                    </div>
                </form>
            </div>
        </div>

        <!-- Sticky Summary Sidebar -->
        <aside class="space-y-8">
            <div class="sticky top-28 space-y-6">
                <!-- Summary Card -->
                <div class="bg-white rounded-[2rem] border border-slate-100 p-6 md:p-8 shadow-sm overflow-hidden relative">
                    <!-- Elegant light-blue circle shape in bg -->
                    <div class="absolute top-0 right-0 w-32 h-32 bg-primary-50 rounded-full -mr-16 -mt-16 opacity-60"></div>
                    
                    <h3 class="text-lg font-black text-slate-900 mb-6 relative">Ringkasan Pesanan</h3>
                    
                    <div class="space-y-5 relative">
                        <!-- Destination Detail Row -->
                        <div class="flex items-start gap-4 pb-5 border-b border-slate-50">
                            <div class="shrink-0 w-16 h-16 rounded-2xl overflow-hidden bg-slate-100 border border-slate-100">
                                @php
                                    $coverImg = $ticket->destination->coverImage ?? $ticket->destination->images->first();
                                @endphp
                                @if($coverImg?->image_path)
                                    <img src="{{ asset('storage/' . $coverImg->image_path) }}" class="w-full h-full object-cover">
                                @else
                                    <div class="w-full h-full bg-slate-200 flex items-center justify-center text-slate-400">
                                        <i class="fa-regular fa-image"></i>
                                    </div>
                                @endif
                            </div>
                            <div class="space-y-1">
                                <span class="px-2 py-0.5 rounded-full bg-primary-50 text-primary-700 text-[9px] font-black uppercase tracking-wider">Destinasi</span>
                                <p class="text-sm font-black text-slate-900 leading-snug">{{ $ticket->destination->name }}</p>
                                <p class="text-xs text-slate-400 font-bold flex items-center gap-1">
                                    <i class="fa-solid fa-location-dot text-rose-500"></i> {{ $ticket->destination->city }}
                                </p>
                            </div>
                        </div>

                        <!-- Ticket details list -->
                        <div class="space-y-4 pt-2">
                            <div class="flex justify-between items-center text-xs">
                                <span class="text-slate-400 font-bold uppercase tracking-wider">Kategori Tiket</span>
                                <span class="text-slate-800 font-extrabold">{{ $ticket->name }}</span>
                            </div>
                            <div class="flex justify-between items-center text-xs">
                                <span class="text-slate-400 font-bold uppercase tracking-wider">Harga Satuan</span>
                                <span class="text-slate-800 font-extrabold">Rp {{ number_format($ticket->price, 0, ',', '.') }}</span>
                            </div>
                            <div class="flex justify-between items-center text-xs">
                                <span class="text-slate-400 font-bold uppercase tracking-wider">Jumlah Tiket</span>
                                <span id="summary-qty" class="text-slate-800 font-extrabold">1 Tiket</span>
                            </div>
                            
                            <div class="pt-5 border-t border-dashed border-slate-200 flex justify-between items-center">
                                <div>
                                    <span class="text-xs font-black text-slate-900 uppercase tracking-widest">Total Bayar</span>
                                    <p class="text-[9px] text-slate-400 font-bold">Sudah termasuk pajak & biaya layanan</p>
                                </div>
                                <span id="summary-total" class="text-xl font-black text-primary-600">Rp {{ number_format($ticket->price, 0, ',', '.') }}</span>
                            </div>
                        </div>
                    </div>

                    @if(session('snap_token'))
                        <div class="mt-6 pt-6 border-t border-slate-50">
                            <button id="pay-button" type="button" class="w-full bg-primary-600 hover:bg-primary-700 text-white font-extrabold py-4.5 md:py-5 rounded-2xl shadow-lg shadow-primary-600/20 transition-all flex items-center justify-center gap-3 active:scale-95 text-sm md:text-base">
                                <i class="fa-solid fa-credit-card animate-bounce text-base"></i>
                                Lanjutkan Pembayaran
                            </button>
                        </div>
                    @endif
                </div>

                <!-- Secure Checkout Trust Badge -->
                <div class="bg-slate-900 rounded-[2rem] p-7 text-white relative overflow-hidden shadow-sm">
                    <div class="absolute -bottom-6 -right-6 w-24 h-24 bg-white/5 rounded-full"></div>
                    <div class="flex items-center gap-3.5 mb-3">
                        <div class="w-9 h-9 rounded-xl bg-white/10 flex items-center justify-center text-primary-400 shrink-0">
                            <i class="fa-solid fa-shield-halved text-sm"></i>
                        </div>
                        <h4 class="font-bold text-sm">Jaminan Transaksi Aman</h4>
                    </div>
                    <p class="text-[11px] text-slate-400 leading-relaxed font-medium">Seluruh data transaksi dan pembayaran Anda dienkripsi secara penuh dan diproses melalui gateway pembayaran resmi **Midtrans**.</p>
                </div>
            </div>
        </aside>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    <script>
        const price = {{ $ticket->price }};
        const ticketId = {{ $ticket->id }};
        const storageKey = 'checkout_ticket_' + ticketId;

        const qtyInput = document.getElementById('qty');
        const qtyDec = document.getElementById('qty-dec');
        const qtyInc = document.getElementById('qty-inc');
        const dateInput = document.getElementById('booking_date');
        
        const quotaInfo = document.getElementById('quota-info');
        const quotaIndicator = document.getElementById('quota-indicator');
        const totalDisplay = document.getElementById('total-display');
        const summaryTotal = document.getElementById('summary-total');
        const summaryQty = document.getElementById('summary-qty');

        const quotaUrl = '/checkout/' + ticketId + '/quota';
        let monthlyQuotas = {};

        function formatRupiah(number) {
            return 'Rp ' + Math.round(number).toLocaleString('id-ID');
        }

        function updateTotal() {
            const qty = parseInt(qtyInput.value) || 1;
            const total = price * qty;
            totalDisplay.textContent = formatRupiah(total);
            summaryTotal.textContent = formatRupiah(total);
            summaryQty.textContent = qty + ' Tiket';
        }

        function updateQuota(date) {
            if (!date) return;
            quotaInfo.textContent = 'Memuat kuota...';
            quotaInfo.className = 'text-slate-400';
            quotaIndicator.className = 'w-2.5 h-2.5 rounded-full bg-slate-300 animate-pulse shrink-0';

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
                
                if (avail <= 0) {
                    quotaInfo.className = 'text-rose-600';
                    quotaIndicator.className = 'w-2.5 h-2.5 rounded-full bg-rose-600 shrink-0';
                    qtyInput.value = 0;
                    qtyInput.max = 0;
                } else {
                    if (avail < 10) {
                        quotaInfo.className = 'text-amber-500 font-bold';
                        quotaIndicator.className = 'w-2.5 h-2.5 rounded-full bg-amber-500 shrink-0 animate-ping';
                    } else {
                        quotaInfo.className = 'text-emerald-600';
                        quotaIndicator.className = 'w-2.5 h-2.5 rounded-full bg-emerald-600 shrink-0';
                    }
                    
                    qtyInput.max = avail;
                    
                    if (parseInt(qtyInput.value) > avail || parseInt(qtyInput.value) === 0) {
                        qtyInput.value = 1;
                    }
                }
                
                updateTotal();
                saveToStorage();
            })
            .catch(function(err) {
                quotaInfo.textContent = 'Gagal memuat data kuota';
                quotaInfo.className = 'text-rose-600';
                quotaIndicator.className = 'w-2.5 h-2.5 rounded-full bg-rose-600 shrink-0';
                console.error('Quota fetch error:', err);
            });
        }

        function fetchMonthlyQuotas(year, month) {
            const quotasUrl = '/checkout/' + ticketId + '/quotas-month?year=' + year + '&month=' + month;
            return fetch(quotasUrl, {
                headers: { 'Accept': 'application/json' }
            })
            .then(function(r) {
                if (!r.ok) throw new Error('HTTP ' + r.status);
                return r.json();
            })
            .then(function(data) {
                monthlyQuotas = data;
                fp.redraw();
            })
            .catch(function(err) {
                console.error('Error fetching monthly quotas:', err);
            });
        }

        function saveToStorage() {
            localStorage.setItem(storageKey, JSON.stringify({
                date: dateInput.value,
                qty: qtyInput.value
            }));
        }

        // Initialize Flatpickr inline calendar
        const fp = flatpickr(dateInput, {
            inline: true,
            minDate: "today",
            dateFormat: "Y-m-d",
            onMonthChange: function(selectedDates, dateStr, instance) {
                const currentMonth = instance.currentMonth + 1;
                const currentYear = instance.currentYear;
                fetchMonthlyQuotas(currentYear, currentMonth);
            },
            onYearChange: function(selectedDates, dateStr, instance) {
                const currentMonth = instance.currentMonth + 1;
                const currentYear = instance.currentYear;
                fetchMonthlyQuotas(currentYear, currentMonth);
            },
            onReady: function(selectedDates, dateStr, instance) {
                const currentMonth = instance.currentMonth + 1;
                const currentYear = instance.currentYear;
                fetchMonthlyQuotas(currentYear, currentMonth);
            },
            onChange: function(selectedDates, dateStr, instance) {
                if (dateStr) {
                    dateInput.value = dateStr;
                    updateQuota(dateStr);
                }
            },
            onDayCreate: function(dObj, dEl, fpInstance, dayElem) {
                const year = dayElem.dateObj.getFullYear();
                const month = String(dayElem.dateObj.getMonth() + 1).padStart(2, '0');
                const date = String(dayElem.dateObj.getDate()).padStart(2, '0');
                const dateStr = year + '-' + month + '-' + date;
                
                if (monthlyQuotas[dateStr] !== undefined) {
                    const quota = monthlyQuotas[dateStr];
                    if (quota === 0) {
                        dayElem.classList.add('flatpickr-disabled', 'disabled', 'day-quota-danger');
                        dayElem.title = 'Tiket Habis';
                    } else if (quota < 10) {
                        dayElem.classList.add('day-quota-warning');
                        dayElem.title = quota + ' tiket tersisa';
                    } else {
                        dayElem.classList.add('day-quota-safe');
                        dayElem.title = quota + ' tiket tersisa';
                    }
                }
            }
        });

        function restoreFromStorage() {
            try {
                const saved = JSON.parse(localStorage.getItem(storageKey));
                if (!saved) return;
                if (saved.date) {
                    fp.setDate(saved.date, true);
                }
                if (saved.qty) {
                    qtyInput.value = saved.qty;
                    updateTotal();
                }
            } catch(e) {}
        }

        window.addEventListener('beforeunload', saveToStorage);

        // Custom increment / decrement button functionality
        qtyDec.addEventListener('click', function() {
            let val = parseInt(qtyInput.value) || 1;
            if (val > 1) {
                qtyInput.value = val - 1;
                updateTotal();
                saveToStorage();
            }
        });

        qtyInc.addEventListener('click', function() {
            let val = parseInt(qtyInput.value) || 1;
            let maxVal = parseInt(qtyInput.max) || {{ $ticket->daily_quota }};
            if (val < maxVal) {
                qtyInput.value = val + 1;
                updateTotal();
                saveToStorage();
            }
        });

        document.getElementById('checkout-form').addEventListener('submit', function() {
            saveToStorage();
            const submitBtn = document.getElementById('submit-btn');
            if (submitBtn) {
                setTimeout(() => {
                    submitBtn.disabled = true;
                    submitBtn.innerHTML = '<i class="fa-solid fa-spinner animate-spin"></i> Memproses...';
                }, 10);
            }
        });

        qtyInput.addEventListener('input', function() {
            let val = parseInt(qtyInput.value) || 1;
            let maxVal = parseInt(qtyInput.max) || {{ $ticket->daily_quota }};
            if (val < 1) qtyInput.value = 1;
            if (val > maxVal) qtyInput.value = maxVal;
            
            updateTotal();
            saveToStorage();
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
