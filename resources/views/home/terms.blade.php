@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto px-4 py-12">
    <div class="bg-white rounded-[2.5rem] p-8 md:p-12 shadow-sm border border-slate-100">
        <h1 class="text-4xl font-black text-slate-900 mb-8">Syarat & Ketentuan</h1>
        
        <div class="prose prose-slate max-w-none space-y-8">
            <section>
                <h2 class="text-xl font-bold text-slate-800 mb-4 flex items-center gap-3">
                    <span class="w-8 h-8 rounded-lg bg-primary-50 text-primary-600 flex items-center justify-center text-sm">01</span>
                    Penerimaan Ketentuan
                </h2>
                <p class="text-slate-600 leading-relaxed">
                    Dengan mengakses dan menggunakan platform Tabibito, Anda setuju untuk terikat oleh Syarat dan Ketentuan ini. Jika Anda tidak setuju dengan bagian mana pun dari ketentuan ini, Anda tidak diperbolehkan menggunakan layanan kami.
                </p>
            </section>

            <section>
                <h2 class="text-xl font-bold text-slate-800 mb-4 flex items-center gap-3">
                    <span class="w-8 h-8 rounded-lg bg-primary-50 text-primary-600 flex items-center justify-center text-sm">02</span>
                    Pemesanan Tiket
                </h2>
                <ul class="list-disc pl-5 space-y-2 text-slate-600">
                    <li>Semua pemesanan tiket bersifat final dan tidak dapat dibatalkan kecuali dinyatakan lain.</li>
                    <li>Pengguna wajib memberikan informasi yang akurat saat melakukan pemesanan.</li>
                    <li>Tiket hanya berlaku pada tanggal kunjungan yang telah dipilih saat pemesanan.</li>
                </ul>
            </section>

            <section>
                <h2 class="text-xl font-bold text-slate-800 mb-4 flex items-center gap-3">
                    <span class="w-8 h-8 rounded-lg bg-primary-50 text-primary-600 flex items-center justify-center text-sm">03</span>
                    Pembayaran
                </h2>
                <p class="text-slate-600 leading-relaxed">
                    Pembayaran dilakukan melalui gerbang pembayaran yang tersedia. Tabibito tidak menyimpan informasi kartu kredit atau detail pembayaran sensitif lainnya. Semua transaksi diproses secara aman.
                </p>
            </section>

            <section>
                <h2 class="text-xl font-bold text-slate-800 mb-4 flex items-center gap-3">
                    <span class="w-8 h-8 rounded-lg bg-primary-50 text-primary-600 flex items-center justify-center text-sm">04</span>
                    Tanggung Jawab Pengguna
                </h2>
                <p class="text-slate-600 leading-relaxed">
                    Pengguna bertanggung jawab untuk menjaga kerahasiaan akun dan kata sandi mereka. Segala aktivitas yang terjadi di bawah akun pengguna adalah tanggung jawab penuh pengguna yang bersangkutan.
                </p>
            </section>

            <section class="pt-8 border-t border-slate-100">
                <p class="text-sm text-slate-400 italic">Terakhir diperbarui: {{ date('d F Y') }}</p>
            </section>
        </div>
    </div>
</div>
@endsection
