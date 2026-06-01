@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto px-4 py-12">
    <!-- Header Card -->
    <div class="bg-gradient-to-r from-emerald-900 via-slate-800 to-primary-950 rounded-[2.5rem] p-8 md:p-12 shadow-xl text-white mb-10 relative overflow-hidden">
        <div class="absolute -bottom-10 -left-10 w-40 h-40 bg-emerald-500/10 rounded-full blur-2xl"></div>
        <div class="absolute -top-10 -right-10 w-40 h-40 bg-primary-500/10 rounded-full blur-2xl"></div>

        <div class="relative z-10 space-y-4">
            <span class="px-3.5 py-1.5 rounded-xl bg-emerald-500/20 text-emerald-300 text-xs font-black uppercase tracking-widest border border-emerald-500/20">Perlindungan Data</span>
            <h1 class="text-3xl md:text-5xl font-black tracking-tight leading-tight">Kebijakan Privasi</h1>
            <p class="text-slate-400 text-xs md:text-sm font-semibold max-w-2xl leading-relaxed">
                Dokumen ini menjelaskan bagaimana Tabibito Jawa Tengah mengumpulkan, menggunakan, menyimpan, dan melindungi data pribadi Anda saat menggunakan platform pemesanan tiket wisata kami.
            </p>
        </div>
    </div>

    <!-- Main Content -->
    <div class="bg-white rounded-[2.5rem] p-8 md:p-12 shadow-sm border border-slate-100/80">
        <div class="prose prose-slate max-w-none space-y-10">

            <section class="group">
                <h2 class="text-xl font-bold text-slate-800 mb-4 flex items-center gap-3">
                    <span class="w-9 h-9 rounded-xl bg-emerald-50 text-emerald-600 flex items-center justify-center text-sm font-extrabold shadow-sm">01</span>
                    Pendahuluan & Ruang Lingkup
                </h2>
                <div class="text-slate-600 leading-relaxed space-y-3 pl-12">
                    <p>
                        Tabibito ("kami", "platform") berkomitmen untuk melindungi privasi dan keamanan data pribadi seluruh pengguna, termasuk wisatawan (Traveler), mitra pengelola destinasi wisata (Owner), serta staf operasional mitra yang menggunakan portal scanner.
                    </p>
                    <p>
                        Kebijakan Privasi ini berlaku untuk seluruh layanan yang disediakan melalui website Tabibito Jawa Tengah, termasuk pendaftaran akun, pemesanan tiket, pembayaran digital, riwayat transaksi, wishlist, ulasan destinasi, program kemitraan, dan komunikasi layanan pelanggan.
                    </p>
                    <p>
                        Dengan menggunakan platform kami, Anda dianggap telah membaca dan memahami Kebijakan Privasi ini. Kebijakan ini melengkapi <a href="{{ route('terms') }}" class="text-primary-600 font-bold hover:underline">Syarat & Ketentuan Pengguna</a> dan, bagi mitra, <a href="{{ route('terms.partnership') }}" class="text-primary-600 font-bold hover:underline">Syarat & Ketentuan Kemitraan</a>.
                    </p>
                </div>
            </section>

            <section class="group">
                <h2 class="text-xl font-bold text-slate-800 mb-4 flex items-center gap-3">
                    <span class="w-9 h-9 rounded-xl bg-emerald-50 text-emerald-600 flex items-center justify-center text-sm font-extrabold shadow-sm">02</span>
                    Definisi Data Pribadi
                </h2>
                <div class="text-slate-600 leading-relaxed space-y-3 pl-12">
                    <p>
                        Data pribadi adalah setiap informasi yang dapat mengidentifikasi Anda secara langsung atau tidak langsung, baik yang Anda berikan secara sukarela maupun yang dikumpulkan secara otomatis saat menggunakan layanan kami.
                    </p>
                    <ul class="list-disc pl-5 space-y-2">
                        <li><strong>Data identitas:</strong> nama lengkap, foto profil (jika diunggah), tanggal lahir (jika diminta).</li>
                        <li><strong>Data kontak:</strong> alamat email, nomor telepon/WhatsApp.</li>
                        <li><strong>Data akun:</strong> kata sandi terenkripsi, peran pengguna (Traveler/Owner/Admin), status verifikasi.</li>
                        <li><strong>Data transaksi:</strong> order ID, detail tiket, tanggal kunjungan, jumlah pembelian, nominal pembayaran, status transaksi, token QR e-tiket.</li>
                        <li><strong>Data keuangan mitra:</strong> nama bank, nomor rekening, nama pemilik rekening (khusus Owner untuk pencairan dana).</li>
                        <li><strong>Data teknis:</strong> alamat IP, jenis perangkat, browser, log aktivitas, cookie sesi.</li>
                    </ul>
                </div>
            </section>

            <section class="group">
                <h2 class="text-xl font-bold text-slate-800 mb-4 flex items-center gap-3">
                    <span class="w-9 h-9 rounded-xl bg-emerald-50 text-emerald-600 flex items-center justify-center text-sm font-extrabold shadow-sm">03</span>
                    Informasi yang Kami Kumpulkan
                </h2>
                <div class="text-slate-600 leading-relaxed space-y-3 pl-12">
                    <p>Kami mengumpulkan data melalui beberapa cara berikut:</p>
                    <ul class="list-disc pl-5 space-y-2">
                        <li><strong>Registrasi & profil:</strong> saat Anda mendaftar, login (termasuk Google OAuth), atau memperbarui profil.</li>
                        <li><strong>Proses checkout:</strong> saat memilih tiket, tanggal kunjungan, jumlah kuota, dan mengonfirmasi pembayaran.</li>
                        <li><strong>Gateway pembayaran:</strong> status pembayaran dari Midtrans (berhasil, pending, kedaluwarsa) tanpa menyimpan nomor kartu kredit/debit penuh di server kami.</li>
                        <li><strong>Kunjungan wisata:</strong> data pemindaian QR di gerbang masuk (waktu scan, status tiket) untuk validasi keabsahan tiket.</li>
                        <li><strong>Interaksi pengguna:</strong> wishlist destinasi, ulasan & rating, pesan kontak, langganan newsletter (jika Anda berlangganan).</li>
                        <li><strong>Kemitraan Owner:</strong> data legal destinasi, dokumen verifikasi, pengaturan tiket/kuota, riwayat pencairan dana.</li>
                    </ul>
                </div>
            </section>

            <section class="group">
                <h2 class="text-xl font-bold text-slate-800 mb-4 flex items-center gap-3">
                    <span class="w-9 h-9 rounded-xl bg-emerald-50 text-emerald-600 flex items-center justify-center text-sm font-extrabold shadow-sm">04</span>
                    Tujuan Penggunaan Data
                </h2>
                <div class="text-slate-600 leading-relaxed space-y-3 pl-12">
                    <p>Data pribadi Anda digunakan untuk tujuan yang sah dan terbatas, antara lain:</p>
                    <ul class="list-disc pl-5 space-y-2">
                        <li>Memproses pemesanan, menerbitkan e-tiket, dan mengirimkan invoice/pemberitahuan transaksi ke email Anda.</li>
                        <li>Mengelola batas waktu pembayaran (6 jam), pembatalan otomatis, serta pengembalian kuota tiket.</li>
                        <li>Memverifikasi keabsahan tiket saat kunjungan melalui sistem scanner mitra.</li>
                        <li>Menyediakan riwayat pesanan, refund sesuai kebijakan, dan layanan bantuan pelanggan.</li>
                        <li>Memproses pencairan dana mitra ke rekening bank yang terdaftar.</li>
                        <li>Mencegah penipuan, penyalahgunaan akun, dan aktivitas yang melanggar syarat platform.</li>
                        <li>Meningkatkan kualitas layanan, analitik agregat (non-identitas pribadi), dan pengembangan fitur platform.</li>
                        <li>Memenuhi kewajiban hukum dan permintaan otoritas yang berwenang sesuai peraturan Indonesia.</li>
                    </ul>
                </div>
            </section>

            <section class="group">
                <h2 class="text-xl font-bold text-slate-800 mb-4 flex items-center gap-3">
                    <span class="w-9 h-9 rounded-xl bg-emerald-50 text-emerald-600 flex items-center justify-center text-sm font-extrabold shadow-sm">05</span>
                    Pembagian Data kepada Pihak Ketiga
                </h2>
                <div class="text-slate-600 leading-relaxed space-y-3 pl-12">
                    <p>
                        Kami <strong>tidak menjual</strong> data pribadi Anda kepada pihak ketiga. Data hanya dibagikan apabila diperlukan untuk operasional layanan:
                    </p>
                    <ul class="list-disc pl-5 space-y-2">
                        <li><strong>Midtrans:</strong> pemrosesan pembayaran Virtual Account, e-wallet, QRIS, dan kartu kredit/debit.</li>
                        <li><strong>Mitra destinasi wisata:</strong> nama pemesan, tanggal kunjungan, jumlah tiket, dan status validasi scan — hanya untuk tiket yang berlaku di destinasi mereka.</li>
                        <li><strong>Penyedia infrastruktur:</strong> hosting, email transaksional, dan layanan teknis yang terikat perjanjian kerahasiaan.</li>
                        <li><strong>Google (OAuth):</strong> jika Anda login menggunakan akun Google, kami menerima data profil dasar sesuai izin yang Anda berikan.</li>
                        <li><strong>Penegak hukum:</strong> apabila diwajibkan oleh undang-undang atau perintah pengadilan yang sah.</li>
                    </ul>
                </div>
            </section>

            <section class="group">
                <h2 class="text-xl font-bold text-slate-800 mb-4 flex items-center gap-3">
                    <span class="w-9 h-9 rounded-xl bg-emerald-50 text-emerald-600 flex items-center justify-center text-sm font-extrabold shadow-sm">06</span>
                    Cookie & Teknologi Pelacakan
                </h2>
                <div class="text-slate-600 leading-relaxed space-y-3 pl-12">
                    <p>
                        Platform menggunakan cookie dan session untuk menjaga status login, keranjang/checkout, preferensi antarmuka, serta keamanan sesi. Anda dapat mengatur browser untuk menolak cookie, namun beberapa fitur (seperti login dan checkout) mungkin tidak berfungsi optimal.
                    </p>
                </div>
            </section>

            <section class="group">
                <h2 class="text-xl font-bold text-slate-800 mb-4 flex items-center gap-3">
                    <span class="w-9 h-9 rounded-xl bg-emerald-50 text-emerald-600 flex items-center justify-center text-sm font-extrabold shadow-sm">07</span>
                    Keamanan & Enkripsi Data
                </h2>
                <div class="text-slate-600 leading-relaxed space-y-3 pl-12">
                    <p>
                        Kami menerapkan langkah keamanan yang wajar secara industri, termasuk enkripsi SSL/TLS pada transmisi data, hashing kata sandi, pembatasan akses berbasis peran (RBAC), serta pemantauan aktivitas mencurigakan.
                    </p>
                    <p>
                        Meskipun demikian, tidak ada sistem yang 100% aman. Anda bertanggung jawab menjaga kerahasiaan kredensial akun dan segera melaporkan ke <a href="{{ route('contact') }}" class="text-primary-600 font-bold hover:underline">halaman kontak</a> jika menduga akun Anda disalahgunakan.
                    </p>
                </div>
            </section>

            <section class="group">
                <h2 class="text-xl font-bold text-slate-800 mb-4 flex items-center gap-3">
                    <span class="w-9 h-9 rounded-xl bg-emerald-50 text-emerald-600 flex items-center justify-center text-sm font-extrabold shadow-sm">08</span>
                    Hak Anda atas Data Pribadi
                </h2>
                <div class="text-slate-600 leading-relaxed space-y-3 pl-12">
                    <p>Sesuai prinsip perlindungan data yang berlaku, Anda berhak untuk:</p>
                    <ul class="list-disc pl-5 space-y-2">
                        <li><strong>Mengakses</strong> data profil dan riwayat transaksi melalui akun Anda.</li>
                        <li><strong>Memperbarui</strong> data yang tidak akurat melalui halaman profil.</li>
                        <li><strong>Membatalkan pesanan pending</strong> sebelum pembayaran berhasil (kuota dikembalikan).</li>
                        <li><strong>Meminta penghapusan akun</strong> dengan menghubungi layanan pelanggan, dengan catatan data transaksi yang sudah terjadi dapat tetap disimpan untuk keperluan audit hukum dan akuntansi.</li>
                        <li><strong>Menarik persetujuan</strong> komunikasi pemasaran (newsletter) kapan saja.</li>
                    </ul>
                </div>
            </section>

            <section class="group">
                <h2 class="text-xl font-bold text-slate-800 mb-4 flex items-center gap-3">
                    <span class="w-9 h-9 rounded-xl bg-emerald-50 text-emerald-600 flex items-center justify-center text-sm font-extrabold shadow-sm">09</span>
                    Retensi & Penyimpanan Data
                </h2>
                <div class="text-slate-600 leading-relaxed space-y-3 pl-12">
                    <p>
                        Data akun dan transaksi disimpan selama akun aktif dan sesuai kebutuhan operasional, audit, penyelesaian sengketa, serta kewajiban hukum. Data transaksi yang telah settlement disimpan untuk keperluan validasi tiket, laporan mitra, dan bukti hukum sesuai ketentuan yang berlaku.
                    </p>
                    <p>
                        Data pesanan yang dibatalkan atau kedaluwarsa (status <em>expire</em>/<em>cancelled</em>) dapat disimpan dalam bentuk arsip terbatas tanpa digunakan untuk tujuan pemasaran.
                    </p>
                </div>
            </section>

            <section class="group">
                <h2 class="text-xl font-bold text-slate-800 mb-4 flex items-center gap-3">
                    <span class="w-9 h-9 rounded-xl bg-emerald-50 text-emerald-600 flex items-center justify-center text-sm font-extrabold shadow-sm">10</span>
                    Privasi Anak & Pengguna di Bawah Umur
                </h2>
                <div class="text-slate-600 leading-relaxed space-y-3 pl-12">
                    <p>
                        Layanan Tabibito ditujukan bagi pengguna berusia minimal 18 tahun, atau pengguna di bawah umur yang menggunakan platform di bawah pengawasan dan persetujuan orang tua/wali hukum. Kami tidak dengan sengaja mengumpulkan data pribadi anak di bawah 13 tahun tanpa persetujuan orang tua.
                    </p>
                </div>
            </section>

            <section class="group">
                <h2 class="text-xl font-bold text-slate-800 mb-4 flex items-center gap-3">
                    <span class="w-9 h-9 rounded-xl bg-emerald-50 text-emerald-600 flex items-center justify-center text-sm font-extrabold shadow-sm">11</span>
                    Perubahan Kebijakan Privasi
                </h2>
                <div class="text-slate-600 leading-relaxed space-y-3 pl-12">
                    <p>
                        Kami dapat memperbarui Kebijakan Privasi ini sewaktu-waktu. Perubahan material akan dipublikasikan di halaman ini dengan tanggal pembaruan terbaru. Penggunaan berkelanjutan atas platform setelah perubahan dianggap sebagai penerimaan kebijakan yang diperbarui.
                    </p>
                </div>
            </section>

            <section class="group">
                <h2 class="text-xl font-bold text-slate-800 mb-4 flex items-center gap-3">
                    <span class="w-9 h-9 rounded-xl bg-emerald-50 text-emerald-600 flex items-center justify-center text-sm font-extrabold shadow-sm">12</span>
                    Kontak & Pengaduan
                </h2>
                <div class="text-slate-600 leading-relaxed space-y-3 pl-12">
                    <p>
                        Untuk pertanyaan, permintaan akses data, atau keluhan terkait privasi, silakan hubungi kami melalui <a href="{{ route('contact') }}" class="text-primary-600 font-bold hover:underline">halaman Kontak</a> atau email layanan pelanggan yang tercantum di platform.
                    </p>
                    <p>
                        Kami akan berupaya menanggapi permintaan Anda dalam waktu wajar sesuai kompleksitas permintaan dan ketentuan hukum yang berlaku di Indonesia.
                    </p>
                </div>
            </section>

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
