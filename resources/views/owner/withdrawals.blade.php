@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto px-4 md:px-6">
    <!-- Header -->
    <div class="mb-8">
        <h1 class="text-3xl font-black text-slate-900 tracking-tight">Pencairan Dana</h1>
        <p class="text-xs text-slate-400 font-bold uppercase tracking-wider mt-1">Tarik saldo pendapatan tempat wisata Anda ke rekening bank resmi Anda</p>
    </div>

    @include('owner.partials.nav')

    <!-- Main Grid -->
    <div class="grid gap-10 lg:grid-cols-[1.2fr_1.8fr] mt-8 items-start">
        
        <!-- Action / Request Box -->
        <div class="space-y-6">
            <!-- Digital Balance Card (Virtual Credit Card look) -->
            <div class="bg-gradient-to-tr from-slate-900 via-slate-800 to-primary-950 rounded-[2rem] p-8 text-white relative overflow-hidden shadow-xl shadow-slate-950/20">
                <div class="absolute right-0 bottom-0 translate-x-6 translate-y-6 opacity-5 text-[10rem]">
                    <i class="fa-solid fa-wallet"></i>
                </div>
                <div class="absolute -top-12 -left-12 w-32 h-32 bg-primary-500/10 rounded-full blur-xl pointer-events-none"></div>
                
                <div class="relative z-10 flex flex-col justify-between h-40">
                    <div class="flex justify-between items-start">
                        <div>
                            <p class="text-[9px] text-slate-400 font-black uppercase tracking-widest">Saldo Pendapatan Mitra</p>
                            <p class="text-3xl font-black mt-2 tracking-tight">
                                <span class="text-sm font-medium text-slate-400">Rp</span> {{ number_format(auth()->user()->balance, 0, ',', '.') }}
                            </p>
                        </div>
                        <div class="w-12 h-8 rounded-lg bg-white/10 flex items-center justify-center text-white/50 text-sm">
                            <i class="fa-solid fa-building-columns text-lg"></i>
                        </div>
                    </div>
                    
                    <div class="flex justify-between items-end pt-6 border-t border-white/5">
                        <div>
                            <p class="text-[8px] text-slate-500 font-black uppercase tracking-wider">Nama Mitra Pemilik</p>
                            <p class="text-xs font-bold text-slate-200 mt-0.5">{{ auth()->user()->name }}</p>
                        </div>
                        <span class="text-[8px] font-black uppercase tracking-widest text-emerald-400 bg-emerald-500/10 px-2.5 py-1 rounded-md border border-emerald-500/20 flex items-center gap-1"><i class="fa-solid fa-shield text-[6px]"></i> Terverifikasi</span>
                    </div>
                </div>
            </div>

            <!-- Form Card -->
            <div class="bg-white rounded-[2rem] border border-slate-100 shadow-xl shadow-slate-200/40 p-6 md:p-8">
                @if(empty(auth()->user()->bank_code) || empty(auth()->user()->bank_account_number))
                    <!-- Profile Warning Box -->
                    <div class="bg-amber-50 border border-amber-100 text-amber-700 p-6 rounded-2xl space-y-3">
                        <p class="font-black text-sm flex items-center gap-2">
                            <i class="fa-solid fa-circle-exclamation text-amber-500 text-base"></i> Profil Belum Lengkap!
                        </p>
                        <p class="text-xs font-semibold leading-relaxed">Anda belum mendaftarkan nomor rekening bank pengelola di profil Anda. Data rekening bank diperlukan untuk memproses pengajuan pencairan dana.</p>
                        <a href="{{ route('profile') }}" class="inline-flex items-center gap-2 bg-amber-500 hover:bg-amber-600 text-white font-extrabold px-6 py-3 rounded-xl transition-all text-xs uppercase tracking-wider shadow-md shadow-amber-200">
                            Lengkapi Rekening Profil <i class="fa-solid fa-arrow-right text-xs"></i>
                        </a>
                    </div>
                @else
                    <!-- Bank details -->
                    <div class="p-5 rounded-2xl bg-slate-50 border border-slate-100 flex items-start gap-4">
                        <div class="w-10 h-10 rounded-xl bg-white border border-slate-100 shadow-sm flex items-center justify-center text-primary-500 shrink-0">
                            <i class="fa-solid fa-university text-sm"></i>
                        </div>
                        <div class="min-w-0 flex-1">
                            <p class="text-[8px] font-black text-slate-400 uppercase tracking-widest mb-1">Rekening Tujuan Pencairan</p>
                            <h5 class="font-extrabold text-slate-900 text-sm leading-snug truncate">{{ strtoupper(auth()->user()->bank_code) }} - {{ auth()->user()->bank_account_number }}</h5>
                            <p class="text-xs text-slate-500 font-semibold mt-0.5">a.n {{ auth()->user()->bank_account_name }}</p>
                            <a href="{{ route('profile') }}" class="inline-flex items-center gap-1 text-[10px] text-primary-600 hover:text-primary-700 font-extrabold mt-3 border-b border-primary-600/30 hover:border-primary-600 leading-none">
                                Ubah Rekening <i class="fa-solid fa-chevron-right text-[8px] ml-0.5"></i>
                            </a>
                        </div>
                    </div>

                    <!-- Withdrawal Form -->
                    <form method="POST" action="{{ route('owner.withdrawals.store') }}" class="space-y-5 pt-4">
                        @csrf
                        
                        <div class="space-y-2">
                            <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest ml-1">Jumlah Penarikan (Rp)</label>
                            <div class="relative group">
                                <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-slate-400 group-focus-within:text-primary-600 transition-colors">
                                    <span class="text-xs font-bold">Rp</span>
                                </div>
                                <input type="number" name="amount" min="50000" required placeholder="Minimal Rp 50.000"
                                       class="w-full bg-slate-50 border border-slate-100 rounded-2xl pl-10 pr-4 py-4 text-slate-800 font-bold focus:ring-2 focus:ring-primary-500/20 focus:border-primary-500 outline-none transition-all placeholder:text-slate-400/80">
                            </div>
                            <p class="text-[10px] text-slate-400 font-bold ml-1 flex items-center gap-1">
                                <i class="fa-solid fa-circle-info text-primary-500"></i>
                                Biaya layanan 5% otomatis terpotong untuk biaya admin transfer bank.
                            </p>
                        </div>

                        <button type="submit" class="w-full min-h-[3.5rem] md:min-h-[3.75rem] bg-primary-600 hover:bg-primary-700 active:bg-primary-800 text-white font-extrabold py-5 md:py-6 px-6 rounded-2xl shadow-xl shadow-primary-600/25 transition-all transform hover:-translate-y-0.5 active:translate-y-0 text-sm md:text-base uppercase tracking-wide flex items-center justify-center gap-3 touch-manipulation">
                            <i class="fa-solid fa-paper-plane text-base md:text-lg"></i>
                            <span>Kirim Permintaan Tarik Dana</span>
                        </button>
                    </form>
                @endif
            </div>
        </div>

        <!-- History Section (Right) -->
        <div class="space-y-5">
            <h3 class="text-xl font-bold text-slate-900 tracking-tight flex items-center gap-2"><i class="fa-solid fa-clock-rotate-left text-primary-500"></i> Riwayat Pencairan Dana</h3>
            
            @if($withdrawals->isEmpty())
                <div class="bg-white rounded-[2rem] border border-slate-100 p-8 text-center shadow-sm">
                    <div class="w-14 h-14 rounded-full bg-slate-50 flex items-center justify-center mx-auto mb-4 text-slate-300">
                        <i class="fa-solid fa-money-bill-transfer text-lg"></i>
                    </div>
                    <p class="text-sm font-semibold text-slate-800">Belum ada riwayat penarikan</p>
                    <p class="text-xs text-slate-400 mt-1">Seluruh pengajuan penarikan dana yang Anda lakukan akan tercatat di sini.</p>
                </div>
            @else
                <div class="grid gap-4">
                    @foreach($withdrawals as $wd)
                        <div class="bg-white rounded-3xl border border-slate-100 p-6 shadow-sm hover:shadow-lg transition-all flex flex-col sm:flex-row sm:items-center justify-between gap-4 relative overflow-hidden group">
                            <!-- Background color decor when hover -->
                            <div class="absolute inset-y-0 left-0 w-1.5 bg-slate-200 group-hover:bg-primary-500 transition-all"></div>
                            
                            <div class="pl-2 space-y-3">
                                <div>
                                    <p class="text-[9px] text-slate-400 font-black uppercase tracking-widest mb-0.5">Tanggal Permintaan</p>
                                    <p class="text-xs font-bold text-slate-500"><i class="fa-regular fa-calendar mr-1.5"></i>{{ $wd->created_at->format('d M Y H:i') }} WIB</p>
                                </div>
                                <div class="grid grid-cols-2 sm:grid-cols-3 gap-x-6 gap-y-1 pt-1">
                                    <div>
                                        <p class="text-[8px] text-slate-400 font-bold uppercase tracking-wider">Jumlah Diajukan</p>
                                        <p class="text-sm font-black text-slate-900">Rp {{ number_format($wd->gross_amount, 0, ',', '.') }}</p>
                                    </div>
                                    <div>
                                        <p class="text-[8px] text-slate-400 font-bold uppercase tracking-wider">Biaya Admin (5%)</p>
                                        <p class="text-xs font-extrabold text-rose-500">- Rp {{ number_format($wd->admin_fee, 0, ',', '.') }}</p>
                                    </div>
                                    <div>
                                        <p class="text-[8px] text-slate-400 font-bold uppercase tracking-wider">Diterima (Net)</p>
                                        <p class="text-xs font-extrabold text-emerald-600">Rp {{ number_format($wd->amount, 0, ',', '.') }}</p>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="flex sm:flex-col items-start sm:items-end justify-between sm:justify-center gap-3 pt-4 sm:pt-0 border-t sm:border-t-0 border-slate-50">
                                @if($wd->status === 'pending')
                                    <span class="rounded-full bg-amber-50 text-amber-600 font-extrabold text-[9px] px-3.5 py-1.5 border border-amber-100 uppercase tracking-wider flex items-center gap-1.5">
                                        <i class="fa-solid fa-hourglass-half text-[8px] animate-spin"></i> Pending
                                    </span>
                                @elseif($wd->status === 'approved')
                                    <span class="rounded-full bg-emerald-50 text-emerald-600 font-extrabold text-[9px] px-3.5 py-1.5 border border-emerald-100 uppercase tracking-wider flex items-center gap-1.5">
                                        <i class="fa-solid fa-circle-check text-[8px]"></i> Berhasil
                                    </span>
                                @else
                                    <span class="rounded-full bg-rose-50 text-rose-600 font-extrabold text-[9px] px-3.5 py-1.5 border border-rose-100 uppercase tracking-wider flex items-center gap-1.5">
                                        <i class="fa-solid fa-circle-xmark text-[8px]"></i> Ditolak
                                    </span>
                                @endif
                                
                                <p class="text-[10px] text-slate-400 font-bold tracking-tight mt-1">{{ strtoupper($wd->ewallet_or_bank_name) }} • {{ $wd->account_number }}</p>
                            </div>
                        </div>
                    @endforeach
                </div>
                
                <div class="mt-6 flex justify-center">{{ $withdrawals->links() }}</div>
            @endif
        </div>

    </div>
</div>
@endsection
