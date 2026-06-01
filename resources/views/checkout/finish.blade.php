@extends('layouts.app')

@push('styles')
<style>
    [x-cloak] { display: none !important; }
    /* Premium ticket-like look with tear-off border */
    .receipt-card {
        background: #ffffff;
        position: relative;
        border-radius: 2rem;
        border: 1px solid #f1f5f9;
        box-shadow: 0 10px 30px -5px rgba(0, 0, 0, 0.03);
    }
    .receipt-card::before, .receipt-card::after {
        content: '';
        position: absolute;
        width: 24px;
        height: 24px;
        background: #F8FAFC; /* Matches body background */
        border-radius: 50%;
        top: 65%;
        z-index: 10;
        border: 1px solid #f1f5f9;
    }
    .receipt-card::before {
        left: -12px;
        box-shadow: inset -4px 0 6px -4px rgba(0,0,0,0.05);
    }
    .receipt-card::after {
        right: -12px;
        box-shadow: inset 4px 0 6px -4px rgba(0,0,0,0.05);
    }
    .receipt-divider {
        position: absolute;
        top: 65%;
        left: 12px;
        right: 12px;
        border-top: 2px dashed #cbd5e1;
        transform: translateY(11px);
    }
</style>
@endpush

@section('content')
    <!-- Breadcrumbs -->
    <nav class="mb-8 flex items-center gap-2 text-sm px-4 md:px-0">
        <a href="{{ route('home') }}" class="text-slate-400 hover:text-primary-600 transition-colors font-medium">Beranda</a>
        <svg class="w-4 h-4 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
        <span class="text-slate-950 font-bold">Status Transaksi</span>
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
                    <div class="w-10 h-10 rounded-2xl bg-emerald-50 text-emerald-600 flex items-center justify-center font-bold text-sm shadow-sm shrink-0 border border-emerald-100">
                        <i class="fa-solid fa-check text-xs"></i>
                    </div>
                    <div>
                        <p class="text-[10px] text-slate-400 font-bold uppercase tracking-widest">Langkah 3</p>
                        <p class="text-xs md:text-sm font-bold text-slate-700">Pembayaran</p>
                    </div>
                </div>
                
                <!-- Step 4 -->
                <div class="flex items-center gap-3">
                    @if($transaction && in_array($transaction->status, ['settlement', 'success']))
                        <div class="w-10 h-10 rounded-2xl bg-primary-600 text-white flex items-center justify-center font-bold text-sm shadow-lg shadow-primary-200 shrink-0">
                            4
                        </div>
                        <div>
                            <p class="text-[10px] text-primary-500 font-bold uppercase tracking-widest">Langkah 4</p>
                            <p class="text-xs md:text-sm font-black text-slate-900">Tiket Terbit</p>
                        </div>
                    @else
                        <div class="w-10 h-10 rounded-2xl bg-amber-500 text-white flex items-center justify-center font-bold text-sm shadow-lg shadow-amber-200 shrink-0 animate-pulse">
                            3
                        </div>
                        <div>
                            <p class="text-[10px] text-amber-500 font-bold uppercase tracking-widest">Langkah 3</p>
                            <p class="text-xs md:text-sm font-black text-slate-900">Menunggu Pembayaran</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <div class="max-w-2xl mx-auto px-4 md:px-0 py-4" x-data="{ showZoomModal: false }">
        @php($displayStatus = $status ?? ($transaction->status ?? 'not_found'))
        @php($showQr = $showQr ?? false)

        @if($transaction && $displayStatus === 'settlement')
            <!-- ================== SUCCESS STATE ================== -->
            <div class="receipt-card p-8 md:p-10 text-center relative overflow-hidden">
                <!-- Sparkle Background -->
                <div class="absolute -top-10 -right-10 w-36 h-36 bg-emerald-500/5 rounded-full blur-2xl"></div>
                <div class="absolute -bottom-10 -left-10 w-36 h-36 bg-primary-500/5 rounded-full blur-2xl"></div>
                
                <!-- Celebrating Icon -->
                <div class="mb-6 relative">
                    <div class="w-20 h-20 rounded-full bg-emerald-50 text-emerald-600 flex items-center justify-center mx-auto shadow-md shadow-emerald-100/50 border border-emerald-100">
                        <i class="fa-solid fa-circle-check text-4xl animate-bounce"></i>
                    </div>
                </div>

                <h1 class="text-3xl font-black text-slate-900 mb-2">Pembayaran Berhasil!</h1>
                <p class="text-xs text-slate-400 font-bold tracking-wide uppercase">E-Tiket Anda Telah Aktif</p>
                <p class="text-xs text-slate-500 font-medium max-w-md mx-auto mt-4 leading-relaxed">
                    Terima kasih atas pesanan Anda. Transaksi Anda telah dikonfirmasi. Rincian e-ticket kini tersedia dan siap digunakan untuk liburan Anda.
                </p>

                <!-- Receipt Detail Layout (Upper Tear-off Part) -->
                <div class="mt-8 bg-slate-50 rounded-2xl p-6 border border-slate-100 text-left grid md:grid-cols-2 gap-x-6 gap-y-4">
                    <div>
                        <p class="text-[9px] font-bold text-slate-400 uppercase tracking-widest mb-0.5">ID Transaksi / Order ID</p>
                        <p class="font-extrabold text-slate-900 text-xs break-all">{{ $transaction->order_id }}</p>
                    </div>
                    <div>
                        <p class="text-[9px] font-bold text-slate-400 uppercase tracking-widest mb-0.5">Status Pembayaran</p>
                        <span class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-full bg-emerald-100 text-emerald-700 text-[10px] font-black">
                            <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span>
                            {{ strtoupper($transaction->status === 'settlement' ? 'Berhasil' : $transaction->status) }}
                        </span>
                    </div>
                    <div>
                        <p class="text-[9px] font-bold text-slate-400 uppercase tracking-widest mb-0.5">Destinasi Wisata</p>
                        <p class="font-extrabold text-slate-800 text-xs">{{ $transaction->ticket ? $transaction->ticket->destination->name : 'N/A' }}</p>
                    </div>
                    <div>
                        <p class="text-[9px] font-bold text-slate-400 uppercase tracking-widest mb-0.5">Tanggal Kunjungan</p>
                        <p class="font-extrabold text-slate-800 text-xs"><i class="fa-regular fa-calendar-days text-primary-500 mr-1.5"></i>{{ optional($transaction->booking_date)->format('d M Y') }}</p>
                    </div>
                    <div>
                        <p class="text-[9px] font-bold text-slate-400 uppercase tracking-widest mb-0.5">Jumlah Kunjungan / Pax</p>
                        <p class="font-extrabold text-slate-800 text-xs">{{ $transaction->qty }} Pengunjung</p>
                    </div>
                    <div>
                        <p class="text-[9px] font-bold text-slate-400 uppercase tracking-widest mb-0.5">Nama Pemegang Tiket</p>
                        <p class="font-extrabold text-slate-800 text-xs">{{ $transaction->user->name }}</p>
                    </div>
                </div>

                <!-- Dotted Tear-off Divider -->
                <div class="receipt-divider"></div>

                @if($showQr)
                <!-- Live QR Code & Live Total (Lower Tear-off Part) -->
                <div class="mt-20 flex flex-col items-center justify-center pt-2">
                    <div class="bg-white p-3 rounded-2xl border border-slate-100 shadow-sm mb-3 inline-block cursor-pointer hover:scale-105 transition-all duration-300 shadow-slate-200/50"
                         @click="showZoomModal = true"
                         title="Klik untuk memperbesar">
                        <div class="p-2 bg-white inline-block">
                            {!! QrCode::size(120)->generate($transaction->qr_code_token) !!}
                        </div>
                    </div>
                    <p class="text-[10px] text-slate-400 font-extrabold uppercase tracking-widest mb-1">Tunjukkan QR Code ini di pintu masuk</p>
                    <p class="text-[10px] text-primary-500 font-bold uppercase tracking-wider mb-5 cursor-pointer hover:underline flex items-center gap-1"
                       @click="showZoomModal = true">
                        <i class="fa-solid fa-magnifying-glass-plus"></i> Klik untuk memperbesar
                    </p>

                    <div class="w-full flex justify-between items-center bg-slate-50 border border-slate-100 rounded-2xl px-6 py-4">
                        <span class="text-xs font-black text-slate-900 uppercase tracking-widest">Total Pembayaran</span>
                        <span class="text-2xl font-black text-primary-600">Rp {{ number_format($transaction->total_price, 0, ',', '.') }}</span>
                    </div>
                </div>
                @else
                <div class="mt-8 bg-emerald-50 border border-emerald-100 rounded-2xl p-5 text-center">
                    <p class="text-xs font-bold text-emerald-800">Pembayaran berhasil dikonfirmasi. E-tiket tersedia di menu Riwayat Pesanan Anda.</p>
                </div>
                @endif

                <!-- Page Redirections -->
                <div class="mt-10 flex flex-col sm:flex-row items-stretch sm:items-center justify-center gap-4 pt-4 w-full">
                    <a href="{{ route('history.index') }}" class="w-full sm:w-auto bg-primary-600 hover:bg-primary-700 text-white font-extrabold px-6 sm:px-12 py-4 md:py-4.5 rounded-2xl shadow-lg shadow-primary-600/20 transition-all text-sm md:text-base uppercase tracking-wider flex items-center justify-center gap-2">
                        <i class="fa-solid fa-ticket text-base"></i> Lihat E-Tiket Saya
                    </a>
                    <a href="{{ route('home') }}" class="w-full sm:w-auto bg-white border border-slate-200 text-slate-700 font-extrabold px-6 sm:px-12 py-4 md:py-4.5 rounded-2xl hover:bg-slate-50 transition-all text-sm md:text-base uppercase tracking-wider text-center">
                        Ke Beranda
                    </a>
                </div>
            </div>

        @elseif($transaction && $displayStatus === 'late_payment_rejected')
            <div class="bg-white rounded-[2.5rem] p-8 md:p-12 border border-amber-100 shadow-sm text-center">
                <div class="w-20 h-20 rounded-full bg-amber-50 text-amber-600 flex items-center justify-center mx-auto mb-6">
                    <i class="fa-solid fa-clock text-3xl"></i>
                </div>
                <h1 class="text-3xl font-black text-slate-900 mb-2">Pembayaran Tidak Dapat Diproses</h1>
                <p class="text-xs text-slate-500 font-medium max-w-md mx-auto mt-4 leading-relaxed">
                    Pembayaran diterima setelah batas waktu {{ \App\Models\Transaction::paymentTimeoutLabel() }}. Pesanan telah dibatalkan dan kuota dikembalikan.
                    Dana yang terpotong akan diproses refund melalui tim support — hubungi kami dengan Order ID Anda.
                </p>
                <p class="text-xs font-black text-slate-700 mt-4 break-all">{{ $transaction->order_id }}</p>
                <div class="mt-8 flex flex-col sm:flex-row gap-3 justify-center">
                    <a href="{{ route('contact') }}" class="bg-primary-600 hover:bg-primary-700 text-white font-extrabold px-8 py-4 rounded-2xl text-sm uppercase tracking-wider">Hubungi Support</a>
                    <a href="{{ route('history.index') }}" class="bg-white border border-slate-200 text-slate-700 font-extrabold px-8 py-4 rounded-2xl text-sm uppercase tracking-wider">Riwayat Pesanan</a>
                </div>
            </div>

        @elseif($transaction && ($displayStatus === 'expire' || $transaction->status === 'expire'))
            <div class="bg-white rounded-[2.5rem] p-8 md:p-12 border border-slate-100 shadow-sm text-center">
                <div class="w-20 h-20 rounded-full bg-slate-100 text-slate-500 flex items-center justify-center mx-auto mb-6">
                    <i class="fa-solid fa-hourglass-end text-3xl"></i>
                </div>
                <h1 class="text-3xl font-black text-slate-900 mb-2">Batas Waktu Pembayaran Habis</h1>
                <p class="text-xs text-slate-500 font-medium max-w-md mx-auto mt-4 leading-relaxed">
                    Pesanan dibatalkan otomatis setelah {{ \App\Models\Transaction::paymentTimeoutLabel() }}. Kuota tiket telah dikembalikan dan kode Virtual Account / QRIS tidak lagi berlaku di sistem kami.
                </p>
                <div class="mt-8">
                    <a href="{{ route('destinations.index') }}" class="inline-flex bg-primary-600 hover:bg-primary-700 text-white font-extrabold px-8 py-4 rounded-2xl text-sm uppercase tracking-wider">Pesan Tiket Baru</a>
                </div>
            </div>

        @elseif($transaction && $displayStatus === 'pending')
            <!-- ================== PENDING STATE ================== -->
            <div class="bg-white rounded-[2.5rem] p-8 md:p-12 border border-slate-100 shadow-sm text-center relative overflow-hidden">
                <div class="absolute -top-10 -right-10 w-36 h-36 bg-amber-500/5 rounded-full blur-2xl"></div>
                
                <!-- Pending Animation Icon -->
                <div class="mb-6 relative">
                    <div class="w-20 h-20 rounded-full bg-amber-50 text-amber-600 flex items-center justify-center mx-auto shadow-md shadow-amber-100/50 border border-amber-100">
                        <i class="fa-solid fa-hourglass-half text-3xl animate-spin"></i>
                    </div>
                </div>

                <h1 class="text-3xl font-black text-slate-900 mb-2">Menunggu Pembayaran</h1>
                <p class="text-xs text-slate-400 font-bold tracking-wide uppercase">Selesaikan Pembayaran Anda Segera</p>
                <p class="text-xs text-slate-500 font-medium max-w-md mx-auto mt-4 leading-relaxed">
                    Kami telah mengamankan tiket liburan Anda. Silakan lanjutkan ke portal pembayaran di bawah untuk menyelesaikan pembayaran.
                </p>

                <!-- Transaction summary box -->
                <div class="mt-8 bg-slate-50 rounded-2xl p-6 border border-slate-100 text-left space-y-4 max-w-md mx-auto">
                    <div class="flex justify-between items-center text-xs">
                        <span class="text-slate-400 font-bold uppercase tracking-wider">Order ID</span>
                        <span class="font-extrabold text-slate-900 break-all">{{ $transaction->order_id }}</span>
                    </div>
                    <div class="flex justify-between items-center text-xs">
                        <span class="text-slate-400 font-bold uppercase tracking-wider">Destinasi</span>
                        <span class="font-extrabold text-slate-800">{{ $transaction->ticket ? $transaction->ticket->destination->name : 'N/A' }}</span>
                    </div>
                    <div class="flex justify-between items-center text-xs">
                        <span class="text-slate-400 font-bold uppercase tracking-wider">Total Harus Dibayar</span>
                        <span class="text-base font-black text-amber-600">Rp {{ number_format($transaction->total_price, 0, ',', '.') }}</span>
                    </div>
                </div>

                <!-- CTAs -->
                <div class="mt-10 flex flex-col sm:flex-row items-stretch sm:items-center justify-center gap-4 pt-4 max-w-md mx-auto">
                    <a href="{{ route('checkout.resume', ['order_id' => $transaction->order_id]) }}" class="w-full bg-amber-500 hover:bg-amber-600 text-white font-extrabold px-6 sm:px-12 py-4 md:py-4.5 rounded-2xl shadow-lg shadow-amber-500/20 transition-all text-sm md:text-base uppercase tracking-wider flex items-center justify-center gap-2">
                        <i class="fa-solid fa-credit-card text-base"></i> Lanjutkan Pembayaran
                    </a>
                </div>
            </div>

        @elseif($displayStatus === 'not_found')
            <div class="bg-white rounded-[2.5rem] p-8 md:p-12 border border-slate-100 shadow-sm text-center">
                <h1 class="text-2xl font-black text-slate-900 mb-2">Transaksi Tidak Ditemukan</h1>
                <p class="text-xs text-slate-500 font-medium">Order ID tidak valid atau tidak terkait dengan akun Anda.</p>
                <a href="{{ route('history.index') }}" class="inline-block mt-6 text-primary-600 font-bold text-sm">Ke Riwayat Pesanan</a>
            </div>

        @else
            <!-- ================== FAILED/ERROR STATE ================== -->
            <div class="bg-white rounded-[2.5rem] p-8 md:p-12 border border-slate-100 shadow-sm text-center relative overflow-hidden">
                <div class="absolute -top-10 -right-10 w-36 h-36 bg-rose-500/5 rounded-full blur-2xl"></div>
                
                <div class="mb-6 relative">
                    <div class="w-20 h-20 rounded-full bg-rose-50 text-rose-600 flex items-center justify-center mx-auto shadow-md shadow-rose-100/50 border border-rose-100">
                        <i class="fa-solid fa-circle-xmark text-4xl"></i>
                    </div>
                </div>

                <h1 class="text-3xl font-black text-slate-900 mb-2">Transaksi Gagal</h1>
                <p class="text-xs text-slate-400 font-bold tracking-wide uppercase">Pembayaran Gagal Diproses</p>
                <p class="text-xs text-slate-500 font-medium max-w-md mx-auto mt-4 leading-relaxed">
                    Mohon maaf, transaksi pembayaran Anda tidak dapat diselesaikan oleh pihak gateway. Silakan coba kembali dengan metode pembayaran lain atau hubungi call center kami.
                </p>

                <!-- Help Desk Card -->
                <div class="mt-8 bg-slate-50 border border-slate-100 p-6 rounded-2xl text-left max-w-md mx-auto flex gap-4 items-start">
                    <div class="w-10 h-10 rounded-xl bg-primary-50 text-primary-600 flex items-center justify-center shrink-0">
                        <i class="fa-solid fa-headset text-sm"></i>
                    </div>
                    <div>
                        <h4 class="text-xs font-black text-slate-900 mb-0.5">Butuh Bantuan Segera?</h4>
                        <p class="text-[10px] text-slate-400 font-semibold mb-2">Customer support kami siap membantu permasalahan Anda 24/7.</p>
                        <p class="text-xs font-bold text-slate-700 flex items-center gap-1.5">
                            <i class="fa-regular fa-envelope text-slate-400"></i> support@tabibito.com
                        </p>
                    </div>
                </div>

                <!-- CTAs -->
                <div class="mt-10 flex flex-col sm:flex-row items-stretch sm:items-center justify-center gap-4 pt-4 max-w-md mx-auto">
                    <a href="{{ route('destinations.index') }}" class="w-full bg-rose-600 hover:bg-rose-700 text-white font-extrabold px-6 sm:px-12 py-4 md:py-4.5 rounded-2xl shadow-lg shadow-rose-600/20 transition-all text-sm md:text-base uppercase tracking-wider flex items-center justify-center gap-2">
                        <i class="fa-solid fa-arrow-rotate-right text-base"></i> Pesan Tiket Baru
                    </a>
                    <a href="{{ route('home') }}" class="w-full bg-white border border-slate-200 text-slate-700 font-extrabold px-6 sm:px-12 py-4 md:py-4.5 rounded-2xl hover:bg-slate-50 transition-all text-sm md:text-base uppercase tracking-wider text-center">
                        Kembali Ke Beranda
                    </a>
                </div>
            </div>
        @endif

        @if($transaction && ($showQr ?? false))
            <!-- QR Code Zoom Modal -->
            <div x-show="showZoomModal" 
                 class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-slate-900/60 backdrop-blur-sm"
                 x-transition:enter="transition ease-out duration-300"
                 x-transition:enter-start="opacity-0"
                 x-transition:enter-end="opacity-100"
                 x-transition:leave="transition ease-in duration-200"
                 x-transition:leave-start="opacity-100"
                 x-transition:leave-end="opacity-0"
                 @click.self="showZoomModal = false"
                 x-cloak>
                
                <div class="bg-white rounded-[2.5rem] p-6 md:p-8 max-w-sm w-full border border-slate-100 shadow-2xl relative transform transition-all"
                     x-transition:enter="transition ease-out duration-300"
                     x-transition:enter-start="opacity-0 scale-95"
                     x-transition:enter-end="opacity-100 scale-100"
                     x-transition:leave="transition ease-in duration-200"
                     x-transition:leave-start="opacity-100 scale-100"
                     x-transition:leave-end="opacity-0 scale-95"
                     @click.stop>
                    
                    <!-- Close Button -->
                    <button @click="showZoomModal = false" class="absolute top-4 right-4 w-9 h-9 rounded-full bg-slate-50 hover:bg-slate-100 text-slate-400 hover:text-slate-600 transition-colors flex items-center justify-center border border-slate-100">
                        <i class="fa-solid fa-xmark text-sm"></i>
                    </button>
                    
                    <div class="text-center mt-2">
                        <span class="px-3 py-1 rounded-full bg-emerald-50 text-emerald-700 text-[10px] font-black uppercase tracking-wider mb-3 inline-block">
                            E-Tiket Digital
                        </span>
                        <h3 class="text-lg font-black text-slate-900 mb-1">{{ $transaction->order_id }}</h3>
                        <p class="text-xs text-slate-400 font-bold tracking-wide uppercase mb-6">Tunjukkan ke Petugas Loket</p>
                        
                        <!-- Zoomed QR Code Wrapper -->
                        <div class="bg-white p-4 rounded-3xl border border-slate-100 shadow-inner mb-6 inline-block">
                            <img src="https://api.qrserver.com/v1/create-qr-code/?size=300x300&data={{ urlencode($transaction->qr_code_token) }}" 
                                 class="w-64 h-64 mx-auto block rounded-2xl" 
                                 alt="QR Code">
                        </div>
                        
                        <div class="bg-slate-50 border border-slate-100/50 rounded-2xl p-4">
                            <p class="text-[10px] text-slate-400 font-extrabold uppercase tracking-widest mb-1.5">Kode Manual Tiket</p>
                            <p class="text-xs font-mono font-black text-emerald-800 bg-emerald-50/50 border border-emerald-100/30 py-2 px-4 rounded-xl break-all">{{ $transaction->qr_code_token }}</p>
                        </div>
                    </div>
                </div>
            </div>
        @endif
    </div>
@endsection
