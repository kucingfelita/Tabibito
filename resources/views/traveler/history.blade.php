@extends('layouts.app')

@section('content')
    <h1 class="text-xl font-semibold">Riwayat Pembelian</h1>
    <p class="text-gray-500 mt-5">Gunakan tiket sebaik mungkin, tidak ada pengembalian dana untuk tiket yang sudah melewati tanggal kunjungan/expired!</p>
    
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
                        <form method="POST" action="{{ route('history.cancel', $trx) }}" class="inline cancel-form">
                            @csrf
                            <button type="button"
                                onclick="confirmCancel(this)"
                                class="rounded-lg bg-rose-600 hover:bg-rose-700 px-4 py-2 text-sm font-medium text-white transition-colors">
                                Batalkan Pesanan
                            </button>
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
                @elseif($trx->status === 'used')
                    @if(is_null($trx->rating))
                        <div class="mt-4 pt-4 border-t border-slate-100">
                            <p class="text-sm font-semibold text-slate-700 mb-2">Bagaimana pengalaman Anda?</p>
                            <form action="{{ route('history.rating', $trx) }}" method="POST" class="flex flex-col sm:flex-row sm:items-center gap-4">
                                @csrf
                                <div class="flex items-center gap-1" x-data="{ rating: 0, hoverRating: 0 }">
                                    @for($i = 1; $i <= 5; $i++)
                                        <label class="cursor-pointer transition-colors"
                                               @mouseenter="hoverRating = {{ $i }}"
                                               @mouseleave="hoverRating = 0"
                                               :class="(hoverRating >= {{ $i }} || rating >= {{ $i }}) ? 'text-amber-400' : 'text-slate-200'">
                                            <input type="radio" name="rating" value="{{ $i }}" class="hidden" x-model="rating" required>
                                            <svg class="w-8 h-8" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                                        </label>
                                    @endfor
                                </div>
                                <button type="submit" class="rounded-lg bg-amber-500 hover:bg-amber-600 px-6 py-2.5 text-sm font-bold text-white transition-colors shadow-lg shadow-amber-500/30">Kirim Penilaian</button>
                            </form>
                        </div>
                    @else
                        <div class="mt-4 pt-4 border-t border-slate-100 flex flex-col sm:flex-row sm:items-center gap-2">
                            <span class="text-sm font-semibold text-slate-700">Penilaian Anda:</span>
                            <div class="flex items-center gap-1">
                                @for($i = 1; $i <= 5; $i++)
                                    <svg class="w-5 h-5 {{ $i <= $trx->rating ? 'text-amber-400' : 'text-slate-200' }}" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                                @endfor
                            </div>
                        </div>
                    @endif
                @endif
            </div>
        @endforeach
    </div>
    
    <!-- Responsive Pagination -->
    <div class="mt-4 overflow-x-auto">{{ $transactions->links() }}</div>

    @push('scripts')
    <script>
        function confirmCancel(button) {
            Swal.fire({
                title: 'Batalkan Pesanan?',
                text: "Pesanan yang dibatalkan tidak dapat dikembalikan. Kuota tiket akan dikembalikan untuk orang lain.",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#e11d48',
                cancelButtonColor: '#475569',
                confirmButtonText: 'Ya, Batalkan!',
                cancelButtonText: 'Kembali',
                customClass: {
                    popup: 'rounded-3xl'
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    button.closest('form').submit();
                }
            })
        }
    </script>
    @endpush
@endsection
