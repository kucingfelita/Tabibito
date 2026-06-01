@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto px-4 md:px-6">
    <!-- Header Page -->
    <div class="mb-8 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <h1 class="text-3xl font-black text-slate-900 tracking-tight">Manajemen Destinasi Wisata</h1>
            <p class="text-xs text-slate-400 font-bold uppercase tracking-wider mt-1">Kelola dan perbarui data tempat wisata yang Anda daftarkan</p>
        </div>
    </div>

    @include('owner.partials.nav')

    <!-- Main Content Grid -->
    <div class="mt-8 space-y-10">
        @if($destinations->isEmpty())
            <!-- Create Destination Card -->
            <div class="bg-white rounded-[2.5rem] border border-slate-100 shadow-xl shadow-slate-200/40 p-8 md:p-12 relative overflow-hidden">
                <div class="absolute top-0 right-0 w-32 h-32 bg-primary-50 rounded-full -mr-16 -mt-16 opacity-40"></div>
                
                <h2 class="text-2xl font-black text-slate-900 tracking-tight mb-8 flex items-center gap-3">
                    <div class="w-10 h-10 rounded-xl bg-primary-50 flex items-center justify-center text-primary-600">
                        <i class="fa-solid fa-map-location-dot text-base"></i>
                    </div>
                    Formulir Registrasi Tempat Wisata Baru
                </h2>

                <form method="POST" action="{{ route('owner.destinations.store') }}" enctype="multipart/form-data" class="space-y-6" id="add-destination-form">
                    @csrf
                    
                    <div class="grid md:grid-cols-2 gap-8">
                        <!-- Column Left -->
                        <div class="space-y-5">
                            <!-- Nama Wisata -->
                            <div class="space-y-2">
                                <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest ml-1">Nama Tempat Wisata</label>
                                <div class="relative group">
                                    <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-slate-400 group-focus-within:text-primary-600 transition-colors">
                                        <i class="fa-solid fa-mountain-sun text-sm"></i>
                                    </div>
                                    <input type="text" name="name" required placeholder="Contoh: Kawah Sikidang Dieng" value="{{ old('name') }}"
                                           class="w-full bg-slate-50 border border-slate-100 rounded-2xl pl-11 pr-4 py-4 text-slate-800 font-bold focus:ring-2 focus:ring-primary-500/20 focus:border-primary-500 outline-none transition-all placeholder:text-slate-400/80">
                                </div>
                            </div>

                            <!-- Kota / Kabupaten -->
                            <div class="space-y-2">
                                <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest ml-1">Kota / Kabupaten (Jawa Tengah)</label>
                                <div class="relative group">
                                    <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-slate-400 group-focus-within:text-primary-600 transition-colors z-10">
                                        <i class="fa-solid fa-city text-sm"></i>
                                    </div>
                                    <select name="city" required 
                                            class="w-full bg-slate-50 border border-slate-100 rounded-2xl pl-11 pr-4 py-4 text-slate-800 font-bold focus:ring-2 focus:ring-primary-500/20 focus:border-primary-500 outline-none transition-all appearance-none">
                                        <option value="" class="font-bold text-slate-400">Pilih Kota atau Kabupaten</option>
                                        @foreach($cities as $city)
                                            <option value="{{ $city }}" @selected(old('city') === $city) class="font-bold text-slate-800">{{ $city }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <!-- Alamat -->
                            <div class="space-y-2">
                                <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest ml-1">Alamat Lokasi Lengkap</label>
                                <div class="relative group">
                                    <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-slate-400 group-focus-within:text-primary-600 transition-colors">
                                        <i class="fa-solid fa-location-dot text-sm"></i>
                                    </div>
                                    <input type="text" name="address" required placeholder="Jalan Dieng Km 23, Kecamatan Batur" value="{{ old('address') }}"
                                           class="w-full bg-slate-50 border border-slate-100 rounded-2xl pl-11 pr-4 py-4 text-slate-800 font-bold focus:ring-2 focus:ring-primary-500/20 focus:border-primary-500 outline-none transition-all placeholder:text-slate-400/80">
                                </div>
                            </div>

                             <!-- Jam Operasional Grid -->
                             <div class="grid grid-cols-2 gap-4">
                                 <div class="space-y-2">
                                     <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest ml-1">Jam Buka</label>
                                     <div class="relative group">
                                         <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-slate-400 group-focus-within:text-primary-600 transition-colors">
                                             <i class="fa-solid fa-clock text-sm"></i>
                                         </div>
                                         <input type="time" name="open_time" required value="{{ old('open_time') }}"
                                                class="w-full bg-slate-50 border border-slate-100 rounded-2xl pl-11 pr-4 py-4 text-slate-800 font-bold focus:ring-2 focus:ring-primary-500/20 focus:border-primary-500 outline-none transition-all">
                                     </div>
                                 </div>
 
                                 <div class="space-y-2">
                                     <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest ml-1">Jam Tutup</label>
                                     <div class="relative group">
                                         <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-slate-400 group-focus-within:text-primary-600 transition-colors">
                                             <i class="fa-solid fa-circle-xmark text-sm"></i>
                                         </div>
                                         <input type="time" name="close_time" required value="{{ old('close_time') }}"
                                                class="w-full bg-slate-50 border border-slate-100 rounded-2xl pl-11 pr-4 py-4 text-slate-800 font-bold focus:ring-2 focus:ring-primary-500/20 focus:border-primary-500 outline-none transition-all">
                                     </div>
                                 </div>
                             </div>

                             <!-- Deskripsi -->
                             <div class="space-y-2 pt-2">
                                 <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest ml-1">Deskripsi & Fasilitas Wisata</label>
                                 <textarea name="description" rows="5" required placeholder="Jelaskan keunikan tempat wisata, keindahan alam, rute perjalanan, dan fasilitas penunjang yang tersedia bagi pengunjung..."
                                           class="w-full bg-slate-50 border border-slate-100 rounded-2xl px-6 py-4 text-slate-800 font-bold focus:ring-2 focus:ring-primary-500/20 focus:border-primary-500 outline-none transition-all placeholder:text-slate-400/80 resize-none">{{ old('description') }}</textarea>
                             </div>
 
                             <!-- Link Google Map -->
                             <div class="space-y-2">
                                 <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest ml-1">Link Google Maps</label>
                                 <div class="relative group">
                                     <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-slate-400 group-focus-within:text-primary-600 transition-colors">
                                         <i class="fa-solid fa-map-pin text-sm"></i>
                                     </div>
                                     <input type="text" name="map_link" required placeholder="https://maps.google.com/?q=..." value="{{ old('map_link') }}"
                                            class="w-full bg-slate-50 border border-slate-100 rounded-2xl pl-11 pr-4 py-4 text-slate-800 font-bold focus:ring-2 focus:ring-primary-500/20 focus:border-primary-500 outline-none transition-all placeholder:text-slate-400/80">
                                 </div>
                             </div>
                         </div>
 
                         <!-- Column Right -->
                         <div class="space-y-5">
                             <!-- Foto Cover -->
                             <div class="space-y-2">
                                 <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest ml-1">Foto Cover <span class="text-rose-500">*</span></label>
                                 <div class="relative flex flex-col items-center justify-center gap-2 bg-slate-50 border-2 border-dashed border-slate-200 rounded-2xl p-5 group hover:border-primary-400 hover:bg-primary-50/30 transition-all cursor-pointer">
                                     <div class="w-10 h-10 rounded-xl bg-primary-100 flex items-center justify-center text-primary-600 group-hover:scale-110 transition-transform">
                                         <i class="fa-solid fa-image text-lg"></i>
                                     </div>
                                     <div class="text-center">
                                         <p class="text-xs font-extrabold text-slate-600">1 Foto Utama (Cover)</p>
                                         <p class="text-[10px] text-slate-400 font-semibold">JPG/PNG/WEBP · Maks. 5MB</p>
                                     </div>
                                     <input type="file" name="cover_image" accept="image/*" required
                                            class="absolute inset-0 w-full h-full opacity-0 cursor-pointer"
                                            onchange="previewDestCover(this, 'add-cover-preview', 'add-cover-img', 'add-cover-name')">
                                     <div id="add-cover-preview" class="hidden w-full">
                                         <img id="add-cover-img" src="" alt="Cover" class="w-full h-24 object-cover rounded-xl border border-slate-200">
                                         <p id="add-cover-name" class="text-[10px] text-center text-slate-500 font-bold mt-1 truncate"></p>
                                     </div>
                                 </div>
                             </div>
 
                             <!-- Foto Slide -->
                             <div class="space-y-2">
                                 <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest ml-1">Foto Slide Galeri (Maks. 7)</label>
                                 <div class="relative flex flex-col items-center justify-center gap-2 bg-slate-50 border-2 border-dashed border-slate-200 rounded-2xl p-5 group hover:border-primary-400 hover:bg-primary-50/30 transition-all cursor-pointer">
                                     <div class="w-10 h-10 rounded-xl bg-emerald-100 flex items-center justify-center text-emerald-600 group-hover:scale-110 transition-transform">
                                         <i class="fa-solid fa-images text-lg"></i>
                                     </div>
                                     <div class="text-center">
                                         <p class="text-xs font-extrabold text-slate-600">Foto Slide / Galeri</p>
                                         <p class="text-[10px] text-slate-400 font-semibold">Maks. 7 foto · 5MB/foto</p>
                                     </div>
                                     <input type="file" name="slide_images[]" accept="image/*" multiple
                                            class="absolute inset-0 w-full h-full opacity-0 cursor-pointer"
                                            onchange="previewDestSlide(this, 'add-slide-preview', 'add-slide-grid', 'add-slide-count')">
                                     <div id="add-slide-preview" class="hidden w-full">
                                         <div id="add-slide-grid" class="grid grid-cols-3 gap-1.5"></div>
                                         <p id="add-slide-count" class="text-[10px] text-center text-slate-500 font-bold mt-1.5"></p>
                                     </div>
                                 </div>
                             </div>
                        </div>
                    </div>

                    <!-- Tags Checkbox Selection -->
                    <div class="pt-6 border-t border-slate-100 space-y-4">
                        <div>
                            <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest ml-1 mb-1">Pilih Tag Kategori</label>
                            <p class="text-[11px] text-slate-400 font-semibold ml-1">Kategori tag akan mempermudah wisatawan menemukan tempat wisata Anda melalui fitur pencarian cepat beranda.</p>
                        </div>
                        <div class="grid gap-3 sm:grid-cols-2 lg:grid-cols-3">
                            @foreach($tags as $tag)
                                <label class="relative flex items-center gap-3 rounded-2xl border border-slate-100 px-5 py-4 cursor-pointer hover:bg-slate-50 hover:border-primary-300 transition-all select-none">
                                    <input type="checkbox" name="tag_ids[]" value="{{ $tag->id }}" class="w-4 h-4 rounded text-primary-600 border-slate-200 focus:ring-primary-500/20" @checked(in_array($tag->id, old('tag_ids', [])))>
                                    <span class="text-xs font-extrabold text-slate-700 uppercase tracking-wide">{{ $tag->name }}</span>
                                </label>
                            @endforeach
                        </div>
                    </div>

                    <!-- Custom Tag Baru -->
                    <div class="space-y-2 pt-2">
                        <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest ml-1">Buat Kategori Tag Baru (Opsional)</label>
                        <div class="relative group">
                            <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-slate-400 group-focus-within:text-primary-600 transition-colors">
                                <i class="fa-solid fa-tags text-sm"></i>
                            </div>
                            <input type="text" name="custom_tags" placeholder="Pisahkan dengan koma, misal: alam, petualangan, outbound, sejuk" value="{{ old('custom_tags') }}"
                                   class="w-full bg-slate-50 border border-slate-100 rounded-2xl pl-11 pr-4 py-4 text-slate-800 font-bold focus:ring-2 focus:ring-primary-500/20 focus:border-primary-500 outline-none transition-all placeholder:text-slate-400/80">
                        </div>
                    </div>

                    <!-- Submit Button -->
                    <div class="pt-6 border-t border-slate-100 flex justify-end">
                        <button type="submit" class="w-full sm:w-auto bg-primary-600 hover:bg-primary-700 text-white font-extrabold px-12 py-4 md:py-4.5 rounded-2xl shadow-xl shadow-primary-600/20 transition-all transform hover:-translate-y-1 active:translate-y-0 text-sm md:text-base uppercase tracking-wider flex items-center justify-center gap-2">
                            Tambah Destinasi Saya <i class="fa-solid fa-circle-plus text-base ml-1"></i>
                        </button>
                    </div>
                </form>
            </div>
        @else
            <!-- Info Card: Maximum limit reached -->
            <div class="bg-amber-50 border border-amber-100 rounded-3xl p-6 flex items-start gap-4 shadow-sm">
                <div class="w-11 h-11 rounded-xl bg-amber-500 text-white flex items-center justify-center shrink-0">
                    <i class="fa-solid fa-triangle-exclamation text-base"></i>
                </div>
                <div>
                    <h4 class="font-bold text-amber-900 text-sm mb-0.5">Batas Kuota Destinasi Terpenuhi</h4>
                    <p class="text-xs text-amber-700/80 leading-relaxed font-semibold">Anda terdaftar sebagai Mitra Pengelola Eksklusif dan saat ini sudah memiliki satu tempat wisata aktif. Untuk menambahkan atau mendaftarkan tempat wisata baru lainnya, silakan hapus atau nonaktifkan terlebih dahulu destinasi yang telah terdaftar di bawah ini.</p>
                </div>
            </div>
        @endif

        <!-- List Registered Destinations -->
        <div class="space-y-6">
            @foreach($destinations as $destination)
                <div class="bg-white rounded-[2.5rem] border border-slate-100 shadow-xl shadow-slate-200/40 p-8 md:p-10 relative overflow-hidden">
                    <div class="absolute top-0 right-0 w-32 h-32 bg-slate-50 rounded-full -mr-16 -mt-16 opacity-60"></div>
                    
                    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-8 pb-4 border-b border-slate-50 relative z-10">
                        <div>
                            <span class="px-2.5 py-0.5 rounded-full text-[9px] font-black uppercase tracking-wider bg-primary-50 text-primary-700">Mitra Wisata Terdaftar</span>
                            <h2 class="text-xl md:text-2xl font-black text-slate-900 tracking-tight mt-2">{{ $destination->name }}</h2>
                            <p class="text-xs text-slate-400 font-semibold mt-0.5 flex items-center gap-1.5"><i class="fa-solid fa-location-dot text-rose-500"></i>{{ $destination->city }}, Jawa Tengah</p>
                        </div>
                        
                        <div class="flex flex-col sm:flex-row items-stretch sm:items-center gap-2 shrink-0">
                            <!-- Status Verifikasi -->
                            <div class="flex items-center gap-3 px-4 py-2 rounded-xl border
                                @if($destination->status === 'active') bg-emerald-50 border-emerald-100
                                @elseif($destination->status === 'rejected') bg-rose-50 border-rose-100
                                @elseif($destination->status === 'maintenance') bg-slate-100 border-slate-200
                                @else bg-amber-50 border-amber-100 @endif">
                                @if($destination->status === 'active')
                                    <span class="w-2.5 h-2.5 rounded-full bg-emerald-500 shrink-0"></span>
                                    <span class="text-[10px] font-black text-emerald-700 uppercase tracking-widest">Disetujui Admin</span>
                                @elseif($destination->status === 'rejected')
                                    <span class="w-2.5 h-2.5 rounded-full bg-rose-500 shrink-0"></span>
                                    <span class="text-[10px] font-black text-rose-700 uppercase tracking-widest">Ditolak Admin</span>
                                @elseif($destination->status === 'maintenance')
                                    <span class="w-2.5 h-2.5 rounded-full bg-slate-500 shrink-0"></span>
                                    <span class="text-[10px] font-black text-slate-700 uppercase tracking-widest">Mode Perawatan</span>
                                @else
                                    <span class="w-2.5 h-2.5 rounded-full bg-amber-500 animate-pulse shrink-0"></span>
                                    <span class="text-[10px] font-black text-amber-700 uppercase tracking-widest">Menunggu Review</span>
                                @endif
                            </div>
                            @if(in_array($destination->status, ['active', 'maintenance'], true))
                                <form method="POST" action="{{ route('owner.destinations.maintenance', $destination) }}"
                                      onsubmit="return confirm(@js($destination->status === 'active' ? 'Matikan pemesanan sementara? Destinasi tidak tampil untuk traveler.' : 'Buka kembali destinasi untuk pemesanan?'));">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit"
                                            class="px-4 py-2 rounded-xl text-[10px] font-extrabold uppercase tracking-wider border transition-all
                                            {{ $destination->status === 'maintenance' ? 'bg-emerald-600 text-white border-emerald-600 hover:bg-emerald-700' : 'bg-white text-slate-600 border-slate-200 hover:bg-slate-50' }}">
                                        @if($destination->status === 'maintenance')
                                            <i class="fa-solid fa-play mr-1"></i> Buka Pemesanan
                                        @else
                                            <i class="fa-solid fa-pause mr-1"></i> Mode Perawatan
                                        @endif
                                    </button>
                                </form>
                            @endif
                        </div>
                    </div>

                    @if($destination->status === 'maintenance')
                        <div class="mb-6 rounded-2xl bg-slate-50 border border-slate-200 px-5 py-4 text-sm text-slate-700 relative z-10">
                            <p class="font-extrabold flex items-center gap-2"><i class="fa-solid fa-screwdriver-wrench text-slate-500"></i> Destinasi sedang ditutup sementara</p>
                            <p class="text-xs text-slate-500 font-semibold mt-1">Traveler tidak bisa memesan tiket sampai Anda menekan <strong>Buka Pemesanan</strong>.</p>
                        </div>
                    @endif

                    @if($destination->status === 'rejected')
                        <div class="mb-6 rounded-2xl bg-rose-50 border border-rose-100 px-5 py-4 text-sm text-rose-800 relative z-10">
                            <p class="font-extrabold flex items-center gap-2">
                                <i class="fa-solid fa-circle-xmark"></i> Pengajuan ditolak administrator
                            </p>
                            @if($destination->rejection_reason)
                                <div class="mt-3 p-3 rounded-xl bg-white/80 border border-rose-100">
                                    <p class="text-[9px] font-black text-rose-500 uppercase tracking-widest mb-1">Alasan dari admin</p>
                                    <p class="text-sm font-semibold text-rose-900">{{ $destination->rejection_reason }}</p>
                                </div>
                            @endif
                            <p class="text-xs text-rose-700/90 font-semibold mt-3">Perbaiki data di bawah, lalu tekan <strong>Simpan dan Ajukan Ulang</strong>. Pemberitahuan juga dikirim ke email Anda.</p>
                        </div>
                    @endif

                    <!-- Update Form -->
                    <form method="POST" action="{{ route('owner.destinations.update', $destination) }}" enctype="multipart/form-data" class="space-y-6 relative z-10" id="update-destination-form">
                        @csrf
                        @method('PUT')
                        
                        <div class="grid md:grid-cols-2 gap-8">
                            <!-- Left Col -->
                            <div class="space-y-5">
                                <!-- Nama -->
                                <div class="space-y-2">
                                    <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest ml-1">Nama Tempat Wisata</label>
                                    <div class="relative group">
                                        <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-slate-400 group-focus-within:text-primary-600 transition-colors">
                                            <i class="fa-solid fa-mountain-sun text-sm"></i>
                                        </div>
                                        <input type="text" name="name" required value="{{ $destination->name }}"
                                               class="w-full bg-slate-50 border border-slate-100 rounded-2xl pl-11 pr-4 py-4 text-slate-800 font-bold focus:ring-2 focus:ring-primary-500/20 focus:border-primary-500 outline-none transition-all">
                                    </div>
                                </div>

                                <!-- Kota / Kabupaten -->
                                <div class="space-y-2">
                                    <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest ml-1">Kota / Kabupaten (Jawa Tengah)</label>
                                    <div class="relative group">
                                        <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-slate-400 group-focus-within:text-primary-600 transition-colors z-10">
                                            <i class="fa-solid fa-city text-sm"></i>
                                        </div>
                                        <select name="city" required 
                                                class="w-full bg-slate-50 border border-slate-100 rounded-2xl pl-11 pr-4 py-4 text-slate-800 font-bold focus:ring-2 focus:ring-primary-500/20 focus:border-primary-500 outline-none transition-all appearance-none">
                                            @foreach($cities as $city)
                                                <option value="{{ $city }}" @selected($destination->city === $city) class="font-bold text-slate-800">{{ $city }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <!-- Alamat -->
                                <div class="space-y-2">
                                    <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest ml-1">Alamat Lokasi Lengkap</label>
                                    <div class="relative group">
                                        <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-slate-400 group-focus-within:text-primary-600 transition-colors">
                                            <i class="fa-solid fa-location-dot text-sm"></i>
                                        </div>
                                        <input type="text" name="address" required value="{{ $destination->address }}"
                                               class="w-full bg-slate-50 border border-slate-100 rounded-2xl pl-11 pr-4 py-4 text-slate-800 font-bold focus:ring-2 focus:ring-primary-500/20 focus:border-primary-500 outline-none transition-all">
                                    </div>
                                </div>

                                <!-- Jam Operasional Grid -->
                                <div class="grid grid-cols-2 gap-4">
                                    <div class="space-y-2">
                                        <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest ml-1">Jam Buka</label>
                                        <div class="relative group">
                                            <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-slate-400 group-focus-within:text-primary-600 transition-colors">
                                                <i class="fa-solid fa-clock text-sm"></i>
                                            </div>
                                            <input type="time" name="open_time" required value="{{ \Illuminate\Support\Str::of($destination->open_time)->substr(0, 5) }}"
                                                   class="w-full bg-slate-50 border border-slate-100 rounded-2xl pl-11 pr-4 py-4 text-slate-800 font-bold focus:ring-2 focus:ring-primary-500/20 focus:border-primary-500 outline-none transition-all">
                                        </div>
                                    </div>

                                    <div class="space-y-2">
                                        <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest ml-1">Jam Tutup</label>
                                        <div class="relative group">
                                            <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-slate-400 group-focus-within:text-primary-600 transition-colors">
                                                <i class="fa-solid fa-circle-xmark text-sm"></i>
                                            </div>
                                            <input type="time" name="close_time" required value="{{ \Illuminate\Support\Str::of($destination->close_time)->substr(0, 5) }}"
                                                   class="w-full bg-slate-50 border border-slate-100 rounded-2xl pl-11 pr-4 py-4 text-slate-800 font-bold focus:ring-2 focus:ring-primary-500/20 focus:border-primary-500 outline-none transition-all">
                                        </div>
                                    </div>
                                </div>

                                <!-- Deskripsi -->
                                <div class="space-y-2 pt-2">
                                    <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest ml-1">Deskripsi & Fasilitas Wisata</label>
                                    <textarea name="description" rows="5" required class="w-full bg-slate-50 border border-slate-100 rounded-2xl px-6 py-4 text-slate-800 font-bold focus:ring-2 focus:ring-primary-500/20 focus:border-primary-500 outline-none transition-all placeholder:text-slate-400/80 resize-none">{{ $destination->description }}</textarea>
                                </div>

                                <!-- Link Map -->
                                <div class="space-y-2">
                                    <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest ml-1">Link Google Maps</label>
                                    <div class="relative group">
                                        <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-slate-400 group-focus-within:text-primary-600 transition-colors">
                                            <i class="fa-solid fa-map-pin text-sm"></i>
                                        </div>
                                        <input type="text" name="map_link" required value="{{ $destination->map_link }}"
                                               class="w-full bg-slate-50 border border-slate-100 rounded-2xl pl-11 pr-4 py-4 text-slate-800 font-bold focus:ring-2 focus:ring-primary-500/20 focus:border-primary-500 outline-none transition-all">
                                    </div>
                                </div>
                            </div>

                            <!-- Right Col -->
                            <div class="space-y-5">
                                <!-- Foto Cover -->
                                <div class="space-y-2">
                                    <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest ml-1">Ganti Foto Cover</label>
                                    @if($destination->coverImage)
                                        <div class="mb-2">
                                            <img src="{{ asset('storage/' . $destination->coverImage->image_path) }}" alt="Cover saat ini" class="w-full h-24 object-cover rounded-xl border border-slate-200">
                                            <p class="text-[10px] text-slate-400 font-semibold mt-1">Cover saat ini &mdash; upload baru untuk mengganti</p>
                                        </div>
                                    @endif
                                    <div class="relative flex flex-col items-center justify-center gap-2 bg-slate-50 border-2 border-dashed border-slate-200 rounded-2xl p-5 group hover:border-primary-400 hover:bg-primary-50/30 transition-all cursor-pointer">
                                        <div class="w-10 h-10 rounded-xl bg-primary-100 flex items-center justify-center text-primary-600 group-hover:scale-110 transition-transform">
                                            <i class="fa-solid fa-image text-lg"></i>
                                        </div>
                                        <div class="text-center">
                                            <p class="text-xs font-extrabold text-slate-600">Upload Foto Cover Baru</p>
                                            <p class="text-[10px] text-slate-400 font-semibold">JPG/PNG/WEBP · Maks. 5MB</p>
                                        </div>
                                        <input type="file" name="cover_image" accept="image/*"
                                               class="absolute inset-0 w-full h-full opacity-0 cursor-pointer"
                                               onchange="previewDestCover(this, 'upd-cover-preview', 'upd-cover-img', 'upd-cover-name')">
                                        <div id="upd-cover-preview" class="hidden w-full">
                                            <img id="upd-cover-img" src="" alt="Cover Baru" class="w-full h-24 object-cover rounded-xl border border-slate-200">
                                            <p id="upd-cover-name" class="text-[10px] text-center text-slate-500 font-bold mt-1 truncate"></p>
                                        </div>
                                    </div>
                                </div>

                                <!-- Foto Slide -->
                                <div class="space-y-2">
                                    <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest ml-1">Tambah Foto Slide Baru (Maks. 7)</label>
                                    @php $slideImgs = $destination->slideImages ?? collect(); @endphp
                                    @if($slideImgs->count())
                                        <div class="grid grid-cols-4 gap-1.5 mb-2">
                                            @foreach($slideImgs as $si)
                                                <img src="{{ asset('storage/' . $si->image_path) }}" alt="Slide" class="w-full h-14 object-cover rounded-lg border border-slate-200">
                                            @endforeach
                                        </div>
                                        <p class="text-[10px] text-slate-400 font-semibold">{{ $slideImgs->count() }} foto slide saat ini &mdash; upload baru untuk menambah / mengganti</p>
                                    @endif
                                    <div class="relative flex flex-col items-center justify-center gap-2 bg-slate-50 border-2 border-dashed border-slate-200 rounded-2xl p-5 group hover:border-primary-400 hover:bg-primary-50/30 transition-all cursor-pointer">
                                        <div class="w-10 h-10 rounded-xl bg-emerald-100 flex items-center justify-center text-emerald-600 group-hover:scale-110 transition-transform">
                                            <i class="fa-solid fa-images text-lg"></i>
                                        </div>
                                        <div class="text-center">
                                            <p class="text-xs font-extrabold text-slate-600">Upload Foto Slide Baru</p>
                                            <p class="text-[10px] text-slate-400 font-semibold">Maks. 7 foto · 5MB/foto</p>
                                        </div>
                                        <input type="file" name="slide_images[]" accept="image/*" multiple
                                               class="absolute inset-0 w-full h-full opacity-0 cursor-pointer"
                                               onchange="previewDestSlide(this, 'upd-slide-preview', 'upd-slide-grid', 'upd-slide-count')">
                                        <div id="upd-slide-preview" class="hidden w-full">
                                            <div id="upd-slide-grid" class="grid grid-cols-3 gap-1.5"></div>
                                            <p id="upd-slide-count" class="text-[10px] text-center text-slate-500 font-bold mt-1.5"></p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Tags Selector -->
                        <div class="pt-6 border-t border-slate-100 space-y-4">
                            <div>
                                <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest ml-1">Pilih Tag Kategori</label>
                            </div>
                            <div class="grid gap-3 sm:grid-cols-2 lg:grid-cols-3">
                                @foreach($tags as $tag)
                                    <label class="relative flex items-center gap-3 rounded-2xl border border-slate-100 px-5 py-4 cursor-pointer hover:bg-slate-50 hover:border-primary-300 transition-all select-none">
                                        <input type="checkbox" name="tag_ids[]" value="{{ $tag->id }}" class="w-4 h-4 rounded text-primary-600 border-slate-200 focus:ring-primary-500/20" @checked(in_array($tag->id, old('tag_ids', $destination->tags->pluck('id')->toArray())))>
                                        <span class="text-xs font-extrabold text-slate-700 uppercase tracking-wide">{{ $tag->name }}</span>
                                    </label>
                                @endforeach
                            </div>
                        </div>

                        <!-- Input Tag Baru -->
                        <div class="space-y-2 pt-2">
                            <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest ml-1">Buat Kategori Tag Baru (Opsional)</label>
                            <div class="relative group">
                                <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-slate-400 group-focus-within:text-primary-600 transition-colors">
                                    <i class="fa-solid fa-tags text-sm"></i>
                                </div>
                                <input type="text" name="custom_tags" placeholder="Pisahkan dengan koma, misal: kuliner, ramah anak, edukasi" value="{{ old('custom_tags') }}"
                                       class="w-full bg-slate-50 border border-slate-100 rounded-2xl pl-11 pr-4 py-4 text-slate-800 font-bold focus:ring-2 focus:ring-primary-500/20 focus:border-primary-500 outline-none transition-all placeholder:text-slate-400/80">
                            </div>
                        </div>

                        <!-- Aksi Tombol -->
                        <div class="pt-6 border-t border-slate-100 flex flex-col sm:flex-row items-center justify-end gap-4">
                            <button type="submit" class="w-full sm:w-auto bg-primary-600 hover:bg-primary-700 text-white font-extrabold px-10 py-4 rounded-2xl shadow-lg shadow-primary-600/20 transition-all transform hover:-translate-y-1 active:translate-y-0 text-xs uppercase tracking-wider flex items-center justify-center gap-2">
                                @if($destination->status === 'rejected')
                                    Simpan dan Ajukan Ulang
                                @else
                                    Simpan Perubahan
                                @endif
                                <i class="fa-solid fa-cloud-arrow-up text-sm ml-1"></i>
                            </button>
                        </div>
                    </form>

                    <!-- Delete Button Form outside main form -->
                    <div class="mt-4 pt-4 border-t border-dashed border-slate-100 flex justify-between items-center relative z-10">
                        <p class="text-[10px] text-slate-400 font-bold uppercase tracking-wider"><i class="fa-solid fa-circle-exclamation text-rose-500 mr-1"></i>Tindakan berbahaya tidak dapat dibatalkan</p>
                        
                        <form method="POST" action="{{ route('owner.destinations.destroy', $destination) }}" onsubmit="return confirm('Apakah Anda yakin ingin menghapus destinasi wisata ini secara permanen?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="bg-rose-50 hover:bg-rose-100 text-rose-600 font-extrabold px-6 py-3 rounded-xl transition-all text-xs uppercase tracking-wider flex items-center gap-1.5 active:scale-95">
                                <i class="fa-solid fa-trash-can text-sm"></i> Hapus Destinasi
                            </button>
                        </form>
                    </div>
                </div>
            @endforeach
        </div>

        <div class="mt-6 flex justify-center">{{ $destinations->links() }}</div>
    </div>
</div>
@endsection

@push('scripts')
<script>
function previewDestCover(input, previewId, imgId, nameId) {
    const preview = document.getElementById(previewId);
    const img = document.getElementById(imgId);
    const name = document.getElementById(nameId);
    if (input.files && input.files[0]) {
        const file = input.files[0];
        const reader = new FileReader();
        reader.onload = function(e) {
            img.src = e.target.result;
            name.textContent = file.name;
            preview.classList.remove('hidden');
        };
        reader.readAsDataURL(file);
    }
}

function previewDestSlide(input, previewId, gridId, countId) {
    const preview = document.getElementById(previewId);
    const grid = document.getElementById(gridId);
    const count = document.getElementById(countId);
    if (input.files && input.files.length > 0) {
        const maxFiles = 7;
        const selected = Math.min(input.files.length, maxFiles);
        grid.innerHTML = '';
        if (input.files.length > maxFiles) {
            alert('Maksimal 7 foto slide. Hanya 7 foto pertama yang digunakan.');
        }
        for (let i = 0; i < selected; i++) {
            const reader = new FileReader();
            const idx = i;
            reader.onload = function(e) {
                const d = document.createElement('div');
                d.className = 'relative';
                d.innerHTML = `<img src="${e.target.result}" class="w-full h-14 object-cover rounded-lg border border-slate-200">
                               <span class="absolute bottom-0.5 right-0.5 bg-black/50 text-white text-[8px] font-bold px-1 rounded">${idx+1}</span>`;
                grid.appendChild(d);
            };
            reader.readAsDataURL(input.files[idx]);
        }
        count.textContent = `${selected} foto slide dipilih`;
        preview.classList.remove('hidden');
    }
}
</script>
@endpush
