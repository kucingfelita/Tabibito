@extends('layouts.app')

@push('styles')
<style>
    [x-cloak] { display: none !important; }
    /* Boarding Pass Design System */
    .boarding-pass {
        background: #ffffff;
        border-radius: 2rem;
        border: 1px solid #f1f5f9;
        box-shadow: 0 10px 30px -5px rgba(0, 0, 0, 0.03);
        position: relative;
        overflow: hidden;
    }
    
    @media (min-width: 768px) {
        .boarding-pass::before, .boarding-pass::after {
            content: '';
            position: absolute;
            width: 24px;
            height: 24px;
            background: #F8FAFC; /* Matches body background */
            border-radius: 50%;
            left: 70%;
            z-index: 10;
            border: 1px solid #f1f5f9;
        }
        .boarding-pass::before {
            top: -12px;
            box-shadow: inset 0 -4px 6px -4px rgba(0,0,0,0.05);
        }
        .boarding-pass::after {
            bottom: -12px;
            box-shadow: inset 0 4px 6px -4px rgba(0,0,0,0.05);
        }
        .boarding-divider {
            position: absolute;
            left: 70%;
            top: 12px;
            bottom: 12px;
            border-left: 2px dashed #cbd5e1;
            transform: translateX(11px);
        }
    }

    @media (max-width: 767px) {
        .boarding-pass::before, .boarding-pass::after {
            content: '';
            position: absolute;
            width: 20px;
            height: 20px;
            background: #F8FAFC;
            border-radius: 50%;
            top: 60%;
            z-index: 10;
            border: 1px solid #f1f5f9;
        }
        .boarding-pass::before {
            left: -10px;
            box-shadow: inset -4px 0 6px -4px rgba(0,0,0,0.05);
        }
        .boarding-pass::after {
            right: -10px;
            box-shadow: inset 4px 0 6px -4px rgba(0,0,0,0.05);
        }
        .boarding-divider {
            position: absolute;
            top: 60%;
            left: 12px;
            right: 12px;
            border-top: 2px dashed #cbd5e1;
            transform: translateY(9px);
        }
    }

    /* Shimmering Pulse animation for pending status */
    .pulse-amber {
        box-shadow: 0 0 0 0 rgba(245, 158, 11, 0.4);
        animation: pulse-amber-anim 2s infinite;
    }
    @keyframes pulse-amber-anim {
        0% { transform: scale(0.95); box-shadow: 0 0 0 0 rgba(245, 158, 11, 0.7); }
        70% { transform: scale(1); box-shadow: 0 0 0 8px rgba(245, 158, 11, 0); }
        100% { transform: scale(0.95); box-shadow: 0 0 0 0 rgba(245, 158, 11, 0); }
    }
</style>
@endpush

