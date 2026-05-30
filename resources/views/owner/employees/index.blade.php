@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto px-4 md:px-6" x-data="{ openAddModal: false }">
    <!-- Header -->
    <div class="mb-8 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <h1 class="text-3xl font-black text-slate-900 tracking-tight">Manajemen Karyawan</h1>
            <p class="text-xs text-slate-400 font-bold uppercase tracking-wider mt-1">Daftarkan dan kelola akun staf/karyawan yang bertugas memindai e-tiket pengunjung</p>
        </div>
        
        <button @click="openAddModal = true"
                class="inline-flex items-center gap-3 rounded-2xl bg-primary-600 hover:bg-primary-700 text-white font-extrabold px-8 py-4 text-sm shadow-xl shadow-primary-600/25 transition-all active:scale-95 shrink-0 hover:shadow-2xl hover:shadow-primary-600/30">
            <i class="fa-solid fa-user-plus text-base"></i> Tambah Karyawan Baru
        </button>
    </div>

    @include('owner.partials.nav')

    <!-- Success & Error Messages -->
    @if(session('success'))
        <div class="mb-6 flex items-center gap-3 rounded-2xl border border-emerald-100 bg-emerald-50 px-5 py-4 text-xs font-black uppercase tracking-wider text-emerald-700">
            <i class="fa-solid fa-circle-check text-lg text-emerald-600"></i>
            <span>{{ session('success') }}</span>
        </div>
    @endif

    @if($errors->any())
        <div class="mb-6 flex items-start gap-3 rounded-2xl border border-rose-100 bg-rose-50 px-5 py-4 text-xs font-black uppercase tracking-wider text-rose-700">
            <i class="fa-solid fa-circle-xmark text-lg text-rose-600 shrink-0 mt-0.5"></i>
            <ul class="list-disc list-inside space-y-0.5 min-w-0">
                @foreach($errors->all() as $err)
                    <li>{{ $err }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <!-- Employee List Section -->
    <div class="mt-8 space-y-5">
        @if($employees->isEmpty())
            <div class="bg-white rounded-[2rem] border border-slate-100 shadow-xl shadow-slate-200/40 overflow-hidden">
                <div class="flex flex-col items-center justify-center py-20 text-center space-y-4">
                    <div class="w-20 h-20 rounded-full bg-slate-50 flex items-center justify-center text-slate-300">
                        <i class="fa-solid fa-user-shield text-3xl"></i>
                    </div>
                    <div>
                        <p class="text-base font-black text-slate-800">Belum Ada Karyawan Terdaftar</p>
                        <p class="text-sm text-slate-400 mt-1 font-semibold">Staf scanner diperlukan untuk membantu memverifikasi tiket pengunjung di lokasi wisata.</p>
                    </div>
                </div>
            </div>
        @else
            @foreach($employees as $emp)
                <div class="bg-white rounded-[2rem] border border-slate-100 shadow-lg shadow-slate-200/30 hover:shadow-xl transition-all p-6 md:p-8">
                    <div class="flex flex-col sm:flex-row sm:items-center gap-5">
                        <!-- Avatar + Info -->
                        <div class="flex items-center gap-4 flex-1 min-w-0">
                            <div class="flex h-14 w-14 shrink-0 items-center justify-center rounded-2xl bg-gradient-to-tr from-violet-600 to-primary-500 text-lg font-black text-white shadow-lg shadow-violet-200 uppercase">
                                {{ substr($emp->name, 0, 1) }}
                            </div>
                            <div class="min-w-0">
                                <p class="font-extrabold text-slate-800 text-base md:text-lg leading-snug truncate">{{ $emp->name }}</p>
                                <p class="text-xs text-slate-400 font-bold mt-0.5">Level: Staff Lapangan</p>
                            </div>
                        </div>

                        <!-- Details Grid -->
                        <div class="flex flex-wrap items-center gap-x-8 gap-y-4 sm:gap-x-10">
                            <!-- Username -->
                            <div>
                                <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-1.5">Username</p>
                                <code class="rounded-xl bg-slate-100 px-4 py-2 text-sm font-bold text-slate-700 inline-block">{{ $emp->username }}</code>
                            </div>

                            <!-- Hak Akses -->
                            <div>
                                <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-1.5">Hak Akses</p>
                                <div class="flex flex-wrap gap-2">
                                    <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg bg-emerald-50 text-emerald-700 text-xs font-black uppercase tracking-wider border border-emerald-100">
                                        <i class="fa-solid fa-qrcode text-[10px]"></i> Scanner QR
                                    </span>
                                    <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg bg-blue-50 text-blue-700 text-xs font-black uppercase tracking-wider border border-blue-100">
                                        <i class="fa-solid fa-clock-rotate-left text-[10px]"></i> Riwayat Scan
                                    </span>
                                </div>
                            </div>

                            <!-- Tanggal -->
                            <div>
                                <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-1.5">Ditambahkan</p>
                                <p class="text-sm text-slate-600 font-extrabold flex items-center gap-1.5">
                                    <i class="fa-regular fa-calendar text-slate-400"></i>{{ $emp->created_at->format('d M Y') }}
                                </p>
                            </div>
                        </div>

                        <!-- Delete Action -->
                        <div class="sm:ml-auto shrink-0">
                            <form method="POST" action="{{ route('owner.employees.destroy', $emp) }}"
                                  onsubmit="return confirm('Apakah Anda yakin ingin menghapus akun karyawan {{ addslashes($emp->name) }} secara permanen?')">
                                @csrf
                                @method('DELETE')
                                
                                <button type="submit" class="bg-rose-50 hover:bg-rose-100 text-rose-600 font-extrabold px-6 py-3 rounded-xl transition-all text-xs uppercase tracking-wider inline-flex items-center gap-2 active:scale-95 border border-rose-100 hover:border-rose-200">
                                    <i class="fa-solid fa-user-minus text-sm"></i> Hapus Akun
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            @endforeach
        @endif
    </div>

    <!-- Add Employee Modal Layout (Alpine.js integrated) -->
    <div x-show="openAddModal" x-cloak class="fixed inset-0 z-50 flex items-center justify-center p-4">
        <!-- Backdrop -->
        <div @click="openAddModal = false" x-show="openAddModal" x-transition.opacity class="absolute inset-0 bg-slate-950/40 backdrop-blur-sm"></div>

        <!-- Modal Card -->
        <div x-show="openAddModal" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100" x-transition:leave="transition ease-in duration-150" x-transition:leave-start="opacity-100 scale-100" x-transition:leave-end="opacity-0 scale-95" 
             class="relative w-full max-w-md rounded-[2.5rem] bg-white p-8 md:p-10 shadow-2xl z-10 border border-slate-100">
            
            <div class="mb-8 flex items-center justify-between">
                <div>
                    <h2 class="text-xl font-black text-slate-900 tracking-tight">Daftarkan Karyawan</h2>
                    <p class="mt-1 text-xs text-slate-400 font-bold uppercase tracking-wider">Langkah menambahkan staf verifikator tiket</p>
                </div>
                <button @click="openAddModal = false" class="flex h-9 w-9 items-center justify-center rounded-full bg-slate-100 text-slate-500 hover:bg-slate-200 transition-colors">
                    <i class="fa-solid fa-xmark text-sm"></i>
                </button>
            </div>

            <form method="POST" action="{{ route('owner.employees.store') }}" class="space-y-5">
                @csrf

                <!-- Nama -->
                <div class="space-y-2">
                    <label for="emp-name" class="block text-[10px] font-black text-slate-400 uppercase tracking-widest ml-1">Nama Lengkap Karyawan</label>
                    <div class="relative group">
                        <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-slate-400 group-focus-within:text-primary-600 transition-colors">
                            <i class="fa-solid fa-id-card text-sm"></i>
                        </div>
                        <input id="emp-name" type="text" name="name" value="{{ old('name') }}" placeholder="Contoh: Budi Santoso" required
                               class="w-full bg-slate-50 border border-slate-100 rounded-2xl pl-11 pr-4 py-4 text-slate-800 font-bold focus:ring-2 focus:ring-primary-500/20 focus:border-primary-500 outline-none transition-all placeholder:text-slate-400/80">
                    </div>
                </div>

                <!-- Username -->
                <div class="space-y-2">
                    <label for="emp-username" class="block text-[10px] font-black text-slate-400 uppercase tracking-widest ml-1">Username Login</label>
                    <div class="relative group">
                        <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-slate-400 group-focus-within:text-primary-600 transition-colors">
                            <i class="fa-solid fa-user-tag text-sm"></i>
                        </div>
                        <input id="emp-username" type="text" name="username" value="{{ old('username') }}" placeholder="Contoh: budi_scanner" required
                               class="w-full bg-slate-50 border border-slate-100 rounded-2xl pl-11 pr-4 py-4 text-slate-800 font-bold focus:ring-2 focus:ring-primary-500/20 focus:border-primary-500 outline-none transition-all placeholder:text-slate-400/80">
                    </div>
                    <p class="text-[9px] text-slate-400 font-bold ml-1 flex items-center gap-1"><i class="fa-solid fa-circle-info text-primary-500"></i>Harus unik untuk digunakan kredensial login.</p>
                </div>

                <!-- Password -->
                <div class="space-y-2">
                    <label for="emp-password" class="block text-[10px] font-black text-slate-400 uppercase tracking-widest ml-1">Kata Sandi Akun</label>
                    <div class="relative group" x-data="{ show: false }">
                        <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-slate-400 group-focus-within:text-primary-600 transition-colors">
                            <i class="fa-solid fa-lock text-sm"></i>
                        </div>
                        <input id="emp-password" :type="show ? 'text' : 'password'" name="password" placeholder="Minimal 6 karakter" required
                               class="w-full bg-slate-50 border border-slate-100 rounded-2xl pl-11 pr-12 py-4 text-slate-800 font-bold focus:ring-2 focus:ring-primary-500/20 focus:border-primary-500 outline-none transition-all placeholder:text-slate-400/80">
                        <button type="button" @click="show = !show" class="absolute inset-y-0 right-0 pr-4 flex items-center text-slate-400 hover:text-slate-600">
                            <i class="fa-solid" :class="show ? 'fa-eye-slash' : 'fa-eye'"></i>
                        </button>
                    </div>
                </div>

                <!-- Action Button Grid -->
                <div class="pt-4 flex gap-3.5">
                    <button type="button" @click="openAddModal = false" class="flex-1 bg-white border border-slate-200 text-slate-700 font-extrabold py-4 rounded-2xl hover:bg-slate-50 transition-all text-xs uppercase tracking-wider text-center">
                        Batal
                    </button>
                    <button type="submit" class="flex-1 bg-primary-600 hover:bg-primary-700 text-white font-extrabold py-4 rounded-2xl shadow-xl shadow-primary-600/20 transition-all text-xs uppercase tracking-wider text-center active:scale-95">
                        Simpan Akun
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
