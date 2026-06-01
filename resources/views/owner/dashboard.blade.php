@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto px-4 md:px-6">
    <!-- Welcome Header Banner -->
    <div class="mb-10 bg-slate-900 rounded-[2.5rem] p-8 md:p-10 text-white relative overflow-hidden shadow-xl shadow-slate-950/10">
        <!-- Abstract gradient overlays -->
        <div class="absolute top-0 right-0 w-44 h-44 bg-white/5 rounded-full -mr-16 -mt-16 pointer-events-none"></div>
        <div class="absolute -bottom-10 -left-10 w-36 h-36 bg-primary-500/10 rounded-full blur-2xl pointer-events-none"></div>
        
        <div class="relative z-10 space-y-2">
            <span class="px-3 py-1 rounded-full bg-white/10 text-primary-300 text-[10px] font-black uppercase tracking-wider">Mitra Wisata Terverifikasi</span>
            <h1 class="text-3xl md:text-4xl font-black tracking-tight mt-2">Selamat Datang, {{ auth()->user()->name }}!</h1>
            <p class="text-xs text-slate-400 font-bold uppercase tracking-wider">Berikut adalah ringkasan performa penjualan tiket tempat wisata Anda.</p>
        </div>
    </div>

    @include('owner.partials.nav')

    <!-- Stats Grid -->
    <div class="grid gap-6 md:grid-cols-2 lg:grid-cols-4 mb-10">
        <!-- Stat Card 1: Tiket Terjual -->
        <div class="bg-white p-8 rounded-[2rem] border border-slate-100 shadow-xl shadow-slate-200/20 group hover:border-primary-300 transition-all relative overflow-hidden">
            <div class="absolute top-0 right-0 w-16 h-16 bg-primary-50 rounded-bl-full opacity-40"></div>
            <div class="w-12 h-12 rounded-2xl bg-primary-50 flex items-center justify-center text-primary-600 mb-6 group-hover:scale-110 transition-transform">
                <i class="fa-solid fa-ticket text-lg"></i>
            </div>
            <p class="text-[9px] text-slate-400 font-black uppercase tracking-widest mb-1">Total Tiket Terjual</p>
            <h3 class="text-3xl font-black text-slate-900 tracking-tight">{{ number_format($totalSold) }}</h3>
            <p class="text-[10px] text-emerald-600 font-bold mt-2 flex items-center gap-1"><i class="fa-solid fa-chart-line"></i> Seluruh Transaksi Sukses</p>
        </div>

        <!-- Stat Card 2: Total Pendapatan -->
        <div class="bg-white p-8 rounded-[2rem] border border-slate-100 shadow-xl shadow-slate-200/20 group hover:border-emerald-300 transition-all relative overflow-hidden">
            <div class="absolute top-0 right-0 w-16 h-16 bg-emerald-50 rounded-bl-full opacity-40"></div>
            <div class="w-12 h-12 rounded-2xl bg-emerald-50 flex items-center justify-center text-emerald-600 mb-6 group-hover:scale-110 transition-transform">
                <i class="fa-solid fa-money-bill-trend-up text-lg"></i>
            </div>
            <p class="text-[9px] text-slate-400 font-black uppercase tracking-widest mb-1">Total Pendapatan</p>
            <h3 class="text-3xl font-black text-slate-900 tracking-tight"><span class="text-sm font-medium text-slate-400">Rp</span> {{ number_format($totalRevenue, 0, ',', '.') }}</h3>
            <p class="text-[10px] text-emerald-600 font-bold mt-2 flex items-center gap-1"><i class="fa-solid fa-circle-check"></i> Masuk Ke Saldo Dompet</p>
        </div>

        <!-- Stat Card 3: Sisa Kuota Hari Ini -->
        <div class="bg-white p-8 rounded-[2rem] border border-slate-100 shadow-xl shadow-slate-200/20 group hover:border-amber-300 transition-all relative overflow-hidden">
            <div class="absolute top-0 right-0 w-16 h-16 bg-amber-50 rounded-bl-full opacity-40"></div>
            <div class="w-12 h-12 rounded-2xl bg-amber-50 flex items-center justify-center text-amber-600 mb-6 group-hover:scale-110 transition-transform">
                <i class="fa-solid fa-users-viewfinder text-lg"></i>
            </div>
            <p class="text-[9px] text-slate-400 font-black uppercase tracking-widest mb-1">Sisa Kuota Hari Ini</p>
            <h3 class="text-3xl font-black text-slate-900 tracking-tight">{{ number_format($todayRemainingQuota) }}</h3>
            <p class="text-[10px] text-amber-600 font-bold mt-2 flex items-center gap-1"><i class="fa-solid fa-circle-info"></i> Batas Kuota Kunjungan</p>
        </div>

        <!-- Stat Card 4: Withdrawal Pending -->
        <div class="bg-white p-8 rounded-[2rem] border border-slate-100 shadow-xl shadow-slate-200/20 group hover:border-rose-300 transition-all relative overflow-hidden">
            <div class="absolute top-0 right-0 w-16 h-16 bg-rose-50 rounded-bl-full opacity-40"></div>
            <div class="w-12 h-12 rounded-2xl bg-rose-50 flex items-center justify-center text-rose-600 mb-6 group-hover:scale-110 transition-transform">
                <i class="fa-solid fa-clock-rotate-left text-lg"></i>
            </div>
            <p class="text-[9px] text-slate-400 font-black uppercase tracking-widest mb-1">Pencairan Tertunda</p>
            <h3 class="text-3xl font-black text-slate-900 tracking-tight"><span class="text-sm font-medium text-slate-400">Rp</span> {{ number_format($pendingWithdrawal, 0, ',', '.') }}</h3>
            <p class="text-[10px] text-rose-600 font-bold mt-2 flex items-center gap-1"><i class="fa-solid fa-clock-rotate-left"></i> Sedang Direview Admin</p>
        </div>
    </div>

    <!-- Export Transaksi -->
    <div class="mb-10 bg-white rounded-[2.5rem] p-6 md:p-8 border border-slate-100 shadow-xl shadow-slate-200/30">
        <div class="flex flex-col lg:flex-row lg:items-end justify-between gap-6">
            <div>
                <h2 class="text-lg font-black text-slate-900 tracking-tight flex items-center gap-2">
                    <i class="fa-solid fa-file-csv text-emerald-500"></i> Export Laporan Transaksi
                </h2>
                <p class="text-xs text-slate-400 font-bold uppercase tracking-wider mt-1">Unduh CSV untuk laporan pajak atau administrasi</p>
            </div>
            <form method="GET" action="{{ route('owner.transactions.export') }}" class="flex flex-col sm:flex-row flex-wrap gap-3 items-end">
                <div>
                    <label class="block text-[9px] font-black text-slate-400 uppercase tracking-widest mb-1">Dari</label>
                    <input type="date" name="from" class="bg-slate-50 border border-slate-100 rounded-xl px-4 py-2.5 text-sm font-semibold text-slate-800">
                </div>
                <div>
                    <label class="block text-[9px] font-black text-slate-400 uppercase tracking-widest mb-1">Sampai</label>
                    <input type="date" name="to" class="bg-slate-50 border border-slate-100 rounded-xl px-4 py-2.5 text-sm font-semibold text-slate-800">
                </div>
                <div>
                    <label class="block text-[9px] font-black text-slate-400 uppercase tracking-widest mb-1">Status</label>
                    <select name="status" class="bg-slate-50 border border-slate-100 rounded-xl px-4 py-2.5 text-sm font-semibold text-slate-800 min-w-[140px]">
                        <option value="all">Semua</option>
                        <option value="settlement">Lunas</option>
                        <option value="used">Sudah Scan</option>
                        <option value="pending">Pending</option>
                        <option value="expire">Kedaluwarsa</option>
                        <option value="cancelled">Dibatalkan</option>
                    </select>
                </div>
                <button type="submit" class="bg-emerald-600 hover:bg-emerald-700 text-white font-extrabold px-6 py-2.5 rounded-xl text-xs uppercase tracking-wider shadow-md shadow-emerald-200 flex items-center gap-2">
                    <i class="fa-solid fa-download"></i> Unduh CSV
                </button>
            </form>
        </div>
    </div>

    <!-- Revenue Chart Section -->
    <div class="bg-white rounded-[2.5rem] p-8 md:p-10 border border-slate-100 shadow-xl shadow-slate-200/30">
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-10 pb-6 border-b border-slate-50">
            <div>
                <h2 class="text-xl font-bold text-slate-900 tracking-tight flex items-center gap-2"><i class="fa-solid fa-chart-simple text-primary-500"></i> Grafik Analisis Pendapatan</h2>
                <p class="text-xs text-slate-400 font-bold uppercase tracking-wider mt-1">Akumulasi total pendapatan dalam jangka waktu 6 bulan terakhir</p>
            </div>
            
            <div class="flex items-center gap-2.5 px-4 py-2 bg-primary-50 rounded-xl border border-primary-100 shadow-sm shrink-0">
                <span class="w-2 h-2 rounded-full bg-primary-500 animate-pulse"></span>
                <span class="text-[10px] font-black text-primary-700 uppercase tracking-widest">Mata Uang IDR (Rupiah)</span>
            </div>
        </div>

        <div class="relative h-[300px]">
            <canvas id="revenueChart"></canvas>
        </div>
    </div>
