@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto px-4 md:px-6">
    <!-- Header -->
    <div class="mb-8">
        <h1 class="text-3xl font-black text-slate-900 tracking-tight">Scanner QR Code Tiket</h1>
        <p class="text-xs text-slate-400 font-bold uppercase tracking-wider mt-1">Arahkan kamera ke QR Code E-Tiket pengunjung untuk memverifikasi dan menghanguskan tiket.</p>
    </div>

    @include('owner.partials.nav')

    <!-- Scanner Box Layout -->
    <div class="max-w-xl mx-auto bg-white rounded-[2.5rem] border border-slate-100 shadow-xl shadow-slate-200/40 p-6 md:p-10 relative overflow-hidden" x-data="qrScanner()">
        <div class="absolute top-0 right-0 w-32 h-32 bg-primary-50 rounded-full -mr-16 -mt-16 opacity-40"></div>
        
        <div class="relative z-10 space-y-6">
            <!-- Camera frame -->
            <div class="relative rounded-[2rem] overflow-hidden border-4 border-slate-900 bg-slate-950 aspect-square shadow-inner">
                <!-- Scanner Laser Line overlay -->
                <div x-show="isCameraActive && isScanning" class="absolute inset-x-0 h-1 bg-emerald-500 shadow-[0_0_12px_#10b981] z-20 top-0 animate-[scannerLaser_3s_ease-in-out_infinite]"></div>
                
                <!-- Target corners overlays -->
                <div x-show="isCameraActive" class="absolute inset-8 border border-white/20 pointer-events-none rounded-xl z-20">
                    <div class="absolute -top-1 -left-1 w-6 h-6 border-t-4 border-l-4 border-emerald-500 rounded-tl-md"></div>
                    <div class="absolute -top-1 -right-1 w-6 h-6 border-t-4 border-r-4 border-emerald-500 rounded-tr-md"></div>
                    <div class="absolute -bottom-1 -left-1 w-6 h-6 border-b-4 border-l-4 border-emerald-500 rounded-bl-md"></div>
                    <div class="absolute -bottom-1 -right-1 w-6 h-6 border-b-4 border-r-4 border-emerald-500 rounded-br-md"></div>
                </div>

                <!-- Camera Element -->
                <div id="reader" class="w-full h-full overflow-hidden"></div>

                <!-- Loading State Overlay -->
                <div x-show="permissionStatus === 'checking'" class="absolute inset-0 bg-slate-950 flex flex-col items-center justify-center text-white z-10 space-y-3">
                    <div class="w-10 h-10 border-4 border-primary-500 border-t-transparent rounded-full animate-spin"></div>
                    <p class="text-xs font-black uppercase tracking-wider text-slate-300">Menghubungkan Kamera...</p>
                </div>

                <!-- Permission Denied / Error Overlay -->
                <div x-show="permissionStatus === 'denied'" class="absolute inset-0 bg-slate-950 flex flex-col items-center justify-center text-center p-6 text-white z-10 space-y-4">
                    <div class="w-16 h-16 rounded-full bg-rose-500/10 flex items-center justify-center text-rose-500">
                        <i class="fa-solid fa-camera-slash text-2xl"></i>
                    </div>
                    <div>
                        <p class="text-sm font-black uppercase tracking-wider text-rose-500">Akses Kamera Ditolak</p>
                        <p class="text-xs text-slate-400 mt-1">Berikan izin kamera pada browser Anda untuk dapat memindai QR Code tiket.</p>
                    </div>
                    <button @click="startCamera()" class="bg-primary-600 hover:bg-primary-700 text-white font-extrabold px-6 py-3 rounded-xl transition-all text-xs uppercase tracking-wider active:scale-95 shadow-md shadow-primary-600/20">
                        Izinkan Kamera
                    </button>
                </div>
            </div>

            <!-- Camera Selection -->
            <div x-show="cameras.length > 1" class="space-y-1.5" style="display: none;">
                <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest ml-1">Pilih Kamera</label>
                <div class="relative group">
                    <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-slate-400 group-focus-within:text-primary-600 transition-colors">
                        <i class="fa-solid fa-camera text-sm"></i>
                    </div>
                    <select x-model="selectedCameraId" @change="changeCamera()" 
                            class="w-full bg-slate-50 border border-slate-100 rounded-2xl pl-11 pr-10 py-4 text-slate-800 font-bold focus:ring-2 focus:ring-primary-500/20 focus:border-primary-500 outline-none transition-all appearance-none cursor-pointer">
                        <template x-for="(camera, index) in cameras" :key="camera.id">
                            <option :value="camera.id" x-text="camera.label || 'Kamera ' + (index + 1)"></option>
                        </template>
                    </select>
                    <div class="absolute inset-y-0 right-0 pr-4 flex items-center pointer-events-none text-slate-400">
                        <i class="fa-solid fa-chevron-down text-xs"></i>
                    </div>
                </div>
            </div>

            <!-- Manual input -->
            <div class="space-y-2 pt-2">
                <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest ml-1">Input Kode Token Manual (Jika Kamera Bermasalah)</label>
                <div class="flex flex-col sm:flex-row gap-3">
                    <div class="relative group flex-1">
                        <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-slate-400 group-focus-within:text-primary-600 transition-colors">
                            <i class="fa-solid fa-keyboard text-sm"></i>
                        </div>
                        <input x-model="token" placeholder="Masukkan token tiket, misal: TK-102930219" 
                               class="w-full bg-slate-50 border border-slate-100 rounded-2xl pl-11 pr-4 py-4 text-slate-800 font-bold focus:ring-2 focus:ring-primary-500/20 focus:border-primary-500 outline-none transition-all placeholder:text-slate-400/80">
                    </div>
                    
                    <button @click="verifyToken(token)" class="bg-slate-900 hover:bg-slate-800 text-white font-extrabold px-8 py-4 rounded-2xl shadow-lg transition-all active:scale-95 text-xs uppercase tracking-wider flex items-center justify-center gap-2 whitespace-nowrap">
                        Verifikasi <i class="fa-solid fa-circle-check text-sm ml-1 text-emerald-400"></i>
                    </button>
                </div>
            </div>

            <!-- Toast Messages -->
            <div x-show="message" x-cloak x-transition.opacity
                 :class="isError ? 'bg-rose-50 text-rose-700 border-rose-100' : 'bg-emerald-50 text-emerald-700 border-emerald-100'" 
                 class="p-4 rounded-2xl border text-xs font-black uppercase tracking-wider flex items-center gap-3">
                <i :class="isError ? 'fa-solid fa-circle-xmark text-lg text-rose-600' : 'fa-solid fa-circle-check text-lg text-emerald-600'"></i>
                <span x-text="message"></span>
            </div>

            <!-- Result Card (Double-sided ticket/receipt look) -->
            <div x-show="scanResult && !isError" x-cloak x-transition.opacity
                 class="rounded-[2rem] border-2 border-emerald-400 bg-gradient-to-br from-emerald-50 to-emerald-100/50 p-6 md:p-8 space-y-5 shadow-lg shadow-emerald-100/50 relative overflow-hidden">
                
                <div class="flex items-center gap-4 pb-4 border-b border-emerald-200">
                    <div class="flex h-16 w-16 shrink-0 items-center justify-center rounded-2xl bg-emerald-600 text-white shadow-md shadow-emerald-300">
                        <span class="text-3xl font-black" x-text="scanResult.qty"></span>
                    </div>
                    <div>
                        <span class="px-2 py-0.5 rounded-md bg-emerald-600 text-white text-[8px] font-black uppercase tracking-wider">Berhasil Digunakan</span>
                        <p class="text-xl font-black text-emerald-950 mt-1 leading-none">Tiket Valid & Masuk</p>
                        <p class="text-xs text-emerald-700/80 font-bold mt-1" x-text="scanResult.qty + ' Pengunjung / Pax'"></p>
                    </div>
                </div>
                
                <div class="grid grid-cols-2 gap-y-4 gap-x-4 text-xs">
                    <div>
                        <p class="text-[9px] font-black text-emerald-700/60 uppercase tracking-wider">Nama Pemegang Tiket</p>
                        <p class="font-black text-emerald-950" x-text="scanResult.visitor_name"></p>
                    </div>
                    <div>
                        <p class="text-[9px] font-black text-emerald-700/60 uppercase tracking-wider">Kategori Tiket</p>
                        <p class="font-black text-emerald-950" x-text="scanResult.ticket_name"></p>
                    </div>
                    <div class="col-span-2 pt-2 border-t border-dashed border-emerald-200 flex justify-between items-center">
                        <div>
                            <p class="text-[9px] font-black text-emerald-700/60 uppercase tracking-wider">Destinasi Wisata</p>
                            <p class="font-black text-emerald-950" x-text="scanResult.destination_name"></p>
                        </div>
                        <div class="text-right">
                            <p class="text-[9px] font-black text-emerald-700/60 uppercase tracking-wider">Tanggal Kunjungan</p>
                            <p class="font-black text-emerald-950" x-text="scanResult.booking_date"></p>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>

