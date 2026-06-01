@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto px-4 md:px-6">
    <!-- Header -->
    <div class="mb-8">
        <h1 class="text-3xl font-black text-slate-900 tracking-tight">Manajemen Paket Tiket</h1>
        <p class="text-xs text-slate-400 font-bold uppercase tracking-wider mt-1">Buat, perbarui, dan atur paket tiket wisata beserta kuota harian</p>
    </div>

    @include('owner.partials.nav')

    <!-- Grid Container -->
    <div class="mt-8 space-y-10">
        
        <!-- Add Ticket Card Form -->
        <div class="bg-white rounded-[2.5rem] border border-slate-100 shadow-xl shadow-slate-200/40 p-8 md:p-12 relative overflow-hidden">
            <div class="absolute top-0 right-0 w-32 h-32 bg-primary-50 rounded-full -mr-16 -mt-16 opacity-40"></div>
            
            <h2 class="text-2xl font-black text-slate-900 tracking-tight mb-8 flex items-center gap-3 relative z-10">
                <div class="w-10 h-10 rounded-xl bg-primary-50 flex items-center justify-center text-primary-600">
                    <i class="fa-solid fa-ticket text-base"></i>
                </div>
                Buat Paket Tiket Wisata Baru
            </h2>

            <form method="POST" action="{{ route('owner.tickets.store') }}" class="space-y-6 relative z-10" id="add-ticket-form">
                @csrf
                
                <div class="grid md:grid-cols-2 gap-8">
                    <!-- Left Col -->
                    <div class="space-y-5">
                        <!-- Pilih Destinasi -->
                        <div class="space-y-2">
                            <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest ml-1">Pilih Tempat Wisata</label>
                            <div class="relative group">
                                <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-slate-400 group-focus-within:text-primary-600 transition-colors z-10">
                                    <i class="fa-solid fa-umbrella-beach text-sm"></i>
                                </div>
                                <select name="destination_id" required 
                                        class="w-full bg-slate-50 border border-slate-100 rounded-2xl pl-11 pr-4 py-4 text-slate-800 font-bold focus:ring-2 focus:ring-primary-500/20 focus:border-primary-500 outline-none transition-all appearance-none">
                                    <option value="" class="font-bold text-slate-400">Pilih Tempat Wisata Terdaftar</option>
                                    @foreach($destinations as $destination)
                                        <option value="{{ $destination->id }}" class="font-bold text-slate-800">{{ $destination->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <!-- Nama Paket Tiket -->
                        <div class="space-y-2">
                            <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest ml-1">Nama Kategori / Paket Tiket</label>
                            <div class="relative group">
                                <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-slate-400 group-focus-within:text-primary-600 transition-colors">
                                    <i class="fa-solid fa-tags text-sm"></i>
                                </div>
                                <input type="text" name="name" required placeholder="Contoh: Tiket Masuk Terusan Akhir Pekan" maxlength="120" value="{{ old('name') }}"
                                       class="w-full bg-slate-50 border border-slate-100 rounded-2xl pl-11 pr-4 py-4 text-slate-800 font-bold focus:ring-2 focus:ring-primary-500/20 focus:border-primary-500 outline-none transition-all placeholder:text-slate-400/80">
                            </div>
                        </div>

                        <!-- Harga & Kuota Grid -->
                        <div class="grid grid-cols-2 gap-4">
                            <!-- Harga -->
                            <div class="space-y-2">
                                <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest ml-1">Harga (Rupiah)</label>
                                <div class="relative group">
                                    <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-slate-400 group-focus-within:text-primary-600 transition-colors">
                                        <span class="text-xs font-bold">Rp</span>
                                    </div>
                                    <input type="number" name="price" required min="1000" max="999999999" placeholder="15000" value="{{ old('price') }}"
                                           class="w-full bg-slate-50 border border-slate-100 rounded-2xl pl-10 pr-4 py-4 text-slate-800 font-bold focus:ring-2 focus:ring-primary-500/20 focus:border-primary-500 outline-none transition-all placeholder:text-slate-400/80">
                                </div>
                            </div>

                            <!-- Kuota Harian -->
                            <div class="space-y-2">
                                <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest ml-1">Kuota per Hari</label>
                                <div class="relative group">
                                    <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-slate-400 group-focus-within:text-primary-600 transition-colors">
                                        <i class="fa-solid fa-users text-sm"></i>
                                    </div>
                                    <input type="number" name="daily_quota" required min="1" max="1000000" placeholder="100" value="{{ old('daily_quota') }}"
                                           class="w-full bg-slate-50 border border-slate-100 rounded-2xl pl-11 pr-4 py-4 text-slate-800 font-bold focus:ring-2 focus:ring-primary-500/20 focus:border-primary-500 outline-none transition-all placeholder:text-slate-400/80">
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Right Col -->
                    <div class="space-y-5">
                        <!-- Benefit Tiket -->
                        <div class="space-y-2">
                            <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest ml-1">Manfaat / Fasilitas yang Didapat (*Benefit*)</label>
                            <textarea name="benefit" rows="6" required placeholder="Sebutkan fasilitas khusus tiket ini, contoh:&#10;- Gratis softdrink&#10;- Akses kolam renang air hangat&#10;- Wahana bermain gratis"
                                      class="w-full bg-slate-50 border border-slate-100 rounded-2xl px-6 py-4 text-slate-800 font-bold focus:ring-2 focus:ring-primary-500/20 focus:border-primary-500 outline-none transition-all placeholder:text-slate-400/80 resize-none">{{ old('benefit') }}</textarea>
                        </div>
                    </div>
                </div>

                <!-- Submit -->
                <div class="pt-6 border-t border-slate-100 flex justify-end">
                    <button type="submit" class="w-full sm:w-auto bg-primary-600 hover:bg-primary-700 text-white font-extrabold px-12 py-4 md:py-4.5 rounded-2xl shadow-xl shadow-primary-600/20 transition-all transform hover:-translate-y-1 active:translate-y-0 text-sm md:text-base uppercase tracking-wider flex items-center justify-center gap-2">
                        Tambah Paket Tiket <i class="fa-solid fa-circle-plus text-base ml-1"></i>
                    </button>
                </div>
            </form>
        </div>

        <!-- List Tickets -->
        <div class="space-y-6">
            <h3 class="text-xl font-bold text-slate-900 tracking-tight flex items-center gap-2"><i class="fa-solid fa-list-check text-primary-500"></i> Daftar Paket Tiket Terdaftar</h3>
            
            <div class="grid md:grid-cols-2 gap-6">
                @foreach($tickets as $ticket)
                    <div class="bg-white rounded-[2rem] border border-slate-100 shadow-xl shadow-slate-200/40 p-6 md:p-8 relative overflow-hidden flex flex-col justify-between">
                        <!-- Decorative background -->
                        <div class="absolute top-0 right-0 w-24 h-24 bg-slate-50 rounded-full -mr-12 -mt-12 opacity-60"></div>
                        
                        <div class="relative z-10 space-y-5">
                            <!-- Destinasi & Status Info -->
                            <div class="flex items-center justify-between gap-4 pb-4 border-b border-slate-50">
                                <div>
                                    <p class="text-[9px] font-black text-primary-600 uppercase tracking-widest">{{ $ticket->destination->name }}</p>
                                    <h4 class="font-black text-slate-900 text-base mt-0.5 leading-snug">{{ $ticket->name }}</h4>
                                </div>
                                @php $destStatus = $ticket->destination->status ?? 'pending'; @endphp
                                <span class="px-2.5 py-1 rounded-lg font-extrabold text-[10px] uppercase tracking-wider border flex items-center gap-1.5 shrink-0
                                    @if($destStatus === 'active') bg-emerald-50 text-emerald-600 border-emerald-100
                                    @elseif($destStatus === 'rejected') bg-rose-50 text-rose-600 border-rose-100
                                    @else bg-amber-50 text-amber-600 border-amber-100 @endif">
                                    @if($destStatus === 'active')
                                        <i class="fa-solid fa-circle-check text-[8px]"></i> Siap Dijual
                                    @elseif($destStatus === 'rejected')
                                        <i class="fa-solid fa-circle-xmark text-[8px]"></i> Belum Publik
                                    @else
                                        <i class="fa-solid fa-hourglass-half text-[8px]"></i> Menunggu Verifikasi
                                    @endif
                                </span>
                            </div>

                            <!-- Edit Form Inline -->
                            <form method="POST" action="{{ route('owner.tickets.update', $ticket) }}" class="space-y-4">
                                @csrf
                                @method('PUT')
                                
                                <div class="space-y-4">
                                    <!-- Destination -->
                                    <div class="space-y-1">
                                        <label class="block text-[8px] font-black text-slate-400 uppercase tracking-widest ml-1">Nama Tempat Wisata</label>
                                        <select name="destination_id" required class="w-full bg-slate-50 border border-slate-100 rounded-xl px-4 py-2.5 text-xs text-slate-800 font-bold">
                                            @foreach($destinations as $destination)
                                                <option value="{{ $destination->id }}" @selected($destination->id === $ticket->destination_id)>{{ $destination->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <!-- Nama Paket -->
                                    <div class="space-y-1">
                                        <label class="block text-[8px] font-black text-slate-400 uppercase tracking-widest ml-1">Nama Kategori / Paket</label>
                                        <input type="text" name="name" required value="{{ $ticket->name }}" class="w-full bg-slate-50 border border-slate-100 rounded-xl px-4 py-2.5 text-xs text-slate-800 font-bold" maxlength="120">
                                    </div>

                                    <!-- Price & Quota -->
                                    <div class="grid grid-cols-2 gap-4">
                                        <div class="space-y-1">
                                            <label class="block text-[8px] font-black text-slate-400 uppercase tracking-widest ml-1">Harga (Rp)</label>
                                            <input type="number" name="price" required value="{{ $ticket->price }}" class="w-full bg-slate-50 border border-slate-100 rounded-xl px-4 py-2.5 text-xs text-slate-800 font-bold" min="1000" max="999999999">
                                        </div>
                                        <div class="space-y-1">
                                            <label class="block text-[8px] font-black text-slate-400 uppercase tracking-widest ml-1">Kuota Harian</label>
                                            <input type="number" name="daily_quota" required value="{{ $ticket->daily_quota }}" class="w-full bg-slate-50 border border-slate-100 rounded-xl px-4 py-2.5 text-xs text-slate-800 font-bold" min="1" max="1000000">
                                        </div>
                                    </div>

                                    <!-- Benefit -->
                                    <div class="space-y-1">
                                        <label class="block text-[8px] font-black text-slate-400 uppercase tracking-widest ml-1">Manfaat (*Benefit*)</label>
                                        <textarea name="benefit" rows="3" required class="w-full bg-slate-50 border border-slate-100 rounded-xl px-4 py-2.5 text-xs text-slate-800 font-bold resize-none leading-relaxed">{{ $ticket->benefit }}</textarea>
                                    </div>
                                </div>

                                <!-- Action buttons -->
                                <div class="pt-4 border-t border-slate-50 flex items-center justify-between gap-4">
                                    <button type="submit" class="bg-cyan-600 hover:bg-cyan-700 text-white font-extrabold px-6 py-2.5 rounded-xl transition-all text-xs uppercase tracking-wider flex items-center gap-1.5 active:scale-95 shadow-sm">
                                        <i class="fa-solid fa-cloud-arrow-up text-sm"></i> Simpan
                                    </button>
                                
                            </form>
                                    
                                    <!-- Delete Button Form outside main form -->
                                    <form method="POST" action="{{ route('owner.tickets.destroy', $ticket) }}" onsubmit="return confirm('Apakah Anda yakin ingin menghapus paket tiket ini secara permanen?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="bg-rose-50 hover:bg-rose-100 text-rose-600 font-extrabold px-5 py-2.5 rounded-xl transition-all text-xs uppercase tracking-wider flex items-center gap-1.5 active:scale-95">
                                            <i class="fa-solid fa-trash-can text-sm"></i> Hapus
                                        </button>
                                    </form>
                                </div>
                        </div>
                    </div>
                @endforeach
            </div>
            
            <div class="mt-6 flex justify-center">{{ $tickets->links() }}</div>
        </div>

    </div>
</div>
@endsection
