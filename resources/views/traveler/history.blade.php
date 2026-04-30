@extends('layouts.app')

@section('content')
    <h1 class="text-xl font-semibold">Riwayat Pembelian</h1>
    <div class="mt-4 space-y-3">
        @foreach($transactions as $trx)
            <div class="rounded-xl bg-white p-4 shadow-sm">
                <p class="font-semibold">{{ $trx->ticket->destination->name }} - {{ $trx->ticket->name }}</p>
                <p class="text-sm text-slate-500">Status: {{ strtoupper($trx->status) }} | Tanggal booking: {{ $trx->booking_date->format('d M Y') }}</p>
                <p class="text-sm">Total: Rp {{ number_format($trx->total_price, 0, ',', '.') }}</p>
                @if($trx->status === 'pending')
                    <div class="mt-2 flex gap-2">
                        <a href="{{ route('checkout.resume', ['order_id' => $trx->order_id]) }}" class="inline-block rounded-lg bg-cyan-600 px-4 py-2 text-sm font-medium text-white">Lanjutkan Pembayaran</a>
                        <form method="POST" action="{{ route('history.checkStatus', $trx) }}" class="inline">
                            @csrf
                            <button type="submit" class="rounded-lg bg-orange-600 px-4 py-2 text-sm font-medium text-white">Periksa Status</button>
                        </form>
                    </div>
                @elseif($trx->status === 'settlement')
                    <div class="mt-3">
                        {!! QrCode::size(150)->generate($trx->qr_code_token) !!}
                    </div>
                @endif
            </div>
        @endforeach
    </div>
    <div class="mt-4">{{ $transactions->links() }}</div>
@endsection
