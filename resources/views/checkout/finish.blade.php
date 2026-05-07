@extends('layouts.app')

@section('content')
    <div class="max-w-4xl mx-auto py-12 px-4">
        <div class="bg-white rounded-[2.5rem] p-8 md:p-12 border border-slate-100 shadow-xl shadow-slate-200/50 text-center">
            
            @if($transaction && in_array($transaction->status, ['settlement', 'success']))
                <!-- Success State -->
                <div class="mb-10">
                    <div class="w-24 h-24 rounded-full bg-emerald-100 flex items-center justify-center text-emerald-600 mx-auto mb-8 animate-bounce">
                        <svg class="w-12 h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                    </div>
                    <h1 class="text-4xl font-black text-slate-900 mb-4">Pembayaran Berhasil!</h1>
                    <p class="text-slate-500 font-medium max-w-lg mx-auto">Terima kasih atas pesanan Anda. Tiket Anda telah aktif dan siap digunakan. Detail transaksi telah kami kirimkan ke email Anda.</p>
                </div>

                <div class="bg-slate-50 rounded-[2rem] p-8 md:p-10 mb-10 text-left">
                    <div class="grid md:grid-cols-2 gap-8">
                        <div>
                            <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-1">Order ID</p>
                            <p class="font-black text-slate-900 break-all">{{ $transaction->order_id }}</p>
                        </div>
                        <div>
                            <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-1">Status</p>
                            <span class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-emerald-100 text-emerald-700 text-xs font-bold">
                                <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span>
                                {{ ucfirst($transaction->status) }}
                            </span>
                        </div>
                        <div>
                            <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-1">Destinasi</p>
                            <p class="font-bold text-slate-700">{{ $transaction->ticket ? $transaction->ticket->destination->name : 'N/A' }}</p>
                        </div>
                        <div>
                            <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-1">Tanggal Kunjungan</p>
                            <p class="font-bold text-slate-700">{{ optional($transaction->booking_date)->format('d M Y') }}</p>
                        </div>
                    </div>
                    <div class="mt-8 pt-8 border-t border-slate-200 flex justify-between items-center">
                        <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">Total Pembayaran</p>
                        <p class="text-2xl font-black text-primary-600">Rp {{ number_format($transaction->total_price, 0, ',', '.') }}</p>
                    </div>
                </div>

                <div class="flex flex-col sm:flex-row items-center justify-center gap-4">
                    <a href="{{ route('history.index') }}" class="w-full sm:w-auto bg-primary-600 hover:bg-primary-700 text-white font-black px-10 py-4 rounded-2xl shadow-xl shadow-primary-600/30 transition-all transform hover:-translate-y-1">
                        Lihat Tiket Saya
                    </a>
                    <a href="{{ route('home') }}" class="w-full sm:w-auto bg-white border border-slate-200 text-slate-700 font-black px-10 py-4 rounded-2xl hover:bg-slate-50 transition-all">
                        Kembali ke Beranda
                    </a>
                </div>

            @elseif($transaction && $transaction->status === 'pending')
                <!-- Pending State -->
                <div class="mb-10">
                    <div class="w-24 h-24 rounded-full bg-amber-100 flex items-center justify-center text-amber-600 mx-auto mb-8 animate-pulse">
                        <svg class="w-12 h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    </div>
                    <h1 class="text-4xl font-black text-slate-900 mb-4 text-amber-600">Menunggu Pembayaran</h1>
                    <p class="text-slate-500 font-medium max-w-lg mx-auto">Segera selesaikan pembayaran Anda sebelum waktu habis untuk mengamankan tiket Anda.</p>
                </div>

                <div class="bg-slate-50 rounded-[2rem] p-8 md:p-10 mb-10 text-left border-l-4 border-amber-400">
                    <div class="grid md:grid-cols-2 gap-8">
                        <div>
                            <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-1">Order ID</p>
                            <p class="font-black text-slate-900">{{ $transaction->order_id }}</p>
                        </div>
                        <div>
                            <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-1">Total Harus Dibayar</p>
                            <p class="text-xl font-black text-slate-900">Rp {{ number_format($transaction->total_price, 0, ',', '.') }}</p>
                        </div>
                    </div>
                </div>

                <div class="flex flex-col sm:flex-row items-center justify-center gap-4">
                    <a href="{{ route('checkout.resume', ['order_id' => $transaction->order_id]) }}" class="w-full sm:w-auto bg-amber-500 hover:bg-amber-600 text-white font-black px-10 py-4 rounded-2xl shadow-xl shadow-amber-500/30 transition-all transform hover:-translate-y-1">
                        Lanjutkan Pembayaran
                    </a>
                    <a href="{{ route('history.index') }}" class="w-full sm:w-auto bg-white border border-slate-200 text-slate-700 font-black px-10 py-4 rounded-2xl hover:bg-slate-50 transition-all">
                        Riwayat Transaksi
                    </a>
                </div>

            @else
                <!-- Failed/Error State -->
                <div class="mb-10">
                    <div class="w-24 h-24 rounded-full bg-rose-100 flex items-center justify-center text-rose-600 mx-auto mb-8">
                        <svg class="w-12 h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                    </div>
                    <h1 class="text-4xl font-black text-slate-900 mb-4 text-rose-600">Transaksi Gagal</h1>
                    <p class="text-slate-500 font-medium max-w-lg mx-auto">Mohon maaf, pembayaran Anda tidak dapat kami proses. Silakan coba kembali atau hubungi layanan pelanggan kami jika kendala berlanjut.</p>
                </div>

                <div class="flex flex-col sm:flex-row items-center justify-center gap-4">
                    <a href="{{ $transaction ? route('checkout.resume', ['order_id' => $transaction->order_id]) : '#' }}" class="w-full sm:w-auto bg-primary-600 hover:bg-primary-700 text-white font-black px-10 py-4 rounded-2xl shadow-xl shadow-primary-600/30 transition-all transform hover:-translate-y-1">
                        Coba Lagi
                    </a>
                    <a href="{{ route('home') }}" class="w-full sm:w-auto bg-white border border-slate-200 text-slate-700 font-black px-10 py-4 rounded-2xl hover:bg-slate-50 transition-all">
                        Kembali ke Beranda
                    </a>
                </div>
            @endif
        </div>
    </div>
@endsection
