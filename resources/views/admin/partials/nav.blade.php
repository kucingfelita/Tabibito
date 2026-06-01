<nav class="mb-10 overflow-x-auto flex gap-2 pb-2.5 border-b border-slate-100">
    <a href="{{ route('admin.dashboard') }}"
       class="px-5 py-3 rounded-2xl text-xs font-black uppercase tracking-wider transition-all shrink-0 flex items-center gap-2 whitespace-nowrap
              {{ request()->routeIs('admin.dashboard') ? 'bg-slate-900 text-white shadow-lg' : 'bg-white hover:bg-slate-50 text-slate-600 border border-slate-100' }}">
        <i class="fa-solid fa-gauge-high text-sm"></i> Dashboard
    </a>
    <a href="{{ route('admin.destinations.index') }}"
       class="px-5 py-3 rounded-2xl text-xs font-black uppercase tracking-wider transition-all shrink-0 flex items-center gap-2 whitespace-nowrap
              {{ request()->routeIs('admin.destinations.*') ? 'bg-slate-900 text-white shadow-lg' : 'bg-white hover:bg-slate-50 text-slate-600 border border-slate-100' }}">
        <i class="fa-solid fa-map-location-dot text-sm"></i> Destinasi
    </a>
</nav>
