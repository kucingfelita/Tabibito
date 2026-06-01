@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto px-4 py-12">
    <!-- Header Card -->
    <div class="bg-gradient-to-r from-slate-900 via-slate-800 to-primary-950 rounded-[2.5rem] p-8 md:p-12 shadow-xl text-white mb-10 relative overflow-hidden">
        <!-- Visual effects -->
        <div class="absolute -bottom-10 -left-10 w-40 h-40 bg-primary-500/10 rounded-full blur-2xl"></div>
        <div class="absolute -top-10 -right-10 w-40 h-40 bg-secondary-500/10 rounded-full blur-2xl"></div>
        
        <div class="relative z-10 space-y-4">
            <span class="px-3.5 py-1.5 rounded-xl bg-primary-500/20 text-primary-300 text-xs font-black uppercase tracking-widest border border-primary-500/20">Panduan Pengguna</span>
            <h1 class="text-3xl md:text-5xl font-black tracking-tight leading-tight">Syarat & Ketentuan Pengguna</h1>
            <p class="text-slate-400 text-xs md:text-sm font-semibold max-w-2xl leading-relaxed">
                Harap baca dengan cermat seluruh kesepakatan penggunaan layanan dan pemesanan tiket wisata di platform digital Tabibito Jawa Tengah.
            </p>
        </div>
    </div>

    <!-- Main Terms Content -->
    <div class="bg-white rounded-[2.5rem] p-8 md:p-12 shadow-sm border border-slate-100/80">
        <div class="prose prose-slate max-w-none space-y-10">
            
            <!-- Section 1 -->
            <section class="group">
                <h2 class="text-xl font-bold text-slate-800 mb-4 flex items-center gap-3">
                    <span class="w-9 h-9 rounded-xl bg-primary-50 text-primary-600 flex items-center justify-center text-sm font-extrabold shadow-sm group-hover:scale-110 transition-transform">01</span>
                    Ketentuan Umum & Penerimaan Syarat Penggunaan
                </h2>
                <div class="text-slate-600 leading-relaxed space-y-3 pl-12">
                    <p>
                        Dengan mengakses, mengunduh, menjelajahi, dan/atau menggunakan platform digital Tabibito (baik website maupun aplikasi), Anda menyatakan bahwa Anda telah membaca, memahami, dan menyetujui seluruh isi dari Syarat & Ketentuan ini secara sadar tanpa paksaan dari pihak mana pun.
                    </p>
                    <ul class="list-disc pl-5 space-y-2">
                        <li>Jika Anda tidak menyetujui salah satu atau seluruh poin dari ketentuan ini, Anda dilarang menggunakan platform dan layanan pemesanan tiket Tabibito.</li>
                        <li>Platform ini ditujukan bagi pengguna yang telah berusia minimal 18 tahun atau di bawah bimbingan dan pengawasan penuh dari orang tua/wali hukum yang sah.</li>
                        <li>Tabibito berhak untuk memperbarui, mengubah, atau memodifikasi Syarat & Ketentuan ini sewaktu-waktu tanpa pemberitahuan sebelumnya, dan perubahan tersebut akan langsung berlaku setelah dipublikasikan di halaman ini.</li>
                    </ul>
                </div>
            </section>

            <!-- Section 2 -->
            <section class="group">
                <h2 class="text-xl font-bold text-slate-800 mb-4 flex items-center gap-3">
                    <span class="w-9 h-9 rounded-xl bg-primary-50 text-primary-600 flex items-center justify-center text-sm font-extrabold shadow-sm group-hover:scale-110 transition-transform">02</span>
                    Pendaftaran Akun, Profil, & Keamanan Informasi
                </h2>
                <div class="text-slate-600 leading-relaxed space-y-3 pl-12">
                    <p>
                        Beberapa fitur pemesanan tiket mengharuskan pengguna untuk melakukan registrasi akun menggunakan email aktif, kata sandi, dan data pribadi yang akurat.
                    </p>
                    <ul class="list-disc pl-5 space-y-2">
                        <li>Pengguna bertanggung jawab penuh atas kerahasiaan username, email, password, serta OTP (One-Time Password) akun mereka sendiri.</li>
                        <li>Setiap transaksi, aktivitas, atau pemesanan tiket yang terjadi di bawah akun Anda sepenuhnya menjadi tanggung jawab hukum Anda pribadi.</li>
                        <li>Jika terjadi indikasi penyalahgunaan akun, peretasan, atau aktivitas mencurigakan lainnya, Anda wajib segera melaporkannya ke Layanan Bantuan Konsumen Tabibito.</li>
                    </ul>
                </div>
            </section>

            <!-- Section 3 -->
            <section class="group">
                <h2 class="text-xl font-bold text-slate-800 mb-4 flex items-center gap-3">
                    <span class="w-9 h-9 rounded-xl bg-primary-50 text-primary-600 flex items-center justify-center text-sm font-extrabold shadow-sm group-hover:scale-110 transition-transform">03</span>
                    Mekanisme Pemesanan, Kuota, & Penerbitan E-Ticket
                </h2>
                <div class="text-slate-600 leading-relaxed space-y-3 pl-12">
                    <p>
                        Setiap pemesanan e-ticket tempat wisata diproses secara real-time dan terintegrasi langsung dengan database ketersediaan kuota harian di masing-masing destinasi wisata.
                    </p>
                    <ul class="list-disc pl-5 space-y-2">
                        <li>Pengguna wajib meneliti kembali pilihan kategori tiket, destinasi tujuan, tanggal rencana kunjungan, jumlah pembelian, serta nominal pembayaran sebelum melanjutkan ke proses pembayaran.</li>
                        <li>Satu (1) e-ticket hanya berlaku untuk satu (1) orang pengunjung pada tanggal kunjungan spesifik yang telah dipilih saat transaksi checkout selesai.</li>
                        <li>E-Ticket resmi berupa QR Code unik akan otomatis dikirimkan ke email terdaftar serta tercatat di tab "Riwayat Pesanan" pengguna seketika setelah gerbang pembayaran memverifikasi transaksi sukses.</li>
                    </ul>
                </div>
            </section>

            <!-- Section 4 -->
            <section class="group">
                <h2 class="text-xl font-bold text-slate-800 mb-4 flex items-center gap-3">
                    <span class="w-9 h-9 rounded-xl bg-primary-50 text-primary-600 flex items-center justify-center text-sm font-extrabold shadow-sm group-hover:scale-110 transition-transform">04</span>
                    Metode Pembayaran Resmi, Batas Waktu, & Biaya Layanan
                </h2>
                <div class="text-slate-600 leading-relaxed space-y-3 pl-12">
                    <p>
                        Tabibito bekerja sama dengan gateway pembayaran resmi terenkripsi (Midtrans) untuk memproses pembayaran secara instan dan aman.
                    </p>
                    <ul class="list-disc pl-5 space-y-2">
                        <li>Metode pembayaran yang tersedia meliputi Virtual Account (VA) Bank, Kartu Kredit/Debit, E-Wallet (Gopay, ShopeePay, OVO), QRIS, serta pembayaran ritel merchant berizin resmi.</li>
                        <li>Pengguna wajib menyelesaikan pembayaran dalam batas waktu yang ditentukan (maksimal <strong>1 jam</strong> sejak pemesanan dibuat). Kelalaian penyelesaian pembayaran melewati batas waktu akan mengakibatkan pembatalan otomatis oleh sistem.</li>
                        <li>Tabibito berhak mengenakan biaya layanan administrasi platform yang nilainya akan tertera secara transparan pada rincian tagihan sebelum proses transaksi pembayaran dilakukan.</li>
                    </ul>
                </div>
            </section>

            <!-- Section 5 -->
            <section class="group">
                <h2 class="text-xl font-bold text-slate-800 mb-4 flex items-center gap-3">
                    <span class="w-9 h-9 rounded-xl bg-primary-50 text-primary-600 flex items-center justify-center text-sm font-extrabold shadow-sm group-hover:scale-110 transition-transform">05</span>
                    Kebijakan Pengembalian Dana (Refund) & Penjadwalan Ulang (Reschedule)
                </h2>
                <div class="text-slate-600 leading-relaxed space-y-3 pl-12">
                    <p>
                        Kebijakan pengembalian dana dan reschedule dirancang untuk memberikan kepastian hukum yang adil bagi wisatawan maupun mitra tempat wisata di lapangan.
                    </p>
                    <ul class="list-disc pl-5 space-y-2">
                        <li><strong>Ketentuan Pembatalan Sepihak:</strong> Tiket yang telah sukses diterbitkan bersifat final dan tidak dapat dibatalkan atau direfund atas keinginan sepihak/subjektif dari pengguna (seperti pembatalan liburan pribadi, salah pilih tanggal kunjungan oleh pembeli).</li>
                        <li><strong>Refund Khusus (Force Majeure):</strong> Pengembalian dana (refund) 100% hanya diizinkan apabila tempat wisata ditutup secara resmi pada tanggal kunjungan Anda karena keadaan kahar (bencana alam, cuaca buruk ekstrem, instruksi militer/kepolisian, renovasi darurat). Proses refund ini diajukan melalui portal Bantuan di akun Tabibito dan dana akan dikirimkan kembali maksimal <strong>7 hari kerja</strong>.</li>
                        <li><strong>Reschedule:</strong> Opsi perubahan tanggal kunjungan tergantung kebijakan masing-masing destinasi wisata. Pengajuan reschedule harus diajukan minimal <strong>24 jam</strong> sebelum jam kunjungan semula melalui koordinasi Customer Service Tabibito.</li>
                    </ul>
                </div>
            </section>

            <!-- Section 6 -->
            <section class="group">
                <h2 class="text-xl font-bold text-slate-800 mb-4 flex items-center gap-3">
                    <span class="w-9 h-9 rounded-xl bg-primary-50 text-primary-600 flex items-center justify-center text-sm font-extrabold shadow-sm group-hover:scale-110 transition-transform">06</span>
                    Tata Tertib, Jam Operasional, & Keselamatan Selama Kunjungan
                </h2>
                <div class="text-slate-600 leading-relaxed space-y-3 pl-12">
                    <p>
                        Setiap wisatawan wajib mematuhi seluruh hukum, aturan adat, tata tertib, serta jam operasional yang berlaku di masing-masing tempat wisata destinasi tujuan.
                    </p>
                    <ul class="list-disc pl-5 space-y-2">
                        <li>Pengunjung wajib membawa dan menunjukkan e-ticket resmi yang sah (dalam bentuk cetak maupun digital pada layar smartphone) untuk dipindai oleh petugas gerbang masuk menggunakan aplikasi scan.</li>
                        <li>Pengunjung dilarang keras membawa senjata tajam, obat-obatan terlarang, melakukan vandalisme, merusak warisan budaya alam, atau membuang sampah sembarangan di lokasi wisata.</li>
                        <li>Pelanggaran terhadap peraturan tata tertib di lokasi destinasi berhak mengakibatkan pengusiran paksa oleh petugas keamanan setempat tanpa kewajiban pengembalian dana tiket dari pihak mitra pariwisata maupun platform.</li>
                    </ul>
                </div>
            </section>

            <!-- Section 7 -->
            <section class="group">
                <h2 class="text-xl font-bold text-slate-800 mb-4 flex items-center gap-3">
                    <span class="w-9 h-9 rounded-xl bg-primary-50 text-primary-600 flex items-center justify-center text-sm font-extrabold shadow-sm group-hover:scale-110 transition-transform">07</span>
                    Hak Kekayaan Intelektual & Pembatasan Penggunaan
                </h2>
                <div class="text-slate-600 leading-relaxed space-y-3 pl-12">
                    <p>
                        Seluruh elemen desain, kode pemrograman, struktur basis data, konten, tulisan, merek dagang, nama domain, logo, dan karya kreatif yang termuat di dalam platform Tabibito adalah hak kekayaan intelektual resmi kami yang dilindungi undang-undang.
                    </p>
                    <ul class="list-disc pl-5 space-y-2">
                        <li>Anda dilarang keras menyalin, memodifikasi, mempublikasikan ulang, membuat karya turunan, melakukan teknik reverse engineering (rekayasa balik), atau memanen data secara otomatis (data scraping/crawling) terhadap seluruh aset digital Tabibito tanpa persetujuan tertulis terlebih dahulu dari manajemen Tabibito.</li>
                    </ul>
                </div>
            </section>

            <!-- Section 8 -->
            <section class="group">
                <h2 class="text-xl font-bold text-slate-800 mb-4 flex items-center gap-3">
                    <span class="w-9 h-9 rounded-xl bg-primary-50 text-primary-600 flex items-center justify-center text-sm font-extrabold shadow-sm group-hover:scale-110 transition-transform">08</span>
                    Batasan Tanggung Jawab Hukum & Penyelesaian Sengketa
                </h2>
                <div class="text-slate-600 leading-relaxed space-y-3 pl-12">
                    <p>
                        Tabibito bertindak secara sah sebagai agen pemasaran digital dan penyedia gerbang e-ticketing bagi pengelola tempat wisata (Mitra). Oleh sebab itu, batasan tanggung jawab diatur sebagai berikut:
                    </p>
                    <ul class="list-disc pl-5 space-y-2">
                        <li>Tabibito tidak bertanggung jawab atas cedera fisik, kehilangan barang berharga, kecelakaan di jalan raya menuju destinasi, kegagalan pelayanan fisik di lapangan, atau kelalaian pengelola wisata yang merugikan Anda di lokasi tujuan.</li>
                        <li>Seluruh transaksi diproses dan dilindungi berdasarkan hukum yang berlaku di Republik Indonesia.</li>
                        <li>Apabila timbul sengketa, keluhan, atau ketidakpuasan mengenai pelayanan, Anda dianjurkan untuk menyelesaikannya secara kekeluargaan terlebih dahulu melalui musyawarah. Jika sengketa tidak dapat diselesaikan melalui musyawarah, maka penyelesaian sengketa akan diajukan ke arbitrase atau pengadilan yang memiliki yurisdiksi atas wilayah kantor pusat Tabibito.</li>
                    </ul>
                </div>
            </section>

            <!-- Footer Section inside card -->
            <section class="pt-8 border-t border-slate-100 flex flex-col sm:flex-row items-center justify-between gap-4">
                <p class="text-xs text-slate-400 font-medium">Terakhir diperbarui: {{ date('d F Y') }}</p>
                <a href="{{ route('home') }}" class="text-xs font-bold text-primary-600 hover:text-primary-700 flex items-center gap-1.5 transition-colors">
                    <i class="fa-solid fa-chevron-left text-[10px]"></i> Kembali ke Beranda
                </a>
            </section>
        </div>
    </div>
</div>
@endsection
