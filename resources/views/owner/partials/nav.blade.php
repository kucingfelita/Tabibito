<div class="mt-4 flex flex-wrap items-center gap-2 rounded-3xl bg-white px-4 py-3 shadow-sm">
    <a href="{{ route('owner.dashboard') }}" class="rounded-full px-4 py-2 text-sm font-medium transition {{ request()->routeIs('owner.dashboard') ? 'bg-emerald-600 text-white' : 'bg-slate-100 text-slate-700 hover:bg-slate-200' }}">Dashboard</a>
    <a href="{{ route('owner.destinations.index') }}" class="rounded-full px-4 py-2 text-sm font-medium transition {{ request()->routeIs('owner.destinations.*') ? 'bg-emerald-600 text-white' : 'bg-slate-100 text-slate-700 hover:bg-slate-200' }}">Kelola Destinasi</a>
    <a href="{{ route('owner.tickets.index') }}" class="rounded-full px-4 py-2 text-sm font-medium transition {{ request()->routeIs('owner.tickets.*') ? 'bg-emerald-600 text-white' : 'bg-slate-100 text-slate-700 hover:bg-slate-200' }}">Kelola Tiket</a>
    <a href="{{ route('owner.withdrawals.index') }}" class="rounded-full px-4 py-2 text-sm font-medium transition {{ request()->routeIs('owner.withdrawals.*') ? 'bg-emerald-600 text-white' : 'bg-slate-100 text-slate-700 hover:bg-slate-200' }}">Keuangan</a>
    <a href="{{ route('owner.scanner') }}" class="rounded-full px-4 py-2 text-sm font-medium transition {{ request()->routeIs('owner.scanner*') ? 'bg-emerald-600 text-white' : 'bg-slate-100 text-slate-700 hover:bg-slate-200' }}">Scanner</a>
</div>
