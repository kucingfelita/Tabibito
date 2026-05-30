@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto px-4 md:px-0 py-6">
    <!-- Card Container -->
    <div class="bg-white rounded-[2.5rem] border border-slate-100 shadow-xl shadow-slate-200/40 p-8 md:p-12 relative overflow-hidden">
        <!-- Background spark -->
        <div class="absolute top-0 right-0 w-36 h-36 bg-primary-50 rounded-full -mr-16 -mt-16 opacity-50"></div>
        
        <div class="relative z-10">
            <!-- Header Progress -->
            <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-10 pb-6 border-b border-slate-100">
                <div>
                    <span class="px-3 py-1 rounded-full bg-primary-50 text-primary-700 text-[10px] font-black uppercase tracking-wider">Langkah 2 dari 2</span>
                    <h1 class="text-2xl md:text-3xl font-black text-slate-900 tracking-tight mt-2">Detail Tempat Wisata</h1>
                    <p class="text-xs text-slate-400 font-bold uppercase tracking-wider mt-0.5">Lengkapi data destinasi wisata yang akan dikelola</p>
                </div>
                
                <!-- Status Badge -->
                <div class="flex items-center gap-3 bg-slate-50 border border-slate-100 px-5 py-3 rounded-2xl shrink-0">
                    <div class="w-2.5 h-2.5 rounded-full bg-primary-500 animate-ping"></div>
                    <span class="text-xs font-black text-slate-700 uppercase tracking-widest">Menunggu Pengajuan</span>
                </div>
            </div>

            <!-- Form -->
            <form action="{{ route('owner.register.step2.store') }}" method="POST" enctype="multipart/form-data" class="space-y-8">
                @csrf
                
                <div class="grid md:grid-cols-2 gap-8">
                    <!-- Column 1 -->
                    <div class="space-y-6">
                        <!-- Nama Tempat Wisata -->
                        <div class="space-y-2">
                            <label for="nama_tempat" class="block text-[10px] font-black text-slate-400 uppercase tracking-widest ml-1">Nama Tempat Wisata</label>
                            <div class="relative group">
                                <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-slate-400 group-focus-within:text-primary-600 transition-colors">
                                    <i class="fa-solid fa-umbrella-beach text-sm"></i>
                                </div>
                                <input type="text" name="nama_tempat" id="nama_tempat" required placeholder="Contoh: Candi Dieng / Wisata Alam Baturraden" value="{{ old('nama_tempat') }}"
                                       class="w-full bg-slate-50 border border-slate-100 rounded-2xl pl-11 pr-4 py-4 text-slate-800 font-bold focus:ring-2 focus:ring-primary-500/20 focus:border-primary-500 outline-none transition-all placeholder:text-slate-400/80">
                            </div>
                        </div>

                        <!-- Nama Pemilik -->
                        <div class="space-y-2">
                            <label for="nama_pemilik" class="block text-[10px] font-black text-slate-400 uppercase tracking-widest ml-1">Nama Pemilik / Direktur Utama</label>
                            <div class="relative group">
                                <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-slate-400 group-focus-within:text-primary-600 transition-colors">
                                    <i class="fa-solid fa-user-tie text-sm"></i>
                                </div>
                                <input type="text" name="nama_pemilik" id="nama_pemilik" required placeholder="Nama lengkap Anda sesuai KTP" value="{{ old('nama_pemilik') }}"
                                       class="w-full bg-slate-50 border border-slate-100 rounded-2xl pl-11 pr-4 py-4 text-slate-800 font-bold focus:ring-2 focus:ring-primary-500/20 focus:border-primary-500 outline-none transition-all placeholder:text-slate-400/80">
                            </div>
                        </div>

                        <!-- Kota / Kabupaten -->
                        <div class="space-y-2">
                            <label for="city" class="block text-[10px] font-black text-slate-400 uppercase tracking-widest ml-1">Kota / Kabupaten (Jawa Tengah)</label>
                            <div class="relative group">
                                <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-slate-400 group-focus-within:text-primary-600 transition-colors z-10">
                                    <i class="fa-solid fa-city text-sm"></i>
                                </div>
                                <select name="city" id="city" required 
                                        class="w-full bg-slate-50 border border-slate-100 rounded-2xl pl-11 pr-4 py-4 text-slate-800 font-bold focus:ring-2 focus:ring-primary-500/20 focus:border-primary-500 outline-none transition-all appearance-none relative">
                                    <option value="" class="font-bold text-slate-400">Pilih Kota atau Kabupaten</option>
                                    @foreach($cities as $city)
                                        <option value="{{ $city }}" @selected(old('city') === $city) class="font-bold text-slate-800">{{ $city }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <!-- Alamat / Domisili -->
                        <div class="space-y-2">
                            <label for="domisili" class="block text-[10px] font-black text-slate-400 uppercase tracking-widest ml-1">Alamat Lengkap</label>
                            <div class="relative group">
                                <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-slate-400 group-focus-within:text-primary-600 transition-colors">
                                    <i class="fa-solid fa-location-dot text-sm"></i>
                                </div>
                                <input type="text" name="domisili" id="domisili" required placeholder="Nama jalan, RT/RW, nomor, kecamatan" value="{{ old('domisili') }}"
                                       class="w-full bg-slate-50 border border-slate-100 rounded-2xl pl-11 pr-4 py-4 text-slate-800 font-bold focus:ring-2 focus:ring-primary-500/20 focus:border-primary-500 outline-none transition-all placeholder:text-slate-400/80">
                            </div>
                        </div>
                    </div>

                    <!-- Column 2 -->
                    <div class="space-y-6">
                        <!-- Jam Buka & Tutup Grid -->
                        <div class="grid grid-cols-2 gap-4">
                            <!-- Jam Buka -->
                            <div class="space-y-2">
                                <label for="open_time" class="block text-[10px] font-black text-slate-400 uppercase tracking-widest ml-1">Jam Buka</label>
                                <div class="relative group">
                                    <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-slate-400 group-focus-within:text-primary-600 transition-colors">
                                        <i class="fa-solid fa-clock-rotate-left text-sm"></i>
                                    </div>
                                    <input type="time" name="open_time" id="open_time" required value="{{ old('open_time') }}"
                                           class="w-full bg-slate-50 border border-slate-100 rounded-2xl pl-11 pr-4 py-4 text-slate-800 font-bold focus:ring-2 focus:ring-primary-500/20 focus:border-primary-500 outline-none transition-all">
                                </div>
                            </div>

                            <!-- Jam Tutup -->
                            <div class="space-y-2">
                                <label for="close_time" class="block text-[10px] font-black text-slate-400 uppercase tracking-widest ml-1">Jam Tutup</label>
                                <div class="relative group">
                                    <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-slate-400 group-focus-within:text-primary-600 transition-colors">
                                        <i class="fa-solid fa-clock text-sm"></i>
                                    </div>
                                    <input type="time" name="close_time" id="close_time" required value="{{ old('close_time') }}"
                                           class="w-full bg-slate-50 border border-slate-100 rounded-2xl pl-11 pr-4 py-4 text-slate-800 font-bold focus:ring-2 focus:ring-primary-500/20 focus:border-primary-500 outline-none transition-all">
                                </div>
                            </div>
                        </div>

                        <!-- Deskripsi Tempat -->
                        <div class="space-y-2">
                            <label for="description" class="block text-[10px] font-black text-slate-400 uppercase tracking-widest ml-1">Deskripsi Tempat Wisata</label>
                            <div class="relative group">
                                <textarea name="description" id="description" rows="5" required placeholder="Jelaskan daya tarik utama, fasilitas, rute jalan, dan info penting destinasi Anda..."
                                          class="w-full bg-slate-50 border border-slate-100 rounded-2xl px-6 py-4 text-slate-800 font-bold focus:ring-2 focus:ring-primary-500/20 focus:border-primary-500 outline-none transition-all placeholder:text-slate-400/80 resize-none">{{ old('description') }}</textarea>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Tag Wisata Section -->
                <div class="pt-4 border-t border-slate-100 space-y-4">
                    <div>
                        <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest ml-1 mb-1">Tag Kategori Wisata</label>
                        <p class="text-[11px] text-slate-400 font-semibold mb-4 ml-1">Centang lebih dari satu kategori tag yang paling sesuai dengan daya tarik tempat wisata Anda.</p>
                    </div>

                    <div class="grid gap-3 sm:grid-cols-2 md:grid-cols-3">
                        @foreach($tags as $tag)
                            <label class="relative flex items-center gap-3 rounded-2xl border border-slate-100 px-5 py-4 cursor-pointer hover:bg-slate-50 hover:border-primary-300 transition-all select-none">
                                <input type="checkbox" name="tag_ids[]" value="{{ $tag->id }}" class="w-4 h-4 rounded text-primary-600 border-slate-200 focus:ring-primary-500/20" {{ in_array($tag->id, old('tag_ids', [])) ? 'checked' : '' }}>
                                <span class="text-xs font-extrabold text-slate-700 uppercase tracking-wide">{{ $tag->name }}</span>
                            </label>
                        @endforeach
                    </div>
                </div>

                <!-- Tag Baru Tambahan -->
                <div class="space-y-2">
                    <label for="custom_tags" class="block text-[10px] font-black text-slate-400 uppercase tracking-widest ml-1">Tag Tambahan (Opsional)</label>
                    <div class="relative group">
                        <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-slate-400 group-focus-within:text-primary-600 transition-colors">
                            <i class="fa-solid fa-tags text-sm"></i>
                        </div>
                        <input type="text" name="custom_tags" id="custom_tags" placeholder="Pisahkan dengan tanda koma, misal: alam, keluarga, outbound, edukasi" value="{{ old('custom_tags') }}"
                               class="w-full bg-slate-50 border border-slate-100 rounded-2xl pl-11 pr-4 py-4 text-slate-800 font-bold focus:ring-2 focus:ring-primary-500/20 focus:border-primary-500 outline-none transition-all placeholder:text-slate-400/80">
                    </div>
                </div>

                <!-- Lokasi & Foto Section -->
                <div class="pt-4 border-t border-slate-100 space-y-6">
                    <div>
                        <h3 class="text-sm font-black text-slate-700 uppercase tracking-widest flex items-center gap-2">
                            <i class="fa-solid fa-images text-primary-600"></i> Foto &amp; Lokasi Destinasi
                        </h3>
                        <p class="text-[11px] text-slate-400 font-semibold mt-1 ml-0.5">Upload foto dan tambahkan link Google Maps agar wisatawan mudah menemukan tempat Anda.</p>
                    </div>

                    <!-- Link Google Maps -->
                    <div class="space-y-2">
                        <label for="map_link" class="block text-[10px] font-black text-slate-400 uppercase tracking-widest ml-1">Link Google Maps</label>
                        <div class="relative group">
                            <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-slate-400 group-focus-within:text-primary-600 transition-colors">
                                <i class="fa-solid fa-map-pin text-sm"></i>
                            </div>
                            <input type="url" name="map_link" id="map_link" placeholder="https://maps.google.com/?q=..." value="{{ old('map_link') }}"
                                   class="w-full bg-slate-50 border border-slate-100 rounded-2xl pl-11 pr-4 py-4 text-slate-800 font-bold focus:ring-2 focus:ring-primary-500/20 focus:border-primary-500 outline-none transition-all placeholder:text-slate-400/80">
                        </div>
                        <p class="text-[10px] text-slate-400 font-semibold ml-1">Buka Google Maps → Share → Copy link, lalu paste di sini. (Opsional)</p>
                    </div>

                    <div class="grid md:grid-cols-2 gap-6">
                        <!-- Foto Cover -->
                        <div class="space-y-2">
                            <label for="cover_image" class="block text-[10px] font-black text-slate-400 uppercase tracking-widest ml-1">Foto Cover <span class="text-rose-500">*</span></label>
                            <div id="cover-drop-zone" class="relative flex flex-col items-center justify-center gap-3 bg-slate-50 border-2 border-dashed border-slate-200 rounded-2xl p-6 group hover:border-primary-400 hover:bg-primary-50/30 transition-all cursor-pointer">
                                <div class="w-12 h-12 rounded-xl bg-primary-100 flex items-center justify-center text-primary-600 group-hover:scale-110 transition-transform">
                                    <i class="fa-solid fa-image text-xl"></i>
                                </div>
                                <div class="text-center">
                                    <p class="text-xs font-extrabold text-slate-600">1 Foto Utama (Cover)</p>
                                    <p class="text-[10px] text-slate-400 font-semibold mt-0.5">JPG/PNG/WEBP · Maks. 5MB</p>
                                </div>
                                <input type="file" name="cover_image" id="cover_image" accept="image/*" required
                                       class="absolute inset-0 w-full h-full opacity-0 cursor-pointer"
                                       onchange="previewCoverImage(this)">
                                <div id="cover-preview" class="hidden w-full mt-2">
                                    <img id="cover-img" src="" alt="Preview Cover" class="w-full h-32 object-cover rounded-xl border border-slate-200">
                                    <p id="cover-name" class="text-[10px] text-slate-500 font-bold mt-1 text-center truncate"></p>
                                </div>
                            </div>
                        </div>

                        <!-- Foto Slide -->
                        <div class="space-y-2">
                            <label for="slide_images" class="block text-[10px] font-black text-slate-400 uppercase tracking-widest ml-1">Foto Slide Galeri (Maks. 7)</label>
                            <div id="slide-drop-zone" class="relative flex flex-col items-center justify-center gap-3 bg-slate-50 border-2 border-dashed border-slate-200 rounded-2xl p-6 group hover:border-primary-400 hover:bg-primary-50/30 transition-all cursor-pointer">
                                <div class="w-12 h-12 rounded-xl bg-emerald-100 flex items-center justify-center text-emerald-600 group-hover:scale-110 transition-transform">
                                    <i class="fa-solid fa-images text-xl"></i>
                                </div>
                                <div class="text-center">
                                    <p class="text-xs font-extrabold text-slate-600">Beberapa Foto Galeri / Slide</p>
                                    <p class="text-[10px] text-slate-400 font-semibold mt-0.5">JPG/PNG/WEBP · Maks. 7 foto · 5MB/foto</p>
                                </div>
                                <input type="file" name="slide_images[]" id="slide_images" accept="image/*" multiple
                                       class="absolute inset-0 w-full h-full opacity-0 cursor-pointer"
                                       onchange="previewSlideImages(this)">
                                <div id="slide-preview" class="hidden w-full mt-2">
                                    <div id="slide-grid" class="grid grid-cols-3 gap-1.5"></div>
                                    <p id="slide-count" class="text-[10px] text-slate-500 font-bold mt-1.5 text-center"></p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Submit Button -->
                <div class="pt-6 border-t border-slate-100 flex flex-col sm:flex-row items-center justify-between gap-4">
                    <p class="text-[10px] text-slate-400 font-bold leading-normal text-center sm:text-left">
                        Dengan menekan tombol kirim pengajuan, Anda menyetujui <br> 
                        <a href="#" class="underline hover:text-primary-600">Syarat & Ketentuan Kemitraan</a> yang berlaku di Tabibito.
                    </p>
                    
                    <button type="submit" class="w-full sm:w-auto bg-primary-600 hover:bg-primary-700 text-white font-extrabold px-12 py-4 md:py-4.5 rounded-2xl shadow-xl shadow-primary-600/20 transition-all transform hover:-translate-y-1 active:translate-y-0 text-sm md:text-base uppercase tracking-wider flex items-center justify-center gap-2">
                        Kirim Pengajuan Wisata <i class="fa-solid fa-paper-plane text-xs ml-1"></i>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
function previewCoverImage(input) {
    const preview = document.getElementById('cover-preview');
    const img = document.getElementById('cover-img');
    const name = document.getElementById('cover-name');
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

function previewSlideImages(input) {
    const preview = document.getElementById('slide-preview');
    const grid = document.getElementById('slide-grid');
    const count = document.getElementById('slide-count');

    if (input.files && input.files.length > 0) {
        const maxFiles = 7;
        const selected = Math.min(input.files.length, maxFiles);
        grid.innerHTML = '';

        if (input.files.length > maxFiles) {
            alert('Maksimal 7 foto slide yang dapat diunggah. Hanya 7 foto pertama yang akan digunakan.');
        }

        for (let i = 0; i < selected; i++) {
            const reader = new FileReader();
            const idx = i;
            reader.onload = function(e) {
                const div = document.createElement('div');
                div.className = 'relative';
                div.innerHTML = `<img src="${e.target.result}" class="w-full h-16 object-cover rounded-lg border border-slate-200">
                                 <span class="absolute bottom-0.5 right-0.5 bg-black/50 text-white text-[8px] font-bold px-1 rounded">${idx + 1}</span>`;
                grid.appendChild(div);
            };
            reader.readAsDataURL(input.files[idx]);
        }

        count.textContent = `${selected} foto slide dipilih`;
        preview.classList.remove('hidden');
    }
}
</script>
@endpush