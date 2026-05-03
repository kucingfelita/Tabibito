@extends('layouts.app')

@section('content')
    @include('owner.partials.nav')
    <div class="mt-6">
        <h1 class="text-xl font-semibold">Scanner Tiket Wisata</h1>
        <p class="mt-2 text-sm text-slate-500">Arahkan kamera ke QR Code tiket pengunjung. Tiket yang berhasil discan akan otomatis hangus (berstatus used) dan QR Code akan hilang dari riwayat pengguna.</p>
    </div>

    <div class="mt-4 max-w-xl rounded-xl bg-white p-4 shadow-sm" x-data="qrScanner()">
        <div id="reader" class="w-full overflow-hidden rounded-lg border-2 border-dashed border-emerald-300"></div>
        
        <div class="mt-4">
            <label class="text-sm font-medium">Input Manual (Jika kamera tidak bisa membaca):</label>
            <div class="flex gap-2 mt-1">
                <input x-model="token" class="w-full rounded-lg border px-3 py-2" placeholder="Masukkan Token QR">
                <button @click="verifyToken(token)" class="rounded-lg bg-emerald-600 px-4 py-2 text-white font-medium whitespace-nowrap">Cek Tiket</button>
            </div>
        </div>

        <template x-if="message">
            <div :class="isError ? 'bg-red-50 text-red-700 border-red-200' : 'bg-emerald-50 text-emerald-700 border-emerald-200'" class="mt-4 p-3 rounded-lg border text-sm font-medium" x-text="message"></div>
        </template>

        <template x-if="scanResult && !isError">
            <div class="mt-4 rounded-xl border-2 border-emerald-400 bg-emerald-50 p-4">
                <div class="flex items-center gap-3">
                    <div class="flex h-16 w-16 shrink-0 items-center justify-center rounded-full bg-emerald-600 text-white">
                        <span class="text-3xl font-black" x-text="scanResult.qty"></span>
                    </div>
                    <div>
                        <p class="text-lg font-bold text-emerald-800">✅ Tiket Valid!</p>
                        <p class="text-sm font-semibold" x-text="scanResult.qty + ' Tiket / ' + scanResult.qty + ' Orang'"></p>
                    </div>
                </div>
                <div class="mt-3 space-y-1 border-t border-emerald-200 pt-3 text-sm text-slate-700">
                    <p><span class="font-semibold">Nama Pengunjung:</span> <span x-text="scanResult.visitor_name"></span></p>
                    <p><span class="font-semibold">Tiket:</span> <span x-text="scanResult.ticket_name"></span></p>
                    <p><span class="font-semibold">Destinasi:</span> <span x-text="scanResult.destination_name"></span></p>
                    <p><span class="font-semibold">Tanggal Kunjungan:</span> <span x-text="scanResult.booking_date"></span></p>
                </div>
            </div>
        </template>
    </div>

    @push('scripts')
    <script src="https://unpkg.com/html5-qrcode" type="text/javascript"></script>
    <script>
        document.addEventListener('alpine:init', () => {
            Alpine.data('qrScanner', () => ({
                token: '',
                message: '',
                isError: false,
                isScanning: true,
                scanResult: null,
                html5QrcodeScanner: null,

                init() {
                    // Initialize the QR Code scanner
                    this.html5QrcodeScanner = new Html5QrcodeScanner(
                        "reader", { fps: 10, qrbox: {width: 250, height: 250} }, false);
                    
                    this.html5QrcodeScanner.render(this.onScanSuccess.bind(this), this.onScanFailure.bind(this));
                },

                onScanSuccess(decodedText, decodedResult) {
                    if (this.isScanning) {
                        this.isScanning = false; // Prevent multiple requests for the same scan
                        
                        // Play a beep sound for better UX
                        let audio = new Audio('data:audio/wav;base64,UklGRl9vT19XQVZFZm10IBAAAAABAAEAQB8AAEAfAAABAAgAZGF0YU');
                        audio.play().catch(e => {});

                        this.verifyToken(decodedText);
                    }
                },

                onScanFailure(error) {
                    // Ignore scan failures as they just mean no QR code is currently visible
                },

                verifyToken(scannedToken) {
                    if(!scannedToken) return;
                    
                    fetch('{{ route('owner.scanner.verify') }}', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        body: JSON.stringify({ qr_code_token: scannedToken })
                    })
                    .then(response => {
                        this.isError = !response.ok;
                        return response.json();
                    })
                    .then(data => {
                        this.message = data.message;
                        this.token = ''; // clear input
                        if (!this.isError && data.qty) {
                            this.scanResult = data;
                        } else {
                            this.scanResult = null;
                        }
                        
                        // Wait a few seconds before allowing next scan to prevent duplicate scans
                        setTimeout(() => {
                            this.isScanning = true;
                            if(!this.isError) {
                                this.message = ''; // auto clear success message after 4 seconds
                            }
                        }, 5000);
                    })
                    .catch(error => {
                        this.isError = true;
                        this.message = 'Terjadi kesalahan jaringan saat memverifikasi tiket.';
                        setTimeout(() => this.isScanning = true, 3000);
                    });
                }
            }));
        });
    </script>
    @endpush
@endsection