@section('content')
<div class="max-w-5xl mx-auto px-4 md:px-0" x-data="{ activeTab: 'all', showZoomModal: false, zoomQrToken: '', zoomTrxOrder: '' }">
    <!-- Header Title Area -->
    <div class="mb-10 flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div>
            <h1 class="text-3xl font-black text-slate-900">Riwayat Pesanan</h1>
            <p class="text-xs text-slate-400 font-bold uppercase tracking-wider mt-1 flex items-center gap-1.5">
                <i class="fa-solid fa-receipt text-primary-500"></i> Panel Tiket & Transaksi Anda
            </p>
        </div>
        <div class="bg-amber-50 border border-amber-100 rounded-2xl px-5 py-3 text-xs text-amber-800 max-w-md font-semibold leading-relaxed">
            <i class="fa-solid fa-triangle-exclamation text-amber-500 mr-1.5 animate-pulse"></i>
            Tiket yang melewati tanggal kunjungan atau hangus tidak dapat di-refund/dikembalikan.
        </div>
    </div>

    <!-- Interactive Navigation Tabs -->
    <div class="mb-8 overflow-x-auto custom-scrollbar flex gap-2 pb-2.5 border-b border-slate-100">
        <button @click="activeTab = 'all'" 
                :class="activeTab === 'all' ? 'bg-primary-600 text-white shadow-lg shadow-primary-200' : 'bg-white hover:bg-slate-50 text-slate-600 border border-slate-100'"
                class="px-5 py-3 rounded-2xl text-xs font-black uppercase tracking-wider transition-all duration-300 shrink-0">
            <i class="fa-solid fa-border-all mr-1.5"></i> Semua
        </button>
        <button @click="activeTab = 'pending'" 
                :class="activeTab === 'pending' ? 'bg-amber-500 text-white shadow-lg shadow-amber-200' : 'bg-white hover:bg-slate-50 text-slate-600 border border-slate-100'"
                class="px-5 py-3 rounded-2xl text-xs font-black uppercase tracking-wider transition-all duration-300 shrink-0">
            <i class="fa-solid fa-hourglass-half mr-1.5"></i> Menunggu Bayar
        </button>
        <button @click="activeTab = 'active'" 
                :class="activeTab === 'active' ? 'bg-emerald-600 text-white shadow-lg shadow-emerald-200' : 'bg-white hover:bg-slate-50 text-slate-600 border border-slate-100'"
                class="px-5 py-3 rounded-2xl text-xs font-black uppercase tracking-wider transition-all duration-300 shrink-0">
            <i class="fa-solid fa-ticket mr-1.5"></i> Tiket Aktif
        </button>
        <button @click="activeTab = 'completed'" 
                :class="activeTab === 'completed' ? 'bg-indigo-600 text-white shadow-lg shadow-indigo-200' : 'bg-white hover:bg-slate-50 text-slate-600 border border-slate-100'"
                class="px-5 py-3 rounded-2xl text-xs font-black uppercase tracking-wider transition-all duration-300 shrink-0">
            <i class="fa-solid fa-circle-check mr-1.5"></i> Selesai
        </button>
        <button @click="activeTab = 'expired'" 
                :class="activeTab === 'expired' ? 'bg-rose-600 text-white shadow-lg shadow-rose-200' : 'bg-white hover:bg-slate-50 text-slate-600 border border-slate-100'"
                class="px-5 py-3 rounded-2xl text-xs font-black uppercase tracking-wider transition-all duration-300 shrink-0">
            <i class="fa-solid fa-ban mr-1.5"></i> Kedaluwarsa/Batal
        </button>
    </div>

    <!-- Booking Transactions List -->
    <div class="space-y-6">
        @forelse($transactions as $trx)
            @php
                // Pre-calculate status flags for Alpine filtering
                $tabStatus = 'expired';
                if ($trx->status === 'pending') {
                    $tabStatus = 'pending';
                } elseif ($trx->status === 'settlement' && !$trx->is_expired) {
                    $tabStatus = 'active';
                } elseif ($trx->status === 'used') {
                    $tabStatus = 'completed';
                }
            @endphp

            <div x-show="activeTab === 'all' || activeTab === '{{ $tabStatus }}'" 
                 x-transition:enter="transition ease-out duration-300"
                 x-transition:enter-start="opacity-0 translate-y-4"
                 x-transition:enter-end="opacity-100 translate-y-0"
                 class="boarding-pass p-6 md:p-8">
                
                <!-- Layout Divider dotted (Visible on MD and larger) -->
                <div class="boarding-divider"></div>

                <div class="grid md:grid-cols-[1.6fr_0.7fr] gap-6 md:gap-10">
                    
                    <!-- Left Section: Boarding Details -->
                    <div class="space-y-6">
                        <!-- Top status line -->
                        <div class="flex flex-wrap items-center gap-2.5">
                            @if($trx->status === 'pending')
                                <span class="inline-flex items-center gap-1 px-3 py-1 rounded-full bg-amber-50 border border-amber-200 text-amber-600 text-[10px] font-black uppercase tracking-wider pulse-amber">
                                    <i class="fa-solid fa-spinner animate-spin text-[8px]"></i> Menunggu Pembayaran
                                </span>
                            @elseif($trx->status === 'settlement' && !$trx->is_expired)
                                <span class="inline-flex items-center gap-1 px-3 py-1 rounded-full bg-emerald-50 border border-emerald-200 text-emerald-700 text-[10px] font-black uppercase tracking-wider">
                                    <i class="fa-solid fa-circle-check text-[9px]"></i> Tiket Aktif
                                </span>
                            @elseif($trx->status === 'used')
                                <span class="inline-flex items-center gap-1 px-3 py-1 rounded-full bg-indigo-50 border border-indigo-200 text-indigo-700 text-[10px] font-black uppercase tracking-wider">
                                    <i class="fa-solid fa-clipboard-check text-[9px]"></i> Kunjungan Selesai
                                </span>
                            @else
                                <span class="inline-flex items-center gap-1 px-3 py-1 rounded-full bg-rose-50 border border-rose-200 text-rose-700 text-[10px] font-black uppercase tracking-wider">
                                    <i class="fa-solid fa-circle-xmark text-[9px]"></i> Kedaluwarsa/Batal
                                </span>
                            @endif

                            <span class="text-[10px] font-bold text-slate-400">Order ID: <span class="font-mono text-slate-600">{{ $trx->order_id }}</span></span>
                        </div>

                        <!-- Ticket branding & destinations -->
                        <div class="flex items-start gap-4">
                            <div class="shrink-0 w-16 h-16 rounded-2xl bg-slate-50 border border-slate-100 overflow-hidden">
                                @php
                                    $coverImg = $trx->ticket->destination->coverImage ?? $trx->ticket->destination->images->first();
                                @endphp
                                @if($coverImg?->image_path)
                                    <img src="{{ asset('storage/' . $coverImg->image_path) }}" class="w-full h-full object-cover">
                                @else
                                    <div class="w-full h-full flex items-center justify-center text-slate-300">
                                        <i class="fa-regular fa-image text-lg"></i>
                                    </div>
                                @endif
                            </div>
                            <div>
                                <p class="text-xs text-slate-400 font-bold uppercase tracking-widest">Boarding Pass Wisata</p>
                                <h3 class="text-xl font-black text-slate-900 leading-tight mt-0.5">{{ $trx->ticket->destination->name }}</h3>
                                <p class="text-xs text-slate-400 font-bold flex items-center gap-1 mt-1">
                                    <i class="fa-solid fa-location-dot text-rose-500"></i> {{ $trx->ticket->destination->city }}
                                </p>
                            </div>
                        </div>

                        <!-- Technical parameters in card body -->
                        <div class="grid grid-cols-2 md:grid-cols-3 gap-y-4 gap-x-2 pt-2 text-xs">
                            <div>
                                <p class="text-[9px] font-black text-slate-400 uppercase tracking-widest mb-0.5">Tipe Tiket</p>
                                <p class="font-extrabold text-slate-700">{{ $trx->ticket->name }}</p>
                            </div>
                            <div>
                                <p class="text-[9px] font-black text-slate-400 uppercase tracking-widest mb-0.5">Tanggal Kunjungan</p>
                                <p class="font-extrabold text-slate-700"><i class="fa-regular fa-calendar text-primary-500 mr-1"></i> {{ $trx->booking_date->format('d M Y') }}</p>
                            </div>
                            <div>
                                <p class="text-[9px] font-black text-slate-400 uppercase tracking-widest mb-0.5">Jumlah Kunjungan / Pax</p>
                                <p class="font-extrabold text-slate-700">{{ $trx->qty }} Orang</p>
                            </div>
                            <div>
                                <p class="text-[9px] font-black text-slate-400 uppercase tracking-widest mb-0.5">Pemegang Tiket</p>
                                <p class="font-extrabold text-slate-700 truncate max-w-[150px]">{{ $trx->user->name }}</p>
                            </div>
                            <div>
                                <p class="text-[9px] font-black text-slate-400 uppercase tracking-widest mb-0.5">Total Pembayaran</p>
                                <p class="font-black text-primary-600 text-sm">Rp {{ number_format($trx->total_price, 0, ',', '.') }}</p>
                            </div>
                        </div>

                        <!-- Action controls if pending -->
                        @if($trx->status === 'pending')
                            <div class="pt-4 border-t border-slate-50 flex flex-wrap gap-2.5">
                                <a href="{{ route('checkout.resume', ['order_id' => $trx->order_id]) }}" class="bg-amber-500 hover:bg-amber-600 text-white font-black px-5 py-2.5 rounded-xl text-xs uppercase tracking-wider shadow-md shadow-amber-500/20 transition-all flex items-center gap-1.5">
                                    <i class="fa-solid fa-credit-card"></i> Lanjutkan Bayar
                                </a>
                                <form method="POST" action="{{ route('history.checkStatus', $trx) }}" class="inline">
                                    @csrf
                                    <button type="submit" class="bg-slate-800 hover:bg-slate-900 text-white font-bold px-5 py-2.5 rounded-xl text-xs uppercase tracking-wider transition-all">
                                        Periksa Status
                                    </button>
                                </form>
                                <form method="POST" action="{{ route('history.cancel', $trx) }}" class="inline cancel-form">
                                    @csrf
                                    <button type="button" onclick="confirmCancel(this)" class="bg-rose-50 hover:bg-rose-100 text-rose-600 font-bold px-5 py-2.5 rounded-xl text-xs uppercase tracking-wider transition-all">
                                        Batalkan Pesanan
                                    </button>
                                </form>
                            </div>
                        @endif
                    </div>

                    <!-- Right Section: Stub/Ticket validation status -->
                    <div class="flex flex-col justify-center items-center text-center md:border-l md:border-dashed md:border-slate-100 md:pl-6 pt-6 md:pt-0">
                        @if($trx->status === 'settlement')
                            @if($trx->is_expired)
                                <!-- Expired Boarding pass stub -->
                                <div class="w-full bg-rose-50 border border-rose-100 rounded-3xl p-5 text-center">
                                    <div class="w-10 h-10 rounded-full bg-rose-100 text-rose-600 flex items-center justify-center mx-auto mb-3">
                                        <i class="fa-solid fa-triangle-exclamation"></i>
                                    </div>
                                    <p class="text-xs font-black text-rose-950 uppercase tracking-widest mb-1">Tiket Kedaluwarsa</p>
                                    <p class="text-[10px] text-rose-700/80 leading-relaxed font-semibold">Telah melewati batas tanggal kunjungan dan tidak digunakan.</p>
                                </div>
                            @else
                                <!-- Active QR Code Ticket Boarding stub -->
                                <div class="flex flex-col items-center justify-center">
                                    <div class="bg-white p-2.5 rounded-2xl border border-slate-100 shadow-sm mb-2 cursor-pointer hover:scale-105 transition-all duration-300 shadow-slate-200/50"
                                         @click="zoomQrToken = '{{ $trx->qr_code_token }}'; zoomTrxOrder = '{{ $trx->order_id }}'; showZoomModal = true"
                                         title="Klik untuk memperbesar">
                                        <div class="p-1 bg-white inline-block">
                                            {!! QrCode::size(120)->generate($trx->qr_code_token) !!}
                                        </div>
                                    </div>
                                    <p class="text-[10px] text-slate-400 font-extrabold uppercase tracking-wider mb-1 text-center">Scan Barcode untuk Masuk</p>
                                    <p class="text-[10px] text-primary-500 font-bold uppercase tracking-wider mb-2.5 cursor-pointer hover:underline flex items-center justify-center gap-1"
                                       @click="zoomQrToken = '{{ $trx->qr_code_token }}'; zoomTrxOrder = '{{ $trx->order_id }}'; showZoomModal = true">
                                        <i class="fa-solid fa-magnifying-glass-plus"></i> Klik untuk memperbesar
                                    </p>
                                    <p class="text-[10px] font-mono font-bold text-emerald-800 bg-emerald-50 px-3 py-1 rounded-lg border border-emerald-100/50 select-all">{{ $trx->qr_code_token }}</p>
                                </div>
                            @endif
                        @elseif($trx->status === 'pending')
                            <!-- QR Placeholder for pending ticket -->
                            <div class="flex flex-col items-center justify-center opacity-40">
                                <div class="bg-slate-50 p-6 rounded-2xl border-2 border-dashed border-slate-200 mb-2">
                                    <i class="fa-solid fa-qrcode text-5xl text-slate-400 animate-pulse"></i>
                                </div>
                                <p class="text-[10px] text-slate-400 font-bold uppercase tracking-wider">Menunggu Pembayaran</p>
                            </div>
                        @elseif($trx->status === 'used')
                            <!-- Review & Star form if ticket has been used -->
                            @if(is_null($trx->rating))
                                <div class="w-full pt-2">
                                    <div class="bg-indigo-50/50 border border-indigo-100 rounded-3xl p-5 text-left">
                                        <h4 class="text-xs font-black text-indigo-900 mb-3 flex items-center gap-1.5"><i class="fa-solid fa-pen-nib"></i> Tulis Ulasan Anda</h4>
                                        <form action="{{ route('history.rating', $trx) }}" method="POST" enctype="multipart/form-data" class="space-y-4" x-data="{ rating: 0, hoverRating: 0, imagePreview: null }">
                                            @csrf
                                            
                                            <!-- Star widgets -->
                                            <div>
                                                <div class="flex items-center gap-1.5">
                                                    @for($i = 1; $i <= 5; $i++)
                                                        <label class="cursor-pointer transition-transform hover:scale-110"
                                                               @mouseenter="hoverRating = {{ $i }}"
                                                               @mouseleave="hoverRating = 0"
                                                               :class="(hoverRating >= {{ $i }} || rating >= {{ $i }}) ? 'text-amber-400' : 'text-slate-300'">
                                                            <input type="radio" name="rating" value="{{ $i }}" class="hidden" x-model="rating" required>
                                                            <svg class="w-7 h-7" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                                                        </label>
                                                    @endfor
                                                </div>
                                            </div>

                                            <div>
                                                <textarea name="review_comment" rows="2" maxlength="1000" placeholder="Berikan komentar perjalanan Anda..." class="w-full bg-white border border-slate-100 rounded-xl p-3 text-xs text-slate-800 focus:ring-2 focus:ring-primary-500/20 transition-all placeholder:text-slate-400 resize-none font-semibold"></textarea>
                                            </div>

                                            <!-- Image uploader preview -->
                                            <div class="flex items-center gap-3">
                                                <label class="flex flex-col items-center justify-center border border-dashed border-slate-300 hover:border-primary-500 rounded-xl p-2.5 cursor-pointer transition-all bg-white hover:bg-slate-50 w-16 h-16 shrink-0">
                                                    <i class="fa-solid fa-camera text-slate-400 text-sm"></i>
                                                    <span class="text-[8px] font-bold text-slate-400 mt-1">Upload</span>
                                                    <input type="file" name="review_image" class="hidden" accept="image/*" 
                                                           @change="const file = $event.target.files[0]; if (file) { const reader = new FileReader(); reader.onload = (e) => { imagePreview = e.target.result; }; reader.readAsDataURL(file); }">
                                                </label>
                                                
                                                <template x-if="imagePreview">
                                                    <div class="relative w-16 h-16 rounded-xl overflow-hidden border border-slate-100 shadow-sm bg-slate-50">
                                                        <img :src="imagePreview" class="w-full h-full object-cover">
                                                        <button type="button" @click="imagePreview = null; $event.target.closest('.flex').querySelector('input[type=file]').value = ''" 
                                                                class="absolute top-1 right-1 bg-rose-600 text-white rounded-full p-0.5 shadow-sm transition-colors text-[9px] w-4 h-4 flex items-center justify-center">
                                                            <i class="fa-solid fa-xmark"></i>
                                                        </button>
                                                    </div>
                                                </template>
                                            </div>

                                            <button type="submit" class="w-full rounded-xl bg-indigo-600 hover:bg-indigo-700 py-2.5 text-xs font-black text-white uppercase tracking-wider transition-colors shadow-md shadow-indigo-600/10">Kirim Review</button>
                                        </form>
                                    </div>
                                </div>
                            @else
                                <!-- Already rated, show result -->
                                <div class="w-full text-left bg-slate-50 border border-slate-100 p-5 rounded-3xl space-y-3">
                                    <div class="flex items-center justify-between gap-2.5">
                                        <span class="text-[10px] font-black text-slate-400 uppercase tracking-widest">Ulasan Dikirim</span>
                                        <div class="flex items-center">
                                            @for($i = 1; $i <= 5; $i++)
                                                <i class="fa-solid fa-star text-[11px] {{ $i <= $trx->rating ? 'text-amber-400' : 'text-slate-200' }}"></i>
                                            @endfor
                                        </div>
                                    </div>
                                    @if($trx->review_comment)
                                        <p class="text-xs text-slate-600 font-semibold italic bg-white border border-slate-100 rounded-xl p-3">
                                            "{{ $trx->review_comment }}"
                                        </p>
                                    @endif
                                    @if($trx->review_image)
                                        <div class="w-16 h-16 rounded-xl overflow-hidden border border-slate-100 shadow-sm bg-slate-50">
                                            <a href="{{ asset('storage/' . $trx->review_image) }}" target="_blank">
                                                <img src="{{ asset('storage/' . $trx->review_image) }}" class="w-full h-full object-cover hover:scale-105 transition-transform duration-300">
                                            </a>
                                        </div>
                                    @endif
                                </div>
                            @endif
                        @else
                            <!-- Cancelled / Expired placeholder stub -->
                            <div class="flex flex-col items-center justify-center opacity-30">
                                <div class="w-14 h-14 bg-slate-100 rounded-2xl flex items-center justify-center mb-2 border border-slate-200/50">
                                    <i class="fa-solid fa-ban text-2xl text-slate-400"></i>
                                </div>
                                <p class="text-[10px] text-slate-400 font-bold uppercase tracking-wider">Tiket Tidak Aktif</p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        @empty
            <div class="bg-white rounded-[2.5rem] p-12 border border-slate-100 shadow-sm text-center">
                <div class="w-16 h-16 bg-slate-50 border border-slate-100 rounded-2xl flex items-center justify-center text-slate-400 mx-auto mb-6">
                    <i class="fa-regular fa-folder-open text-2xl"></i>
                </div>
                <h4 class="text-slate-900 font-black text-lg mb-1">Belum Ada Riwayat Pesanan</h4>
                <p class="text-slate-400 text-xs font-semibold max-w-sm mx-auto leading-relaxed mb-6">Semua pembelian tiket dan transaksi kunjungan Anda akan tercatat secara detail di halaman ini.</p>
                <a href="{{ route('destinations.index') }}" class="inline-flex items-center gap-2 bg-primary-600 hover:bg-primary-700 text-white font-black px-8 py-3.5 rounded-2xl shadow-lg shadow-primary-600/20 text-xs uppercase tracking-wider transition-all">
                    Eksplor Destinasi Sekarang
                </a>
            </div>
        @endforelse
    </div>
    
    <!-- Beautiful Pagination controls -->
    @if($transactions->hasPages())
        <div class="mt-10 p-4 bg-white border border-slate-100 rounded-3xl flex justify-center shadow-sm">
            {{ $transactions->links() }}
        </div>
    @endif

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
                <h3 class="text-lg font-black text-slate-900 mb-1" x-text="zoomTrxOrder"></h3>
                <p class="text-xs text-slate-400 font-bold tracking-wide uppercase mb-6">Tunjukkan ke Petugas Loket</p>
                
                <!-- Zoomed QR Code Wrapper -->
                <div class="bg-white p-4 rounded-3xl border border-slate-100 shadow-inner mb-6 inline-block">
                    <img :src="'https://api.qrserver.com/v1/create-qr-code/?size=300x300&data=' + encodeURIComponent(zoomQrToken)" 
                         class="w-64 h-64 mx-auto block rounded-2xl" 
                         alt="QR Code">
                </div>
                
                <div class="bg-slate-50 border border-slate-100/50 rounded-2xl p-4">
                    <p class="text-[10px] text-slate-400 font-extrabold uppercase tracking-widest mb-1.5">Kode Manual Tiket</p>
                    <p class="text-xs font-mono font-black text-emerald-800 bg-emerald-50/50 border border-emerald-100/30 py-2 px-4 rounded-xl break-all" x-text="zoomQrToken"></p>
                </div>
            </div>
        </div>
    </div>

</div>{{-- end x-data wrapper --}}

@push('scripts')
<script>
    function confirmCancel(button) {
        Swal.fire({
            title: 'Batalkan Pesanan?',
            text: "Kapasitas tiket akan dikembalikan, dan seluruh transaksi untuk pesanan ini akan dibatalkan.",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#rose-600',
            confirmButtonText: 'Ya, Batalkan!',
            cancelButtonColor: '#475569',
            cancelButtonText: 'Kembali',
            customClass: {
                popup: 'rounded-3xl border border-slate-100 shadow-xl'
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
