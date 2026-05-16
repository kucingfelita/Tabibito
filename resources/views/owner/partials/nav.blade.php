<div x-data="{ open: false }" class="mb-10 relative">
    {{-- Mobile Menu Button --}}
    <div class="md:hidden flex items-center justify-between bg-white/50 backdrop-blur-md p-4 rounded-[2rem] border border-white shadow-sm">
        <span class="font-bold text-slate-700 ml-2">Menu Navigasi</span>
        <button @click="open = !open" class="text-slate-500 hover:text-primary-600 focus:outline-none p-2 rounded-full hover:bg-white transition">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" x-show="!open"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16m-7 6h7"/></svg>
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" x-show="open" style="display: none;"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
        </button>
    </div>

    {{-- Menu Items --}}
    <div x-cloak :class="{'flex': open, 'hidden': !open}" class="md:!flex md:flex-wrap items-center gap-3 bg-white/90 md:bg-white/50 backdrop-blur-md p-2 rounded-[2rem] border border-white shadow-lg md:shadow-sm mt-3 md:mt-0 flex-col md:flex-row absolute md:relative w-full z-20">

        @if(auth()->user()->tipe_user !== \App\Models\User::TYPE_EMPLOYEE)
            {{-- Hanya Owner yang bisa lihat menu ini --}}
            <a href="{{ route('owner.dashboard') }}" class="w-full md:w-auto flex items-center gap-2 px-6 py-3 rounded-full text-sm font-bold transition-all {{ request()->routeIs('owner.dashboard') ? 'bg-primary-600 text-white shadow-lg shadow-primary-200' : 'text-slate-500 hover:bg-white hover:text-primary-600' }}">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>
                Dashboard
            </a>
            <a href="{{ route('owner.destinations.index') }}" class="w-full md:w-auto flex items-center gap-2 px-6 py-3 rounded-full text-sm font-bold transition-all {{ request()->routeIs('owner.destinations.*') ? 'bg-primary-600 text-white shadow-lg shadow-primary-200' : 'text-slate-500 hover:bg-white hover:text-primary-600' }}">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                Destinasi
            </a>
            <a href="{{ route('owner.tickets.index') }}" class="w-full md:w-auto flex items-center gap-2 px-6 py-3 rounded-full text-sm font-bold transition-all {{ request()->routeIs('owner.tickets.*') ? 'bg-primary-600 text-white shadow-lg shadow-primary-200' : 'text-slate-500 hover:bg-white hover:text-primary-600' }}">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 5v2m0 4v2m0 4v2M5 5a2 2 0 00-2 2v3a2 2 0 110 4v3a2 2 0 002 2h14a2 2 0 002-2v-3a2 2 0 110-4V7a2 2 0 00-2-2H5z"/></svg>
                Tiket
            </a>
            <a href="{{ route('owner.withdrawals.index') }}" class="w-full md:w-auto flex items-center gap-2 px-6 py-3 rounded-full text-sm font-bold transition-all {{ request()->routeIs('owner.withdrawals.*') ? 'bg-primary-600 text-white shadow-lg shadow-primary-200' : 'text-slate-500 hover:bg-white hover:text-primary-600' }}">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                Keuangan
            </a>
        @endif

        {{-- Scanner & Riwayat Scan: Owner + Karyawan --}}
        <a href="{{ route('owner.scanner') }}" class="w-full md:w-auto flex items-center gap-2 px-6 py-3 rounded-full text-sm font-bold transition-all {{ request()->routeIs('owner.scanner*') ? 'bg-primary-600 text-white shadow-lg shadow-primary-200' : 'text-slate-500 hover:bg-white hover:text-primary-600' }}">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16 20h4M4 12h4m12 0h.01M5 8h2a1 1 0 001-1V5a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1zm12 0h2a1 1 0 001-1V5a1 1 0 00-1-1h-2a1 1 0 00-1 1v2a1 1 0 001 1zM5 20h2a1 1 0 001-1v-2a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1z"/></svg>
            Scanner
        </a>
        <a href="{{ route('owner.scan-history') }}" class="w-full md:w-auto flex items-center gap-2 px-6 py-3 rounded-full text-sm font-bold transition-all {{ request()->routeIs('owner.scan-history') ? 'bg-primary-600 text-white shadow-lg shadow-primary-200' : 'text-slate-500 hover:bg-white hover:text-primary-600' }}">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg>
            Riwayat Scan
        </a>

        @if(auth()->user()->tipe_user !== \App\Models\User::TYPE_EMPLOYEE)
            {{-- Kelola Karyawan: hanya Owner --}}
            <a href="{{ route('owner.employees.index') }}" class="w-full md:w-auto flex items-center gap-2 px-6 py-3 rounded-full text-sm font-bold transition-all {{ request()->routeIs('owner.employees.*') ? 'bg-primary-600 text-white shadow-lg shadow-primary-200' : 'text-slate-500 hover:bg-white hover:text-primary-600' }}">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                Karyawan
            </a>
        @endif

    </div>
</div>
