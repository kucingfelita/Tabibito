@extends('layouts.app')

@section('content')
    <div class="max-w-4xl mx-auto py-12 px-4">
        <div class="bg-white rounded-[2.5rem] p-8 md:p-12 border border-slate-100 shadow-xl shadow-slate-200/50">
            <div class="flex items-center gap-6 mb-12 pb-8 border-b border-slate-50">
                <div class="w-16 h-16 rounded-2xl bg-primary-600 flex items-center justify-center text-white shadow-lg shadow-primary-200">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"/></svg>
                </div>
                <div>
                    <h2 class="text-3xl font-black text-slate-900">Lanjutkan Pembayaran</h2>
                    <p class="text-slate-500 font-medium">Selesaikan transaksi Anda untuk mendapatkan tiket.</p>
                </div>
            </div>

            @if($transaction->snap_token)
                <div class="grid gap-12 lg:grid-cols-2">
                    <div class="space-y-8">
                        <div>
                            <label class="block text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-3 ml-1">Detail Pemesan</label>
                            <div class="space-y-4">
                                <div class="bg-slate-50 rounded-2xl p-4 flex items-center gap-4">
                                    <div class="w-10 h-10 rounded-xl bg-white flex items-center justify-center text-slate-400">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                                    </div>
                                    <div>
                                        <p class="text-[10px] font-bold text-slate-400 uppercase tracking-tight">Nama</p>
                                        <p class="font-bold text-slate-800">{{ $transaction->user->name }}</p>
                                    </div>
                                </div>
                                <div class="bg-slate-50 rounded-2xl p-4 flex items-center gap-4">
                                    <div class="w-10 h-10 rounded-xl bg-white flex items-center justify-center text-slate-400">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                                    </div>
                                    <div>
                                        <p class="text-[10px] font-bold text-slate-400 uppercase tracking-tight">Tanggal Kunjungan</p>
                                        <p class="font-bold text-slate-800">{{ $transaction->booking_date->format('d M Y') }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <button id="pay-button" type="button" class="w-full bg-primary-600 hover:bg-primary-700 text-white font-black py-5 rounded-2xl shadow-xl shadow-primary-600/30 transition-all transform hover:-translate-y-1 flex items-center justify-center gap-3">
                            <svg class="w-6 h-6 animate-pulse" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M4 4a2 2 0 00-2 2v4a2 2 0 002 2V6h10a2 2 0 00-2-2H4zm2 6a2 2 0 012-2h8a2 2 0 012 2v4a2 2 0 01-2 2H8a2 2 0 01-2-2v-4zm6 4a2 2 0 100-4 2 2 0 000 4z" clip-rule="evenodd"/></svg>
                            Bayar Sekarang
                        </button>
                    </div>

                    <div class="bg-slate-900 rounded-[2rem] p-10 text-white relative overflow-hidden">
                        <div class="absolute top-0 right-0 w-32 h-32 bg-white/5 rounded-full -mr-16 -mt-16"></div>
                        <h3 class="text-xl font-bold mb-8 relative">Ringkasan Tiket</h3>
                        
                        <div class="space-y-6 relative">
                            <div class="pb-6 border-b border-white/10">
                                <p class="text-primary-400 text-xs font-bold uppercase tracking-widest mb-1">{{ optional($transaction->ticket->destination)->name }}</p>
                                <p class="text-xl font-black">{{ $transaction->ticket->name }}</p>
                            </div>
                            
                            <div class="space-y-4">
                                <div class="flex justify-between items-center text-sm">
                                    <span class="text-slate-400 font-medium">Harga Satuan</span>
                                    <span class="font-bold">Rp {{ number_format($transaction->ticket->price, 0, ',', '.') }}</span>
                                </div>
                                <div class="flex justify-between items-center text-sm">
                                    <span class="text-slate-400 font-medium">Jumlah Tiket</span>
                                    <span class="font-bold">{{ $transaction->qty }}x</span>
                                </div>
                            </div>
                            
                            <div class="pt-6 border-t border-dashed border-white/20">
                                <p class="text-slate-400 text-xs font-bold uppercase tracking-widest mb-1">Total Pembayaran</p>
                                <p class="text-3xl font-black text-primary-400">Rp {{ number_format($transaction->total_price, 0, ',', '.') }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            @else
                <div class="bg-rose-50 border border-rose-100 p-8 rounded-[2rem] text-center">
                    <div class="w-16 h-16 rounded-full bg-rose-100 flex items-center justify-center text-rose-600 mx-auto mb-6">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
                    </div>
                    <p class="text-rose-900 font-bold text-lg mb-2">Terjadi Kesalahan</p>
                    <p class="text-rose-600/70 font-medium">Maaf, terjadi kesalahan dalam memuat pembayaran. Silakan coba lagi nanti atau hubungi bantuan.</p>
                </div>
            @endif
        </div>
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
