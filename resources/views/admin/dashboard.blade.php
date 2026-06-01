@extends('layouts.app')

@section('content')
<div class="max-w-6xl mx-auto px-4 md:px-0">
    <!-- Header Admin Welcome Card -->
    <div class="mb-10 bg-slate-900 rounded-[2.5rem] p-8 md:p-10 text-white relative overflow-hidden shadow-xl shadow-slate-950/10">
        <!-- Ambient vector overlays -->
        <div class="absolute top-0 right-0 w-44 h-44 bg-white/5 rounded-full -mr-16 -mt-16 pointer-events-none"></div>
        <div class="absolute -bottom-10 -left-10 w-36 h-36 bg-primary-500/10 rounded-full blur-2xl pointer-events-none"></div>
        
        <div class="relative z-10 space-y-2">
            <span class="px-3 py-1 rounded-full bg-white/10 text-primary-300 text-[10px] font-black uppercase tracking-wider">Super Administrator</span>
            <h1 class="text-3xl md:text-4xl font-black tracking-tight mt-2">Dashboard Administrator</h1>
            <p class="text-xs text-slate-400 font-bold uppercase tracking-wider">Kelola seluruh persetujuan destinasi, tinjau pencairan dana, dan pantau aktivitas pengguna</p>
        </div>
    </div>

    @include('admin.partials.nav')

    @if(session('success'))
        <div class="mb-6 rounded-2xl bg-emerald-50 border border-emerald-100 text-emerald-800 px-5 py-4 text-sm font-semibold">
            <i class="fa-solid fa-circle-check mr-1"></i> {{ session('success') }}
        </div>
    @endif

    <!-- Quick link -->
    <a href="{{ route('admin.destinations.index') }}"
       class="mb-8 flex items-center justify-between gap-4 bg-gradient-to-r from-primary-600 to-primary-500 hover:from-primary-700 hover:to-primary-600 text-white rounded-[2rem] p-6 md:p-8 shadow-lg shadow-primary-200/50 transition-all group">
        <div>
            <p class="text-[10px] font-black uppercase tracking-widest text-primary-100">Kelola Semua Destinasi</p>
            <h2 class="text-xl font-black mt-1">Rangkuman Destinasi & Data Pemilik</h2>
            <p class="text-sm text-primary-100/90 font-semibold mt-1">Lihat lengkap isi destinasi, paket tiket, galeri, dan statistik penjualan</p>
        </div>
        <span class="w-12 h-12 rounded-2xl bg-white/20 flex items-center justify-center group-hover:scale-110 transition-transform shrink-0">
            <i class="fa-solid fa-arrow-right text-lg"></i>
        </span>
    </a>

    <!-- Statistics Cards -->
    <div class="grid gap-6 md:grid-cols-3 mb-10">
        <!-- Card 1: Total Users -->
        <div class="bg-white p-8 rounded-[2rem] border border-slate-100 shadow-xl shadow-slate-200/20 group hover:border-primary-300 transition-all relative overflow-hidden">
            <div class="absolute top-0 right-0 w-16 h-16 bg-primary-50 rounded-bl-full opacity-40"></div>
            <div class="w-12 h-12 rounded-2xl bg-primary-50 flex items-center justify-center text-primary-600 mb-6 group-hover:scale-110 transition-transform">
                <i class="fa-solid fa-users text-lg"></i>
            </div>
            <p class="text-[9px] text-slate-400 font-black uppercase tracking-widest mb-1">Total Pengguna Terdaftar</p>
            <h3 class="text-3xl font-black text-slate-900 tracking-tight">{{ number_format($stats['total_users']) }}</h3>
            <p class="text-[10px] text-slate-400 font-bold mt-2"><i class="fa-solid fa-circle-user mr-1 text-primary-500"></i>Akun Traveler, Owner, & Staf</p>
        </div>

        <!-- Card 2: Verified Owners -->
        <div class="bg-white p-8 rounded-[2rem] border border-slate-100 shadow-xl shadow-slate-200/20 group hover:border-emerald-300 transition-all relative overflow-hidden">
            <div class="absolute top-0 right-0 w-16 h-16 bg-emerald-50 rounded-bl-full opacity-40"></div>
            <div class="w-12 h-12 rounded-2xl bg-emerald-50 flex items-center justify-center text-emerald-600 mb-6 group-hover:scale-110 transition-transform">
                <i class="fa-solid fa-user-shield text-lg"></i>
            </div>
            <p class="text-[9px] text-slate-400 font-black uppercase tracking-widest mb-1">Owner Terverifikasi</p>
            <h3 class="text-3xl font-black text-slate-900 tracking-tight">{{ number_format($stats['total_owner']) }}</h3>
            <p class="text-[10px] text-slate-400 font-bold mt-2"><i class="fa-solid fa-circle-check mr-1 text-emerald-500"></i>Mitra Pengelola Destinasi</p>
        </div>

        <!-- Card 3: Active Destinations -->
        <a href="{{ route('admin.destinations.index', ['status' => 'active']) }}"
           class="bg-white p-8 rounded-[2rem] border border-slate-100 shadow-xl shadow-slate-200/20 group hover:border-amber-300 transition-all relative overflow-hidden block">
            <div class="absolute top-0 right-0 w-16 h-16 bg-amber-50 rounded-bl-full opacity-40"></div>
            <div class="w-12 h-12 rounded-2xl bg-amber-50 flex items-center justify-center text-amber-600 mb-6 group-hover:scale-110 transition-transform">
                <i class="fa-solid fa-umbrella-beach text-lg"></i>
            </div>
            <p class="text-[9px] text-slate-400 font-black uppercase tracking-widest mb-1">Destinasi Wisata Aktif</p>
            <h3 class="text-3xl font-black text-slate-900 tracking-tight">{{ number_format($stats['active_destinations']) }}</h3>
            <p class="text-[10px] text-slate-400 font-bold mt-2"><i class="fa-solid fa-map-pin mr-1 text-amber-500"></i>Telah Disetujui & Siap Dipesan</p>
        </a>
    </div>

    <!-- Action Queues Grid (Verification & Withdrawals) -->
    <div class="grid gap-8 lg:grid-cols-2 mb-10">
        
        <!-- Destination Verifications -->
        <div class="bg-white rounded-[2.5rem] border border-slate-100 shadow-xl shadow-slate-200/40 p-6 md:p-8 space-y-6">
            <div class="flex items-center justify-between gap-3">
                <h2 class="text-lg font-black text-slate-900 tracking-tight flex items-center gap-2"><i class="fa-solid fa-clipboard-check text-primary-500"></i> Antrean Verifikasi Destinasi</h2>
                <a href="{{ route('admin.destinations.index', ['status' => 'pending']) }}" class="text-[10px] font-extrabold text-primary-600 uppercase tracking-wider hover:underline shrink-0">Lihat semua</a>
            </div>
            
            <div class="space-y-4 max-h-[350px] overflow-y-auto pr-1">
                @forelse($pendingDestinations as $destination)
                    <div class="rounded-2xl border border-slate-100 p-4.5 bg-slate-50/50 hover:bg-slate-50 transition-all flex flex-col md:flex-row md:items-center justify-between gap-4">
                        <div class="min-w-0 flex-1">
                            <span class="px-2 py-0.5 rounded-md bg-amber-50 text-amber-700 text-[8px] font-black uppercase tracking-wider border border-amber-100">Review</span>
                            <h4 class="font-extrabold text-slate-800 text-sm mt-1.5 leading-snug">{{ $destination->name }}</h4>
                            <p class="text-[10px] text-slate-400 font-semibold mt-0.5 flex items-center gap-1.5"><i class="fa-solid fa-location-dot text-rose-500"></i>{{ $destination->city }}</p>
                            @if($destination->owner)
                                <p class="text-[10px] text-slate-500 font-semibold mt-1"><i class="fa-solid fa-user text-primary-500 mr-1"></i>{{ $destination->owner->name }} · {{ $destination->owner->email }}</p>
                            @endif
                            <a href="{{ route('admin.destinations.show', $destination) }}" class="inline-flex items-center gap-1 mt-2 text-[10px] font-extrabold text-primary-600 uppercase tracking-wider hover:underline">
                                <i class="fa-solid fa-eye"></i> Detail lengkap
                            </a>
                        </div>
                        
                        <div class="flex gap-2 shrink-0">
                            <!-- Approve -->
                            <form method="POST" action="{{ route('admin.destinations.approve', $destination) }}">
                                @csrf
                                @method('PATCH')
                                <button type="submit" class="bg-emerald-600 hover:bg-emerald-700 text-white font-extrabold px-4 py-2.5 rounded-xl transition-all text-[10px] uppercase tracking-wider shadow-md shadow-emerald-200 active:scale-95 flex items-center gap-1">
                                    <i class="fa-solid fa-circle-check text-xs"></i> Setujui
                                </button>
                            </form>
                            
                            <!-- Reject -->
                            <form method="POST" action="{{ route('admin.destinations.reject', $destination) }}">
                                @csrf
                                @method('PATCH')
                                <button type="submit" class="bg-rose-50 hover:bg-rose-100 text-rose-600 font-extrabold px-4 py-2.5 rounded-xl transition-all text-[10px] uppercase tracking-wider active:scale-95 flex items-center gap-1">
                                    <i class="fa-solid fa-circle-xmark text-xs"></i> Tolak
                                </button>
                            </form>
                        </div>
                    </div>
                @empty
                    <div class="py-12 text-center text-slate-400 space-y-3">
                        <div class="w-14 h-14 rounded-full bg-slate-50 flex items-center justify-center mx-auto text-slate-300">
                            <i class="fa-solid fa-folder-open text-xl"></i>
                        </div>
                        <p class="text-xs font-semibold">Tidak ada pengajuan destinasi pending.</p>
                    </div>
                @endforelse
            </div>
        </div>

        <!-- Withdrawals (Cash out) -->
        <div class="bg-white rounded-[2.5rem] border border-slate-100 shadow-xl shadow-slate-200/40 p-6 md:p-8 space-y-6">
            <h2 class="text-lg font-black text-slate-900 tracking-tight flex items-center gap-2"><i class="fa-solid fa-money-bill-transfer text-emerald-500"></i> Verifikasi Pencairan Dana</h2>
            
            <div class="space-y-4 max-h-[350px] overflow-y-auto pr-1">
                @forelse($pendingWithdrawals as $withdrawal)
                    <div class="rounded-2xl border border-slate-100 p-4.5 bg-slate-50/50 hover:bg-slate-50 transition-all flex flex-col md:flex-row md:items-center justify-between gap-4">
                        <div>
                            <span class="px-2 py-0.5 rounded-md bg-amber-50 text-amber-700 text-[8px] font-black uppercase tracking-wider border border-amber-100">Review VA</span>
                            <h4 class="font-extrabold text-slate-800 text-sm mt-1.5 leading-snug">Owner #{{ $withdrawal->user_id }}</h4>
                            <p class="text-[10px] text-slate-500 font-semibold mt-0.5">Diajukan: Rp {{ number_format($withdrawal->gross_amount, 0, ',', '.') }} · Net: Rp {{ number_format($withdrawal->amount, 0, ',', '.') }}</p>
                        </div>
                        
                        <div class="flex flex-wrap gap-2 shrink-0">
                            <form method="POST" action="{{ route('admin.withdrawals.approve', $withdrawal) }}">
                                @csrf
                                @method('PATCH')
                                <button type="submit" class="bg-emerald-600 hover:bg-emerald-700 text-white font-extrabold px-5 py-2.5 rounded-xl transition-all text-[10px] uppercase tracking-wider shadow-md shadow-emerald-200 active:scale-95 flex items-center gap-1.5">
                                    <i class="fa-solid fa-circle-check text-xs"></i> Setujui
                                </button>
                            </form>
                            <form method="POST" action="{{ route('admin.withdrawals.reject', $withdrawal) }}" onsubmit="return confirm('Tolak pencairan ini? Saldo owner akan dikembalikan.');">
                                @csrf
                                @method('PATCH')
                                <button type="submit" class="bg-rose-50 hover:bg-rose-100 text-rose-600 font-extrabold px-5 py-2.5 rounded-xl transition-all text-[10px] uppercase tracking-wider border border-rose-100 flex items-center gap-1.5">
                                    <i class="fa-solid fa-xmark text-xs"></i> Tolak
                                </button>
                            </form>
                        </div>
                    </div>
                @empty
                    <div class="py-12 text-center text-slate-400 space-y-3">
                        <div class="w-14 h-14 rounded-full bg-slate-50 flex items-center justify-center mx-auto text-slate-300">
                            <i class="fa-solid fa-folder-open text-xl"></i>
                        </div>
                        <p class="text-xs font-semibold">Tidak ada pencairan dana pending.</p>
                    </div>
                @endforelse
            </div>
        </div>
    </div>

    <!-- User & Transaction Logs Grid -->
    <div class="grid gap-8 lg:grid-cols-2">
        <!-- Latest Users -->
        <div class="bg-white rounded-[2.5rem] border border-slate-100 shadow-xl shadow-slate-200/40 p-6 md:p-8 space-y-6">
            <h2 class="text-lg font-black text-slate-900 tracking-tight flex items-center gap-2"><i class="fa-solid fa-users-line text-violet-500"></i> Pengguna Baru Terdaftar</h2>
            
            <div class="divide-y divide-slate-50">
                @foreach($users as $user)
                    <div class="py-3 flex items-center justify-between gap-4 group">
                        <div class="flex items-center gap-3">
                            <div class="flex h-9 w-9 shrink-0 items-center justify-center rounded-xl bg-gradient-to-tr from-violet-600 to-primary-500 text-xs font-black text-white shadow-sm uppercase">
                                {{ substr($user->name, 0, 1) }}
                            </div>
                            <div>
                                <h4 class="font-extrabold text-slate-800 text-xs leading-snug">{{ $user->name }}</h4>
                                <p class="text-[10px] text-slate-400 font-semibold mt-0.5">Username: {{ $user->username }}</p>
                            </div>
                        </div>
                        
                        <span class="px-2 py-0.5 rounded-md bg-slate-50 border border-slate-100 text-[8px] font-black text-slate-500 uppercase tracking-widest">
                            @if($user->tipe_user === \App\Models\User::TYPE_ADMIN)
                                Admin
                            @elseif($user->tipe_user === \App\Models\User::TYPE_OWNER)
                                Owner
                            @else
                                Traveler
                            @endif
                        </span>
                    </div>
                @endforeach
            </div>
        </div>

        <!-- Latest Transactions -->
        <div class="bg-white rounded-[2.5rem] border border-slate-100 shadow-xl shadow-slate-200/40 p-6 md:p-8 space-y-6">
            <h2 class="text-lg font-black text-slate-900 tracking-tight flex items-center gap-2"><i class="fa-solid fa-money-check-dollar text-primary-500"></i> Log Transaksi Terbaru</h2>
            
            <div class="divide-y divide-slate-50">
                @foreach($latestTransactions as $trx)
                    <div class="py-3 flex items-center justify-between gap-4">
                        <div class="min-w-0">
                            <p class="font-bold text-slate-800 text-xs truncate">{{ $trx->order_id }}</p>
                            <p class="text-[9px] text-slate-400 font-black mt-0.5 tracking-wider">Rp {{ number_format($trx->total_price, 0, ',', '.') }}</p>
                        </div>
                        
                        <div>
                            @if($trx->status === 'settlement' || $trx->status === 'success')
                                <span class="px-2 py-0.5 rounded-md bg-emerald-50 text-emerald-600 font-black text-[8px] uppercase tracking-wider border border-emerald-100">Settlement</span>
                            @elseif($trx->status === 'pending')
                                <span class="px-2 py-0.5 rounded-md bg-amber-50 text-amber-600 font-black text-[8px] uppercase tracking-wider border border-amber-100">Pending</span>
                            @else
                                <span class="px-2 py-0.5 rounded-md bg-rose-50 text-rose-600 font-black text-[8px] uppercase tracking-wider border border-rose-100">{{ strtoupper($trx->status) }}</span>
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</div>
@endsection
