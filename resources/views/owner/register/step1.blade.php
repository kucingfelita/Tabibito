@extends('layouts.app')

@section('content')
<div class="max-w-6xl mx-auto px-4 md:px-0 py-6" x-data="{ showTermsModal: true, agreed: false }">

    <!-- Beautiful Glassmorphic Modal for Terms & Conditions -->
    <div x-show="showTermsModal" 
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         x-transition:leave="transition ease-in duration-200"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0"
         class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-slate-900/60 backdrop-blur-md">
         
         <div x-show="showTermsModal"
              x-transition:enter="transition ease-out duration-300 transform"
              x-transition:enter-start="opacity-0 scale-95 translate-y-4"
              x-transition:enter-end="opacity-100 scale-100 translate-y-0"
              x-transition:leave="transition ease-in duration-200 transform"
              x-transition:leave-start="opacity-100 scale-100 translate-y-0"
              x-transition:leave-end="opacity-0 scale-95 translate-y-4"
              class="bg-white rounded-[2.5rem] border border-slate-100 shadow-2xl w-full max-w-2xl overflow-hidden flex flex-col max-h-[85vh] relative">
              
              <!-- Modal Decor Spark -->
              <div class="absolute top-0 right-0 w-32 h-32 bg-primary-50 rounded-full -mr-16 -mt-16 opacity-50 z-0"></div>

              <!-- Header -->
              <div class="p-6 md:p-8 border-b border-slate-100 relative z-10 shrink-0">
                  <span class="px-3 py-1 rounded-full bg-primary-50 text-primary-700 text-[10px] font-black uppercase tracking-wider">Mitra Wisata Tabibito</span>
                  <h3 class="text-xl md:text-2xl font-black text-slate-900 tracking-tight mt-2">Syarat & Ketentuan Kemitraan</h3>
                  <p class="text-xs text-slate-400 font-bold uppercase tracking-wider mt-0.5">Harap baca dan setujui kesepakatan di bawah ini sebelum mendaftar</p>
              </div>

              <!-- Scrollable Terms Content -->
              <div class="p-6 md:p-8 overflow-y-auto custom-scrollbar space-y-6 text-slate-600 text-sm font-medium leading-relaxed border-b border-slate-100 z-10 flex-1">
                  <div class="bg-slate-50 border border-slate-100 rounded-2xl p-5 space-y-3">
                      <p class="font-extrabold text-slate-800 text-xs uppercase tracking-wider flex items-center gap-2"><i class="fa-solid fa-scale-balanced text-primary-500"></i> PENGANTAR KEMITRAAN</p>
                      <p class="text-xs text-slate-500">
                          Selamat datang di portal pendaftaran kemitraan Tabibito Jawa Tengah. Dengan mendaftar sebagai pengelola destinasi wisata (Mitra/Owner), Anda wajib menyetujui seluruh ketentuan operasional, biaya layanan platform, sistem pemindaian boarding pass, dan tanggung jawab hukum yang terinci di bawah ini.
                      </p>
                  </div>

                  <div class="space-y-4">
                      <!-- Bab 1 -->
                      <div class="space-y-2">
                          <p class="font-bold text-slate-800 text-sm flex items-center gap-2">
                              <span class="w-6 h-6 rounded-lg bg-primary-50 text-primary-600 flex items-center justify-center text-xs font-black">1</span>
                              Validitas Akun & Kepemilikan Tempat Wisata
                          </p>
                          <p class="text-xs pl-8 text-slate-500">
                              Mitra menyatakan secara hukum bahwa data diri, kepemilikan, dan perizinan atas tempat wisata yang didaftarkan adalah sah, bebas dari sengketa hukum, dan aktif secara operasional di Jawa Tengah.
                          </p>
                      </div>

                      <!-- Bab 2 -->
                      <div class="space-y-2">
                          <p class="font-bold text-slate-800 text-sm flex items-center gap-2">
                              <span class="w-6 h-6 rounded-lg bg-primary-50 text-primary-600 flex items-center justify-center text-xs font-black">2</span>
                              Pengaturan Kuota Tiket Harian
                          </p>
                          <p class="text-xs pl-8 text-slate-500">
                              Mitra berkewajiban mengelola batas kapasitas kuota harian pariwisata secara riil pada dashboard. Hal ini mutlak guna menjamin keselamatan fisik pengunjung di lokasi destinasi wisata.
                          </p>
                      </div>

                      <!-- Bab 3 -->
                      <div class="space-y-2">
                          <p class="font-bold text-slate-800 text-sm flex items-center gap-2">
                              <span class="w-6 h-6 rounded-lg bg-primary-50 text-primary-600 flex items-center justify-center text-xs font-black">3</span>
                              Sistem Pembagian Hasil & Komisi Platform
                          </p>
                          <p class="text-xs pl-8 text-slate-500">
                              Tabibito berhak memotong biaya administrasi/layanan platform sebesar 5% s/d 10% dari setiap tiket kotor yang terjual sukses melalui gerbang pembayaran Midtrans.
                          </p>
                      </div>

                      <!-- Bab 4 -->
                      <div class="space-y-2">
                          <p class="font-bold text-slate-800 text-sm flex items-center gap-2">
                              <span class="w-6 h-6 rounded-lg bg-primary-50 text-primary-600 flex items-center justify-center text-xs font-black">4</span>
                              Pencairan Saldo (Withdrawals)
                          </p>
                          <p class="text-xs pl-8 text-slate-500">
                              Penarikan pendapatan bersih dapat ditarik dengan batas minimum Rp 100.000. Pengajuan penarikan dana akan diproses secara aman ke rekening terdaftar dalam waktu maksimal 2x24 jam hari kerja.
                          </p>
                      </div>

                      <!-- Bab 5 -->
                      <div class="space-y-2">
                          <p class="font-bold text-slate-800 text-sm flex items-center gap-2">
                              <span class="w-6 h-6 rounded-lg bg-primary-50 text-primary-600 flex items-center justify-center text-xs font-black">5</span>
                              Validasi Scanner Boarding QR Code
                          </p>
                          <p class="text-xs pl-8 text-slate-500">
                              Mitra dan petugas loket wajib melakukan verifikasi boarding pass pengunjung secara tertib menggunakan web scanner yang disediakan oleh Tabibito guna mencegah tiket ganda/ilegal.
                          </p>
                      </div>

                      <!-- Bab 6 -->
                      <div class="space-y-2">
                          <p class="font-bold text-slate-800 text-sm flex items-center gap-2">
                              <span class="w-6 h-6 rounded-lg bg-primary-50 text-primary-600 flex items-center justify-center text-xs font-black">6</span>
                              Kebijakan Pengembalian Dana (Refund)
                          </p>
                          <p class="text-xs pl-8 text-slate-500">
                              Apabila terjadi pembatalan kunjungan akibat force majeure atau penutupan paksa tempat wisata oleh Mitra, Mitra berkewajiban menyetujui pengembalian dana 100% kepada calon pengunjung.
                          </p>
                      </div>

                      <!-- Bab 7 -->
                      <div class="space-y-2">
                          <p class="font-bold text-slate-800 text-sm flex items-center gap-2">
                              <span class="w-6 h-6 rounded-lg bg-primary-50 text-primary-600 flex items-center justify-center text-xs font-black">7</span>
                              Asuransi & Tanggung Jawab Fisik Pengunjung
                          </p>
                          <p class="text-xs pl-8 text-slate-500">
                              Seluruh bentuk kecelakaan fisik, cedera, kehilangan barang bawaan, dan aspek keselamatan di lapangan tempat wisata sepenuhnya menjadi tanggung jawab Mitra. Tabibito dibebaskan dari segala tuntutan hukum di luar transaksi e-ticketing.
                          </p>
                      </div>
                  </div>
              </div>

              <!-- Footer Buttons -->
              <div class="p-6 md:p-8 border-t border-slate-100 bg-slate-50 relative z-10 shrink-0 space-y-4">
                  <!-- Checkbox -->
                  <label class="relative flex items-start gap-3 cursor-pointer select-none">
                      <input type="checkbox" x-model="agreed" class="w-5 h-5 rounded text-primary-600 border-slate-300 focus:ring-primary-500/20 mt-0.5 cursor-pointer">
                      <span class="text-xs font-bold text-slate-600 leading-normal">
                          Saya telah membaca, memahami, dan menyetujui seluruh isi <a href="{{ route('terms.partnership') }}" target="_blank" class="text-primary-600 underline">Syarat & Ketentuan Kemitraan</a> yang berlaku di Tabibito.
                      </span>
                  </label>

                  <div class="flex flex-col sm:flex-row gap-3 pt-2">
                      <!-- Disagree / Back Button -->
                      <a href="{{ route('home') }}" class="w-full sm:w-1/3 flex items-center justify-center border border-slate-200 hover:border-slate-300 bg-white text-slate-500 font-extrabold py-3.5 rounded-2xl transition-all text-xs uppercase tracking-wider active:scale-95">
                          Batal & Kembali
                      </a>
                      
                      <!-- Agree / Continue Button -->
                      <button type="button" 
                              @click="showTermsModal = false" 
                              :disabled="!agreed"
                              class="w-full sm:w-2/3 flex items-center justify-center bg-primary-600 hover:bg-primary-700 disabled:bg-slate-200 disabled:text-slate-400 text-white font-extrabold py-3.5 rounded-2xl shadow-xl shadow-primary-600/20 disabled:shadow-none transition-all text-xs uppercase tracking-wider active:scale-95">
                          Setuju & Lanjutkan
                      </button>
                  </div>
              </div>

         </div>
    </div>

    <div class="bg-white rounded-[2.5rem] border border-slate-100 shadow-xl shadow-slate-200/40 overflow-hidden relative">
        <div class="grid lg:grid-cols-12 min-h-[600px] items-stretch">
            
            <!-- Left Side: Form Section (Col span 7 on large screens) -->
            <div class="lg:col-span-7 p-8 md:p-14 flex flex-col justify-center relative">
                <!-- Sparkle Background -->
                <div class="absolute top-0 left-0 w-32 h-32 bg-primary-50 rounded-full -ml-16 -mt-16 opacity-40"></div>
                
                <div class="max-w-md w-full mx-auto relative z-10 space-y-8">
                    <!-- Heading -->
                    <div class="text-center lg:text-left space-y-2">
                        <span class="px-3 py-1 rounded-full bg-primary-50 text-primary-700 text-[10px] font-black uppercase tracking-wider">Mitra Wisata</span>
                        <h1 class="text-3xl font-black text-slate-900 tracking-tight">Gabung sebagai Mitra</h1>
                        <p class="text-xs text-slate-400 font-bold uppercase tracking-wider">Langkah 1: Lengkapi Kredensial Akun Anda</p>
                    </div>

                    <!-- Registration Form -->
                    <form method="POST" action="{{ route('owner.register.step1.store') }}" class="space-y-5" id="owner-reg-step1">
                        @csrf
                        
                        <!-- Input Username -->
                        <div class="space-y-2">
                            <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest ml-1">Username Pengelola</label>
                            <div class="relative group">
                                <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-slate-400 group-focus-within:text-primary-600 transition-colors">
                                    <i class="fa-solid fa-user-tag text-sm"></i>
                                </div>
                                <input type="text" name="username" id="username" value="{{ old('username') }}" required placeholder="Contoh: candisejahtera" 
                                       class="w-full bg-slate-50 border border-slate-100 rounded-2xl pl-11 pr-4 py-4 text-slate-800 font-bold focus:ring-2 focus:ring-primary-500/20 focus:border-primary-500 outline-none transition-all placeholder:text-slate-400/80">
                            </div>
                        </div>

                        <!-- Input Email -->
                        <div class="space-y-2">
                            <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest ml-1">Email Resmi Pengelola</label>
                            <div class="relative group">
                                <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-slate-400 group-focus-within:text-primary-600 transition-colors">
                                    <i class="fa-regular fa-envelope text-sm"></i>
                                </div>
                                <input type="email" name="email" id="email" value="{{ old('email') }}" required placeholder="Contoh: info@candisejahtera.com" 
                                       class="w-full bg-slate-50 border border-slate-100 rounded-2xl pl-11 pr-4 py-4 text-slate-800 font-bold focus:ring-2 focus:ring-primary-500/20 focus:border-primary-500 outline-none transition-all placeholder:text-slate-400/80">
                            </div>
                        </div>

                        <!-- Input Password -->
                        <div class="space-y-2">
                            <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest ml-1">Kata Sandi</label>
                            <div class="relative group" x-data="{ show: false }">
                                <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-slate-400 group-focus-within:text-primary-600 transition-colors">
                                    <i class="fa-solid fa-lock text-sm"></i>
                                </div>
                                <input :type="show ? 'text' : 'password'" name="password" id="password" required placeholder="••••••••" 
                                       class="w-full bg-slate-50 border border-slate-100 rounded-2xl pl-11 pr-12 py-4 text-slate-800 font-bold focus:ring-2 focus:ring-primary-500/20 focus:border-primary-500 outline-none transition-all placeholder:text-slate-400/80">
                                <button type="button" @click="show = !show" class="absolute inset-y-0 right-0 pr-4 flex items-center text-slate-400 hover:text-slate-600">
                                    <i class="fa-solid" :class="show ? 'fa-eye-slash' : 'fa-eye'"></i>
                                </button>
                            </div>
                        </div>

                        <!-- Input Confirm Password -->
                        <div class="space-y-2">
                            <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest ml-1">Konfirmasi Kata Sandi</label>
                            <div class="relative group" x-data="{ show: false }">
                                <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-slate-400 group-focus-within:text-primary-600 transition-colors">
                                    <i class="fa-solid fa-shield text-sm"></i>
                                </div>
                                <input :type="show ? 'text' : 'password'" name="password_confirmation" id="password_confirmation" required placeholder="••••••••" 
                                       class="w-full bg-slate-50 border border-slate-100 rounded-2xl pl-11 pr-12 py-4 text-slate-800 font-bold focus:ring-2 focus:ring-primary-500/20 focus:border-primary-500 outline-none transition-all placeholder:text-slate-400/80">
                                <button type="button" @click="show = !show" class="absolute inset-y-0 right-0 pr-4 flex items-center text-slate-400 hover:text-slate-600">
                                    <i class="fa-solid" :class="show ? 'fa-eye-slash' : 'fa-eye'"></i>
                                </button>
                            </div>
                        </div>

                        <!-- Action Submit Button -->
                        <button type="submit" class="w-full bg-primary-600 hover:bg-primary-700 text-white py-4 md:py-4.5 rounded-2xl shadow-xl shadow-primary-600/30 transition-all transform hover:-translate-y-1 active:translate-y-0 text-sm md:text-base font-extrabold uppercase tracking-wider flex items-center justify-center gap-2.5">
                            Langkah Selanjutnya <i class="fa-solid fa-arrow-right text-base animate-pulse"></i>
                        </button>
                    </form>

                    <!-- Redirection -->
                    <p class="text-center text-xs text-slate-500 font-semibold pt-4">
                        Sudah terdaftar sebagai pengelola? 
                        <a href="{{ route('login') }}" class="text-primary-600 font-extrabold hover:underline">Masuk di sini</a>
                    </p>
                </div>
            </div>
            
            <!-- Right Side: Visual Teaser (Col span 5, Hidden on mobile) -->
            <div class="hidden lg:col-span-5 bg-gradient-to-tr from-slate-950 via-slate-900 to-primary-950 p-12 lg:flex flex-col justify-between text-white relative overflow-hidden">
                <!-- Glowing Blurred Vector blobs -->
                <div class="absolute top-0 left-0 w-72 h-72 bg-primary-600/10 rounded-full blur-3xl -ml-20 -mt-20"></div>
                <div class="absolute bottom-0 right-0 w-72 h-72 bg-secondary-500/10 rounded-full blur-3xl -mr-20 -mb-20"></div>
                
                <div class="relative z-10 space-y-10 my-auto">
                    <!-- Welcoming Banner -->
                    <div class="space-y-4">
                        <h2 class="text-3xl font-black leading-tight tracking-tight">Kembangkan Bisnis Wisata Anda Bersama Tabibito</h2>
                        <p class="text-slate-400 text-sm leading-relaxed font-semibold">Bawa tempat wisata Anda menjangkau jutaan pelancong domestik dan mancanegara dengan digitalisasi tiket modern kami.</p>
                    </div>

                    <!-- Bullet Info Blocks -->
                    <div class="space-y-5">
                        <div class="flex items-center gap-4">
                            <div class="w-10 h-10 rounded-xl bg-white/10 flex items-center justify-center text-primary-400 shrink-0">
                                <i class="fa-solid fa-chart-line"></i>
                            </div>
                            <div>
                                <h4 class="text-xs font-black uppercase tracking-wider">Performa Penjualan Live</h4>
                                <p class="text-[11px] text-slate-400 font-semibold leading-normal">Pantau analitik, sisa kuota, dan total pendapatan secara instan di dashboard.</p>
                            </div>
                        </div>

                        <div class="flex items-center gap-4">
                            <div class="w-10 h-10 rounded-xl bg-white/10 flex items-center justify-center text-emerald-400 shrink-0">
                                <i class="fa-solid fa-cash-register"></i>
                            </div>
                            <div>
                                <h4 class="text-xs font-black uppercase tracking-wider">Pencairan Dana Fleksibel</h4>
                                <p class="text-[11px] text-slate-400 font-semibold leading-normal">Tarik pendapatan Anda dengan pengajuan pencairan dana yang mudah dan transparan.</p>
                            </div>
                        </div>

                        <div class="flex items-center gap-4">
                            <div class="w-10 h-10 rounded-xl bg-white/10 flex items-center justify-center text-amber-400 shrink-0">
                                <i class="fa-solid fa-mobile-screen-button"></i>
                            </div>
                            <div>
                                <h4 class="text-xs font-black uppercase tracking-wider">Aplikasi QR Scanner</h4>
                                <p class="text-[11px] text-slate-400 font-semibold leading-normal">Verifikasi boarding pass wisatawan dengan scanner web internal dalam hitungan detik.</p>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Footer Info -->
                <p class="text-center text-[10px] text-slate-500 font-semibold relative z-10 pt-4 border-t border-white/5">
                    Tabibito Jawa Tengah © 2026. Seluruh Transaksi Dilindungi.
                </p>
            </div>
            
        </div>
    </div>
</div>
@endsection