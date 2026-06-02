@extends('layouts.app')

@section('content')
<div class="max-w-3xl mx-auto w-full min-w-0">
    <!-- Breadcrumbs -->
    <nav class="mb-8 flex items-center gap-2 text-sm">
        <a href="{{ route('home') }}" class="text-slate-400 hover:text-primary-600 transition-colors font-medium">Beranda</a>
        <svg class="w-4 h-4 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
        <span class="text-slate-900 font-bold">Profil Pengguna</span>
    </nav>

    <!-- Profile Header Card -->
    <div class="bg-white rounded-2xl md:rounded-[2.5rem] p-5 sm:p-8 border border-slate-100 shadow-sm relative overflow-hidden mb-6 md:mb-8 text-center md:text-left md:flex md:items-center md:justify-between gap-6">
        <!-- Ambient shapes in background -->
        <div class="absolute top-0 right-0 w-32 h-32 bg-primary-50 rounded-full -mr-16 -mt-16 opacity-40"></div>
        <div class="absolute -bottom-10 -left-10 w-28 h-28 bg-secondary-50 rounded-full opacity-40"></div>

        <div class="flex flex-col md:flex-row items-center gap-6 relative z-10">
            <!-- Circular Initial Avatar -->
            <div class="w-24 h-24 rounded-[2rem] bg-gradient-to-tr from-primary-600 to-primary-500 font-black text-4xl text-white flex items-center justify-center shadow-lg shadow-primary-200 border-4 border-white select-none">
                {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
            </div>
            
            <div class="space-y-1">
                <h1 class="text-2xl font-black text-slate-900 leading-tight">{{ auth()->user()->name }}</h1>
                <p class="text-xs text-slate-400 font-bold tracking-wide flex items-center justify-center md:justify-start gap-1.5">
                    <i class="fa-regular fa-envelope text-primary-500"></i> {{ auth()->user()->email }}
                </p>
                <div class="flex items-center justify-center md:justify-start gap-2 mt-2">
                    @if(auth()->user()->tipe_user === \App\Models\User::TYPE_EMPLOYEE)
                        <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-xl bg-violet-50 text-violet-700 text-[10px] font-black uppercase tracking-wider">
                            <i class="fa-solid fa-user-gear"></i> Karyawan
                        </span>
                    @elseif(auth()->user()->tipe_user === \App\Models\User::TYPE_OWNER)
                        <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-xl bg-primary-50 text-primary-700 text-[10px] font-black uppercase tracking-wider">
                            <i class="fa-solid fa-user-tie"></i> Owner Wisata
                        </span>
                    @elseif(auth()->user()->tipe_user === \App\Models\User::TYPE_ADMIN)
                        <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-xl bg-amber-50 text-amber-700 text-[10px] font-black uppercase tracking-wider">
                            <i class="fa-solid fa-user-shield"></i> Admin
                        </span>
                    @else
                        <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-xl bg-emerald-50 text-emerald-700 text-[10px] font-black uppercase tracking-wider">
                            <i class="fa-solid fa-plane"></i> Traveler
                        </span>
                    @endif
                </div>
            </div>
        </div>
        
        <div class="mt-6 md:mt-0 text-slate-400 text-xs font-bold uppercase tracking-wider relative z-10">
            Terdaftar Sejak: <span class="text-slate-700 font-extrabold">{{ auth()->user()->created_at->format('d M Y') }}</span>
        </div>
    </div>

    <!-- Edit Profile Form -->
    <div class="bg-white rounded-[2.5rem] p-8 md:p-10 border border-slate-100 shadow-sm relative overflow-hidden">
        <form method="POST" action="{{ route('profile.update') }}" class="space-y-8" id="profile-form">
            @csrf
            @method('PUT')
            
            <!-- Section 1: Informasi Pribadi -->
            <div class="space-y-6">
                <div class="flex items-center gap-3.5 pb-4 border-b border-slate-50">
                    <div class="w-10 h-10 rounded-xl bg-primary-50 text-primary-600 flex items-center justify-center shrink-0">
                        <i class="fa-regular fa-id-card text-base"></i>
                    </div>
                    <h3 class="text-lg font-black text-slate-900">Informasi Pribadi</h3>
                </div>

                <div class="grid md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-2.5 ml-1">Nama Lengkap</label>
                        <div class="relative group">
                            <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-slate-400 group-focus-within:text-primary-600 transition-colors">
                                <i class="fa-regular fa-user text-sm"></i>
                            </div>
                            <input type="text" name="name" value="{{ auth()->user()->name }}" required class="w-full bg-slate-50 border border-slate-100 rounded-2xl pl-11 pr-4 py-3.5 text-slate-800 font-bold focus:ring-2 focus:ring-primary-500/20 focus:border-primary-500 transition-all outline-none">
                        </div>
                    </div>

                    <div>
                        <label class="block text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-2.5 ml-1">Nomor Handphone</label>
                        <div class="relative group">
                            <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-slate-400 group-focus-within:text-primary-600 transition-colors">
                                <i class="fa-solid fa-phone text-sm"></i>
                            </div>
                            <input type="tel" name="phone" value="{{ auth()->user()->phone }}" class="w-full bg-slate-50 border border-slate-100 rounded-2xl pl-11 pr-4 py-3.5 text-slate-800 font-bold focus:ring-2 focus:ring-primary-500/20 focus:border-primary-500 transition-all outline-none" placeholder="08xxxxxxxxxx">
                        </div>
                    </div>
                </div>
            </div>

            <!-- Section 2: Keamanan (Sandi) -->
            <div class="space-y-6 pt-4 border-t border-slate-50">
                <div class="flex items-center gap-3.5 pb-4 border-b border-slate-50">
                    <div class="w-10 h-10 rounded-xl bg-violet-50 text-violet-600 flex items-center justify-center shrink-0">
                        <i class="fa-solid fa-lock text-sm"></i>
                    </div>
                    <h3 class="text-lg font-black text-slate-900">Ubah Kata Sandi <span class="text-xs font-semibold text-slate-400">(Opsional)</span></h3>
                </div>

                <div class="grid md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-2.5 ml-1">Kata Sandi Baru</label>
                        <div class="relative group">
                            <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-slate-400 group-focus-within:text-primary-600 transition-colors">
                                <i class="fa-solid fa-key text-xs"></i>
                            </div>
                            <input type="password" name="password" placeholder="Masukkan sandi baru" class="w-full bg-slate-50 border border-slate-100 rounded-2xl pl-11 pr-4 py-3.5 text-slate-800 font-bold focus:ring-2 focus:ring-primary-500/20 focus:border-primary-500 transition-all outline-none">
                        </div>
                    </div>

                    <div>
                        <label class="block text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-2.5 ml-1">Konfirmasi Kata Sandi Baru</label>
                        <div class="relative group">
                            <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-slate-400 group-focus-within:text-primary-600 transition-colors">
                                <i class="fa-solid fa-key text-xs"></i>
                            </div>
                            <input type="password" name="password_confirmation" placeholder="Ulangi sandi baru" class="w-full bg-slate-50 border border-slate-100 rounded-2xl pl-11 pr-4 py-3.5 text-slate-800 font-bold focus:ring-2 focus:ring-primary-500/20 focus:border-primary-500 transition-all outline-none">
                        </div>
                    </div>
                </div>
            </div>

            <!-- Section 3: Rekening Pencairan Dana (Hanya untuk Owner) -->
            @if(auth()->user()->tipe_user == \App\Models\User::TYPE_OWNER)
            <div class="space-y-6 pt-4 border-t border-slate-50">
                <div class="flex items-center gap-3.5 pb-4 border-b border-slate-50">
                    <div class="w-10 h-10 rounded-xl bg-emerald-50 text-emerald-600 flex items-center justify-center shrink-0">
                        <i class="fa-solid fa-wallet text-sm"></i>
                    </div>
                    <div>
                        <h3 class="text-lg font-black text-slate-900">Rekening Pencairan Dana</h3>
                        <p class="text-[10px] text-slate-400 font-bold uppercase tracking-wider">Digunakan untuk transfer otomatis bagi hasil penjualan tiket wisata Anda.</p>
                    </div>
                </div>

                <div class="grid md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-2.5 ml-1">Bank / E-Wallet</label>
                        <select name="bank_code" class="w-full bg-slate-50 border border-slate-100 rounded-2xl px-5 py-3.5 text-slate-800 font-bold focus:ring-2 focus:ring-primary-500/20 focus:border-primary-500 transition-all outline-none appearance-none">
                            <option value="">Pilih Bank / E-Wallet</option>
                            @php
                                $banks = ['bca' => 'BCA (Bank Central Asia)', 'bni' => 'BNI (Bank Negara Indonesia)', 'bri' => 'BRI (Bank Rakyat Indonesia)', 'mandiri' => 'Bank Mandiri', 'cimb' => 'CIMB Niaga', 'permata' => 'Bank Permata', 'gopay' => 'GoPay', 'ovo' => 'OVO', 'dana' => 'DANA', 'shopeepay' => 'ShopeePay'];
                            @endphp
                            @foreach($banks as $code => $name)
                                <option value="{{ $code }}" {{ auth()->user()->bank_code == $code ? 'selected' : '' }}>{{ $name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label class="block text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-2.5 ml-1">Nomor Rekening / Akun E-Wallet</label>
                        <div class="relative group">
                            <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-slate-400 group-focus-within:text-primary-600 transition-colors">
                                <i class="fa-solid fa-hashtag text-xs"></i>
                            </div>
                            <input type="text" name="bank_account_number" value="{{ auth()->user()->bank_account_number }}" class="w-full bg-slate-50 border border-slate-100 rounded-2xl pl-11 pr-4 py-3.5 text-slate-800 font-bold focus:ring-2 focus:ring-primary-500/20 focus:border-primary-500 transition-all outline-none" placeholder="Masukkan nomor rekening/HP">
                        </div>
                    </div>

                    <div class="md:col-span-2">
                        <label class="block text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-2.5 ml-1">Nama Pemilik Rekening</label>
                        <div class="relative group">
                            <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-slate-400 group-focus-within:text-primary-600 transition-colors">
                                <i class="fa-solid fa-address-book text-xs"></i>
                            </div>
                            <input type="text" name="bank_account_name" value="{{ auth()->user()->bank_account_name }}" class="w-full bg-slate-50 border border-slate-100 rounded-2xl pl-11 pr-4 py-3.5 text-slate-800 font-bold focus:ring-2 focus:ring-primary-500/20 focus:border-primary-500 transition-all outline-none" placeholder="Masukkan nama tertera di rekening bank">
                        </div>
                    </div>
                </div>
            </div>
            @endif

            <!-- Save Action Button -->
            <div class="pt-6 border-t border-slate-50 flex items-center justify-end">
                <button type="submit" class="w-full sm:w-auto bg-primary-600 hover:bg-primary-700 text-white font-black px-10 py-4 rounded-2xl shadow-xl shadow-primary-600/30 transition-all transform hover:-translate-y-1 active:translate-y-0 text-xs uppercase tracking-wider flex items-center justify-center gap-2">
                    <i class="fa-solid fa-floppy-disk text-sm"></i> Simpan Perubahan
                </button>
            </div>
        </form>
    </div>
</div>

@push('scripts')
<script>
    document.getElementById('profile-form').addEventListener('submit', function() {
        const btn = this.querySelector('button[type="submit"]');
        if (btn) {
            setTimeout(() => {
                btn.disabled = true;
                btn.innerHTML = '<i class="fa-solid fa-spinner animate-spin"></i> Menyimpan...';
            }, 10);
        }
    });
</script>
@endpush
@endsection
