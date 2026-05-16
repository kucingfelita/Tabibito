@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto px-4 py-12">
    <div class="bg-white rounded-[2.5rem] p-8 md:p-12 shadow-sm border border-slate-100">
        <h1 class="text-4xl font-black text-slate-900 mb-8">Kebijakan Privasi</h1>
        
        <div class="prose prose-slate max-w-none space-y-8">
            <section>
                <h2 class="text-xl font-bold text-slate-800 mb-4 flex items-center gap-3">
                    <span class="w-8 h-8 rounded-lg bg-emerald-50 text-emerald-600 flex items-center justify-center text-sm">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/></svg>
                    </span>
                    Komitmen Kami
                </h2>
                <p class="text-slate-600 leading-relaxed">
                    Privasi Anda sangat penting bagi kami. Kebijakan Privasi ini menjelaskan bagaimana kami mengumpulkan, menggunakan, dan melindungi informasi pribadi Anda saat menggunakan layanan Tabibito.
                </p>
            </section>

            <section>
                <h2 class="text-xl font-bold text-slate-800 mb-4 flex items-center gap-3">
                    <span class="w-8 h-8 rounded-lg bg-emerald-50 text-emerald-600 flex items-center justify-center text-sm">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16 20h4M4 12h4m12 0h.01M5 8h2a1 1 0 001-1V5a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1zm12 0h2a1 1 0 001-1V5a1 1 0 00-1-1h-2a1 1 0 00-1 1v2a1 1 0 001 1zM5 20h2a1 1 0 001-1v-2a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1z"/></svg>
                    </span>
                    Informasi yang Kami Kumpulkan
                </h2>
                <ul class="list-disc pl-5 space-y-2 text-slate-600">
                    <li><strong>Informasi Akun:</strong> Nama, alamat email, nomor telepon, dan kata sandi.</li>
                    <li><strong>Informasi Transaksi:</strong> Detail tiket yang dipesan, tanggal kunjungan, dan jumlah pembayaran.</li>
                    <li><strong>Informasi Teknis:</strong> Alamat IP, tipe browser, dan aktivitas penggunaan platform.</li>
                </ul>
            </section>

            <section>
                <h2 class="text-xl font-bold text-slate-800 mb-4 flex items-center gap-3">
                    <span class="w-8 h-8 rounded-lg bg-emerald-50 text-emerald-600 flex items-center justify-center text-sm">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>
                    </span>
                    Penggunaan Informasi
                </h2>
                <p class="text-slate-600 leading-relaxed">
                    Kami menggunakan informasi Anda untuk memproses pemesanan, mengirimkan e-tiket, memberikan dukungan pelanggan, dan meningkatkan layanan kami. Kami tidak akan pernah menjual informasi pribadi Anda kepada pihak ketiga.
                </p>
            </section>

            <section>
                <h2 class="text-xl font-bold text-slate-800 mb-4 flex items-center gap-3">
                    <span class="w-8 h-8 rounded-lg bg-emerald-50 text-emerald-600 flex items-center justify-center text-sm">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/></svg>
                    </span>
                    Keamanan Data
                </h2>
                <p class="text-slate-600 leading-relaxed">
                    Kami menerapkan standar keamanan industri untuk melindungi data Anda dari akses yang tidak sah, pengungkapan, atau modifikasi. Semua transmisi data sensitif dienkripsi menggunakan teknologi SSL.
                </p>
            </section>

            <section class="pt-8 border-t border-slate-100">
                <p class="text-sm text-slate-400 italic">Terakhir diperbarui: {{ date('d F Y') }}</p>
            </section>
        </div>
    </div>
</div>
@endsection