@push('styles')
<style>
    @keyframes scannerLaser {
        0%, 100% { top: 0%; }
        50% { top: 100%; }
    }
    /* Style html5-qrcode video tag to center and fill container */
    #reader video {
        width: 100% !important;
        height: 100% !important;
        object-fit: cover !important;
        border-radius: 1.5rem !important;
    }
</style>
@endpush

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
            html5QrCode: null,
            cameras: [],
            selectedCameraId: '',
            permissionStatus: 'checking', // checking, granted, denied
            isCameraActive: false,

            init() {
                this.html5QrCode = new Html5Qrcode("reader");
                this.startCamera();
            },

            startCamera() {
                this.permissionStatus = 'checking';
                
                Html5Qrcode.getCameras().then(devices => {
                    this.cameras = devices;
                    if (devices && devices.length > 0) {
                        this.permissionStatus = 'granted';
                        
                        // Select back/rear camera if available, otherwise first camera
                        let backCamera = devices.find(device => 
                            device.label.toLowerCase().includes('back') || 
                            device.label.toLowerCase().includes('rear') || 
                            device.label.toLowerCase().includes('environment')
                        );
                        let cameraId = backCamera ? backCamera.id : devices[0].id;
                        this.selectedCameraId = cameraId;
                        
                        this.startScanning(cameraId);
                    } else {
                        this.permissionStatus = 'denied';
                        this.message = 'Kamera tidak ditemukan.';
                        this.isError = true;
                    }
                }).catch(err => {
                    this.permissionStatus = 'denied';
                    this.message = 'Akses kamera ditolak. Berikan izin akses kamera untuk menggunakan pemindai.';
                    this.isError = true;
                });
            },

            startScanning(cameraId) {
                if (this.isCameraActive) {
                    this.html5QrCode.stop().then(() => {
                        this.performStart(cameraId);
                    }).catch(err => {
                        this.performStart(cameraId);
                    });
                } else {
                    this.performStart(cameraId);
                }
            },

            performStart(cameraId) {
                this.html5QrCode.start(
                    cameraId,
                    {
                        fps: 10,
                        qrbox: (width, height) => {
                            const size = Math.min(width, height) * 0.65;
                            return { width: size, height: size };
                        }
                    },
                    (decodedText, decodedResult) => {
                        if (this.isScanning) {
                            this.isScanning = false;
                            
                            // Play beep sound for scan success
                            let audio = new Audio('data:audio/wav;base64,UklGRl9vT19XQVZFZm10IBAAAAABAAEAQB8AAEAfAAABAAgAZGF0YU');
                            audio.play().catch(e => {});

                            this.verifyToken(decodedText);
                        }
                    },
                    (errorMessage) => {
                        // ignore scan errors (unreadable/no qr code found on frame)
                    }
                ).then(() => {
                    this.isCameraActive = true;
                    this.isError = false;
                }).catch(err => {
                    this.isCameraActive = false;
                    this.message = 'Gagal memuat feed kamera: ' + err;
                    this.isError = true;
                });
            },

            changeCamera() {
                if (this.selectedCameraId) {
                    this.startScanning(this.selectedCameraId);
                }
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
                    
                    // Wait a few seconds before enabling scanner to prevent repeat scans
                    setTimeout(() => {
                        this.isScanning = true;
                        if(!this.isError) {
                            this.message = ''; // auto clear success message after 4 seconds
                        }
                    }, 4000);
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
