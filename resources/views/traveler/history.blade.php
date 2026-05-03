@extends('layouts.app')

@section('content')
    <h1 class="text-xl font-semibold">Riwayat Pembelian</h1>
    
    <!-- Responsive Transaction List -->
    <div class="mt-4 space-y-3">
        @foreach($transactions as $trx)
            <div class="rounded-xl bg-white p-4 shadow-sm">
                <p class="font-semibold text-base md:text-lg">{{ $trx->ticket->destination->name }} - {{ $trx->ticket->name }}</p>
                <p class="text-sm text-slate-500 mt-1">Status: {{ strtoupper($trx->status) }} | Tanggal booking: {{ $trx->booking_date->format('d M Y') }}</p>
                <p class="text-sm text-slate-600 mt-1 font-medium">Jumlah Tiket: <span class="text-emerald-700 font-bold">{{ $trx->qty }} orang</span></p>
                <p class="text-base md:text-lg font-medium mt-1">Total: Rp {{ number_format($trx->total_price, 0, ',', '.') }}</p>
                
                @if($trx->status === 'pending')
                    <div class="mt-3 flex flex-col sm:flex-row gap-2">
                        <a href="{{ route('checkout.resume', ['order_id' => $trx->order_id]) }}" class="inline-block rounded-lg bg-cyan-600 px-4 py-2 text-sm font-medium text-white text-center">Lanjutkan Pembayaran</a>
                        <form method="POST" action="{{ route('history.checkStatus', $trx) }}" class="inline">
                            @csrf
                            <button type="submit" class="rounded-lg bg-orange-600 px-4 py-2 text-sm font-medium text-white">Periksa Status</button>
                        </form>
                    </div>
                @elseif($trx->status === 'settlement')
                    <div class="mt-4 flex flex-col items-center md:items-start gap-3">
                        <div class="w-full rounded-lg bg-emerald-50 border border-emerald-200 px-4 py-3 flex items-center gap-3">
                            <span class="text-3xl font-black text-emerald-700">{{ $trx->qty }}</span>
                            <div>
                                <p class="font-semibold text-emerald-800">{{ $trx->qty == 1 ? '1 Tiket / 1 Orang' : $trx->qty . ' Tiket / ' . $trx->qty . ' Orang' }}</p>
                                <p class="text-xs text-slate-500">Tunjukkan 1 QR code ini kepada petugas untuk {{ $trx->qty }} orang</p>
                            </div>
                        </div>
                        <div class="rounded-lg border-2 border-dashed border-emerald-200 p-2">
                            {!! QrCode::size(200)->generate($trx->qr_code_token) !!}
                        </div>
                        <div class="text-center md:text-left">
                            <p class="text-xs text-slate-500">Atau gunakan kode tiket manual:</p>
                            <p class="font-mono font-bold text-emerald-700 bg-emerald-50 px-3 py-1 mt-1 rounded-md border border-emerald-100 inline-block">{{ $trx->qr_code_token }}</p>
                        </div>
                    </div>
                @endif
            </div>
        @endforeach
    </div>
    
    <!-- Responsive Pagination -->
    <div class="mt-4 overflow-x-auto">{{ $transactions->links() }}</div>
@endsection
