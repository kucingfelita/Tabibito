@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto px-4 py-12">
    <!-- Header Card -->
    <div class="bg-gradient-to-r from-slate-900 via-slate-800 to-primary-950 rounded-[2.5rem] p-8 md:p-12 shadow-xl text-white mb-10 relative overflow-hidden">
        <!-- Visual effects -->
        <div class="absolute -bottom-10 -left-10 w-40 h-40 bg-primary-500/10 rounded-full blur-2xl"></div>
        <div class="absolute -top-10 -right-10 w-40 h-40 bg-secondary-500/10 rounded-full blur-2xl"></div>
        
        <div class="relative z-10 space-y-4">
            <span class="px-3.5 py-1.5 rounded-xl bg-primary-500/20 text-primary-300 text-xs font-black uppercase tracking-widest border border-primary-500/20">Dokumen Kemitraan</span>
            <h1 class="text-3xl md:text-5xl font-black tracking-tight leading-tight">Syarat & Ketentuan Kemitraan</h1>
            <p class="text-slate-400 text-xs md:text-sm font-semibold max-w-2xl leading-relaxed">
                Regulasi dan kesepakatan resmi bagi pengelola destinasi wisata (Mitra) yang tergabung dalam ekosistem digital Tabibito Jawa Tengah.
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
                    Pendaftaran Mitra & Validitas Legalitas Destinasi
                </h2>
                <div class="text-slate-600 leading-relaxed space-y-3 pl-12">
                    <p>
                        Setiap individu atau badan usaha yang mendaftar sebagai Mitra (Owner) wajib memberikan informasi identitas diri, legalitas kepemilikan destinasi wisata, serta data rekening bank yang sah dan akurat.
                    </p>
                    <ul class="list-disc pl-5 space-y-2">
                        <li>Mitra menjamin memiliki hak hukum penuh untuk mengelola dan menjual tiket destinasi wisata yang diajukan.</li>
                        <li>Tim Administrator Tabibito berhak melakukan verifikasi administratif, survei fisik, maupun wawancara sebelum memberikan persetujuan (approval) tayangnya destinasi wisata di platform.</li>
                        <li>Tabibito berhak menolak pendaftaran destinasi jika ditemukan ketidaksesuaian data, indikasi sengketa lahan, atau potensi bahaya keselamatan bagi pengunjung.</li>
                    </ul>
                </div>
            </section>

            <!-- Section 2 -->
            <section class="group">
                <h2 class="text-xl font-bold text-slate-800 mb-4 flex items-center gap-3">
                    <span class="w-9 h-9 rounded-xl bg-primary-50 text-primary-600 flex items-center justify-center text-sm font-extrabold shadow-sm group-hover:scale-110 transition-transform">02</span>
                    Pengelolaan Tiket, Kategori & Kebijakan Kuota Harian
                </h2>
                <div class="text-slate-600 leading-relaxed space-y-3 pl-12">
                    <p>
                        Mitra memiliki kendali penuh melalui dashboard pengelola untuk merilis tiket, mengatur kategori tiket (misal: Domestik, Mancanegara, Anak-anak, Dewasa), harga tiket, serta kapasitas kuota harian.
                    </p>
                    <ul class="list-disc pl-5 space-y-2">
                        <li><strong>Batasan Kuota Harian:</strong> Mitra wajib menginput kuota harian yang riil dan realistis demi kenyamanan dan daya tampung fisik di lapangan (carrying capacity) untuk mencegah kelebihan kapasitas (overcrowding).</li>
                        <li><strong>Ketepatan Informasi:</strong> Seluruh informasi mengenai manfaat tiket (benefit), fasilitas destinasi (outbound, parkir, konsumsi), jam buka-tutup, dan ketentuan khusus lainnya wajib dijabarkan secara jelas dan jujur tanpa adanya manipulasi informasi.</li>
                    </ul>
                </div>
            </section>

            <!-- Section 3 -->
            <section class="group">
                <h2 class="text-xl font-bold text-slate-800 mb-4 flex items-center gap-3">
                    <span class="w-9 h-9 rounded-xl bg-primary-50 text-primary-600 flex items-center justify-center text-sm font-extrabold shadow-sm group-hover:scale-110 transition-transform">03</span>
                    Biaya Layanan Platform & Mekanisme Bagi Hasil
                </h2>
                <div class="text-slate-600 leading-relaxed space-y-3 pl-12">
                    <p>
                        Untuk menunjang pemeliharaan server, integrasi gerbang pembayaran, dan pemasaran digital, Tabibito menetapkan potongan biaya layanan (platform service fee) untuk setiap transaksi tiket yang berhasil terjual.
                    </p>
                    <ul class="list-disc pl-5 space-y-2">
                        <li>Biaya layanan platform disepakati sebesar <strong>5% (lima persen)</strong> sampai dengan <strong>10% (sepuluh persen)</strong> dari harga kotor tiket yang terjual, tergantung skema kerja sama awal yang disetujui.</li>
                        <li>Harga tiket yang dipublikasikan di platform sudah harus merupakan harga akhir (termasuk pajak lokal destinasi pariwisata yang berlaku).</li>
                        <li>Sistem Tabibito akan menghitung secara otomatis pembagian hasil penjualan bersih (net revenue) Mitra setelah dikurangi biaya layanan platform pada setiap transaksi yang berhasil diselesaikan.</li>
                    </ul>
                </div>
            </section>

            <!-- Section 4 -->
            <section class="group">
                <h2 class="text-xl font-bold text-slate-800 mb-4 flex items-center gap-3">
                    <span class="w-9 h-9 rounded-xl bg-primary-50 text-primary-600 flex items-center justify-center text-sm font-extrabold shadow-sm group-hover:scale-110 transition-transform">04</span>
                    Prosedur Penarikan Pendapatan (Withdrawal) & Perpajakan
                </h2>
                <div class="text-slate-600 leading-relaxed space-y-3 pl-12">
                    <p>
                        Pendapatan bersih hasil penjualan tiket yang telah didepositkan ke akun Mitra dapat ditarik sewaktu-waktu melalui menu Penarikan Dana (Withdrawal) pada Dashboard Owner.
                    </p>
                    <ul class="list-disc pl-5 space-y-2">
                        <li>Batas minimum penarikan dana yang diperbolehkan adalah <strong>Rp 100.000 (seratus ribu rupiah)</strong> per pengajuan transaksi penarikan.</li>
                        <li>Proses peninjauan dan transfer dana ke rekening bank terdaftar Mitra membutuhkan waktu maksimal <strong>2 x 24 jam hari kerja</strong> sejak pengajuan dibuat oleh Mitra dan disetujui oleh Admin Keuangan Tabibito.</li>
                        <li>Seluruh kewajiban pelaporan dan penyetoran pajak yang timbul dari pendapatan tiket pariwisata (seperti Pajak Hiburan/Pajak Daerah, PPh) sepenuhnya menjadi tanggung jawab masing-masing Mitra sesuai ketentuan perundang-undangan perpajakan di Indonesia.</li>
                    </ul>
                </div>
            </section>

            <!-- Section 5 -->
            <section class="group">
                <h2 class="text-xl font-bold text-slate-800 mb-4 flex items-center gap-3">
                    <span class="w-9 h-9 rounded-xl bg-primary-50 text-primary-600 flex items-center justify-center text-sm font-extrabold shadow-sm group-hover:scale-110 transition-transform">05</span>
                    Kewajiban Boarding & Sistem Validasi E-Ticket (Scanning)
                </h2>
                <div class="text-slate-600 leading-relaxed space-y-3 pl-12">
                    <p>
                        Mitra bertanggung jawab penuh untuk menyediakan perangkat mobile/tablet dan petugas gerbang (staff/karyawan) guna melakukan validasi tiket pengunjung.
                    </p>
                    <ul class="list-disc pl-5 space-y-2">
                        <li>Petugas wajib memindai QR Code e-ticket pengunjung menggunakan fitur **Web Scanner** internal pada portal staff Tabibito.</li>
                        <li>Mitra dilarang meloloskan pengunjung tanpa melakukan proses scan tiket demi menjaga keakuratan kuota harian dan menghindari duplikasi tiket ilegal.</li>
                        <li>Setiap tiket yang telah sukses di-scan statusnya akan berubah menjadi **Digunakan (Used)** pada database pusat dan tidak dapat digunakan kembali untuk kunjungan lainnya.</li>
                    </ul>
                </div>
            </section>

            <!-- Section 6 -->
            <section class="group">
                <h2 class="text-xl font-bold text-slate-800 mb-4 flex items-center gap-3">
                    <span class="w-9 h-9 rounded-xl bg-primary-50 text-primary-600 flex items-center justify-center text-sm font-extrabold shadow-sm group-hover:scale-110 transition-transform">06</span>
                    Kebijakan Pembatalan, Refund, dan Force Majeure
                </h2>
                <div class="text-slate-600 leading-relaxed space-y-3 pl-12">
                    <p>
                        Dalam hal kenyamanan dan perlindungan hak konsumen, kebijakan pengembalian dana (refund) diatur secara terstruktur demi menjaga reputasi bersama.
                    </p>
                    <ul class="list-disc pl-5 space-y-2">
                        <li>Jika terjadi penutupan operasional destinasi wisata secara mendadak karena alasan cuaca buruk, bencana alam, perbaikan fasilitas, atau instruksi otoritas berwenang (Force Majeure), Mitra wajib segera mengubah status operasional destinasi di dashboard dan memproses pengembalian dana penuh (100% refund) kepada pembeli tiket yang terdampak pada tanggal tersebut.</li>
                        <li>Biaya pengembalian dana akibat penutupan sepihak oleh Mitra sepenuhnya akan dipotong dari saldo penangguhan Mitra di platform Tabibito.</li>
                    </ul>
                </div>
            </section>

            <!-- Section 7 -->
            <section class="group">
                <h2 class="text-xl font-bold text-slate-800 mb-4 flex items-center gap-3">
                    <span class="w-9 h-9 rounded-xl bg-primary-50 text-primary-600 flex items-center justify-center text-sm font-extrabold shadow-sm group-hover:scale-110 transition-transform">07</span>
                    Keamanan Informasi & Hak Kekayaan Intelektual
                </h2>
                <div class="text-slate-600 leading-relaxed space-y-3 pl-12">
                    <p>
                        Mitra dan Tabibito saling menghormati kepemilikan aset digital dan kekayaan intelektual masing-masing pihak.
                    </p>
                    <ul class="list-disc pl-5 space-y-2">
                        <li>Seluruh konten berupa logo, foto, deskripsi unik destinasi yang diunggah oleh Mitra tetap menjadi hak milik intelektual Mitra. Namun, Mitra memberikan izin lisensi non-eksklusif kepada Tabibito untuk menggunakan materi tersebut demi kebutuhan promosi pariwisata di media sosial dan kanal periklanan digital Tabibito.</li>
                        <li>Mitra wajib menjaga kerahasiaan username, password akun pengelola, serta akses portal scanner staff mereka. Tabibito tidak bertanggung jawab atas kebocoran data atau pencairan dana ilegal akibat kelalaian Mitra dalam menjaga kredensial akun.</li>
                    </ul>
                </div>
            </section>

            <!-- Section 8 -->
            <section class="group">
                <h2 class="text-xl font-bold text-slate-800 mb-4 flex items-center gap-3">
                    <span class="w-9 h-9 rounded-xl bg-primary-50 text-primary-600 flex items-center justify-center text-sm font-extrabold shadow-sm group-hover:scale-110 transition-transform">08</span>
                    Batasan Tanggung Jawab Hukum & Pengakhiran Kemitraan
                </h2>
                <div class="text-slate-600 leading-relaxed space-y-3 pl-12">
                    <p>
                        Tabibito berperan sebagai media perantara penjualan tiket elektronik (marketplace pariwisata) dan tidak bertanggung jawab atas kerugian fisik, kecelakaan, kehilangan barang bawaan, maupun insiden cedera yang dialami oleh pengunjung selama berada di lokasi fisik tempat wisata Mitra.
                    </p>
                    <ul class="list-disc pl-5 space-y-2">
                        <li>Mitra berkewajiban menyediakan fasilitas keselamatan, asuransi kecelakaan, serta menerapkan prosedur standar operasional (SOP) keselamatan yang memadai bagi setiap pengunjung.</li>
                        <li>Hubungan kemitraan dapat diakhiri secara sepihak apabila salah satu pihak melanggar ketentuan kesepakatan ini, melakukan tindakan penipuan harga tiket, penyalahgunaan sistem transaksi, atau mencemarkan nama baik platform.</li>
                        <li>Segala sengketa yang timbul di kemudian hari akan diselesaikan terlebih dahulu secara musyawarah mufakat. Apabila kesepakatan tidak tercapai, penyelesaian sengketa akan dirujuk melalui Pengadilan Negeri wilayah setempat.</li>
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