</div>

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const ctx = document.getElementById('revenueChart').getContext('2d');
        const chartData = @json($chart);
        
        new Chart(ctx, {
            type: 'bar',
            data: {
                labels: chartData.map(item => item.label),
                datasets: [{
                    label: 'Pendapatan',
                    data: chartData.map(item => item.amount),
                    backgroundColor: '#0ea5e9',
                    hoverBackgroundColor: '#0284c7',
                    borderRadius: 12,
                    borderSkipped: false,
                    barPercentage: 0.5,
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: { display: false },
                    tooltip: {
                        backgroundColor: '#0f172a',
                        padding: 12,
                        titleFont: { size: 10, weight: 'bold' },
                        bodyFont: { size: 13, weight: 'bold' },
                        callbacks: {
                            label: function(context) {
                                return ' Rp ' + new Intl.NumberFormat('id-ID').format(context.raw);
                            }
                        }
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        grid: { 
                            color: '#f1f5f9',
                            drawTicks: false
                        },
                        ticks: {
                            font: { size: 9, weight: '700' },
                            color: '#94a3b8',
                            callback: function(value) {
                                if (value >= 1000000) return (value / 1000000) + 'jt';
                                if (value >= 1000) return (value / 1000) + 'rb';
                                return value;
                            }
                        }
                    },
                    x: {
                        grid: { display: false },
                        ticks: {
                            font: { size: 9, weight: '800' },
                            color: '#94a3b8'
                        }
                    }
                }
            }
        });
    });
</script>
@endpush
@endsection
