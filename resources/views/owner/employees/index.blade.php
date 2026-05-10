@extends('layouts.app')

@section('content')
    @include('owner.partials.nav')

    <div class="mt-6 mb-8 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <h1 class="text-2xl font-black text-slate-900">Manajemen Karyawan</h1>
            <p class="mt-1 text-sm text-slate-500">Kelola akun karyawan yang bisa mengakses scanner & riwayat scan.</p>
        </div>
        <button
            x-data
            @click="$dispatch('open-modal', 'add-employee')"
            class="inline-flex items-center gap-2 rounded-xl bg-primary-600 px-5 py-2.5 text-sm font-bold text-white shadow-lg shadow-primary-200 hover:bg-primary-700 transition-colors"
        >
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
            Tambah Karyawan
        </button>
    </div>

    @if(session('success'))
        <div class="mb-6 flex items-center gap-3 rounded-2xl border border-emerald-200 bg-emerald-50 px-5 py-4 text-sm font-semibold text-emerald-700">
            <svg class="h-5 w-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            {{ session('success') }}
        </div>
    @endif

    @if($errors->any())
        <div class="mb-6 flex items-start gap-3 rounded-2xl border border-red-200 bg-red-50 px-5 py-4 text-sm font-semibold text-red-700">
            <svg class="h-5 w-5 mt-0.5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            <ul class="list-disc list-inside space-y-0.5">
                @foreach($errors->all() as $err)
                    <li>{{ $err }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    {{-- Tabel Karyawan --}}
    <div class="overflow-hidden rounded-[2rem] border border-slate-100 bg-white shadow-sm">
        @if($employees->isEmpty())
            <div class="flex flex-col items-center justify-center py-20 text-center">
                <div class="mb-4 flex h-20 w-20 items-center justify-center rounded-full bg-slate-50">
                    <svg class="h-10 w-10 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/>
                    </svg>
                </div>
                <p class="text-base font-bold text-slate-400">Belum ada karyawan</p>
                <p class="mt-1 text-sm text-slate-400">Tambahkan akun karyawan untuk membantu mengelola scanner tiket.</p>
            </div>
        @else
            <div class="overflow-x-auto">
                <table class="w-full text-sm">
                    <thead>
                        <tr class="border-b border-slate-100 bg-slate-50/50">
                            <th class="px-6 py-4 text-left text-xs font-bold uppercase tracking-widest text-slate-400">Karyawan</th>
                            <th class="px-6 py-4 text-left text-xs font-bold uppercase tracking-widest text-slate-400">Username</th>
                            <th class="px-6 py-4 text-left text-xs font-bold uppercase tracking-widest text-slate-400">Akses</th>
                            <th class="px-6 py-4 text-left text-xs font-bold uppercase tracking-widest text-slate-400">Dibuat</th>
                            <th class="px-6 py-4 text-right text-xs font-bold uppercase tracking-widest text-slate-400">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-50">
                        @foreach($employees as $emp)
                            <tr class="group hover:bg-slate-50/80 transition-colors">
                                <td class="px-6 py-4">
                                    <div class="flex items-center gap-3">
                                        <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-full bg-gradient-to-br from-violet-400 to-primary-500 text-sm font-black text-white">
                                            {{ strtoupper(substr($emp->name, 0, 1)) }}
                                        </div>
                                        <p class="font-semibold text-slate-800">{{ $emp->name }}</p>
                                    </div>
                                </td>
                                <td class="px-6 py-4">
                                    <code class="rounded-lg bg-slate-100 px-2.5 py-1 text-xs font-bold text-slate-600">{{ $emp->username }}</code>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="flex flex-wrap gap-1.5">
                                        <span class="inline-flex items-center rounded-full bg-emerald-50 px-2.5 py-1 text-xs font-bold text-emerald-700">Scanner</span>
                                        <span class="inline-flex items-center rounded-full bg-blue-50 px-2.5 py-1 text-xs font-bold text-blue-700">Riwayat Scan</span>
                                    </div>
                                </td>
                                <td class="px-6 py-4 text-slate-500">
                                    {{ $emp->created_at->format('d M Y') }}
                                </td>
                                <td class="px-6 py-4 text-right">
                                    <form
                                        method="POST"
                                        action="{{ route('owner.employees.destroy', $emp) }}"
                                        onsubmit="return confirm('Hapus karyawan {{ addslashes($emp->name) }}? Akun ini tidak dapat dipulihkan.')"
                                    >
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="inline-flex items-center gap-1.5 rounded-xl border border-red-200 bg-red-50 px-3 py-1.5 text-xs font-bold text-red-600 hover:bg-red-100 transition-colors">
                                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                            Hapus
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </div>

    {{-- Modal Tambah Karyawan --}}
    <div
        x-data="{ open: false }"
        @open-modal.window="if ($event.detail === 'add-employee') open = true"
        @keydown.escape.window="open = false"
        x-show="open"
        class="fixed inset-0 z-50 flex items-center justify-center p-4"
        style="display: none;"
    >
        {{-- Backdrop --}}
        <div @click="open = false" x-show="open" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" x-transition:leave="transition ease-in duration-150" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0" class="absolute inset-0 bg-slate-900/40 backdrop-blur-sm"></div>

        {{-- Modal Card --}}
        <div x-show="open" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100" x-transition:leave="transition ease-in duration-150" x-transition:leave-start="opacity-100 scale-100" x-transition:leave-end="opacity-0 scale-95" class="relative w-full max-w-md rounded-[2rem] bg-white p-8 shadow-2xl">
            <div class="mb-6 flex items-center justify-between">
                <div>
                    <h2 class="text-lg font-black text-slate-900">Tambah Karyawan</h2>
                    <p class="mt-0.5 text-xs text-slate-400">Karyawan hanya bisa akses Scanner & Riwayat Scan.</p>
                </div>
                <button @click="open = false" class="flex h-8 w-8 items-center justify-center rounded-full bg-slate-100 text-slate-500 hover:bg-slate-200 transition-colors">
                    <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                </button>
            </div>

            <form method="POST" action="{{ route('owner.employees.store') }}" class="space-y-5">
                @csrf

                <div>
                    <label for="emp-name" class="block text-sm font-semibold text-slate-700 mb-1.5">Nama Karyawan</label>
                    <input
                        id="emp-name"
                        type="text"
                        name="name"
                        value="{{ old('name') }}"
                        placeholder="cth. Budi Santoso"
                        required
                        class="w-full rounded-xl border border-slate-200 px-4 py-2.5 text-sm focus:border-primary-400 focus:outline-none focus:ring-2 focus:ring-primary-100"
                    >
                </div>

                <div>
                    <label for="emp-username" class="block text-sm font-semibold text-slate-700 mb-1.5">Username</label>
                    <input
                        id="emp-username"
                        type="text"
                        name="username"
                        value="{{ old('username') }}"
                        placeholder="cth. budi_scanner"
                        required
                        class="w-full rounded-xl border border-slate-200 px-4 py-2.5 text-sm focus:border-primary-400 focus:outline-none focus:ring-2 focus:ring-primary-100"
                    >
                    <p class="mt-1 text-xs text-slate-400">Digunakan untuk login. Harus unik.</p>
                </div>

                <div>
                    <label for="emp-password" class="block text-sm font-semibold text-slate-700 mb-1.5">Password</label>
                    <input
                        id="emp-password"
                        type="password"
                        name="password"
                        placeholder="Min. 6 karakter"
                        required
                        class="w-full rounded-xl border border-slate-200 px-4 py-2.5 text-sm focus:border-primary-400 focus:outline-none focus:ring-2 focus:ring-primary-100"
                    >
                </div>

                <div class="pt-2 flex gap-3">
                    <button type="button" @click="open = false" class="flex-1 rounded-xl border border-slate-200 py-2.5 text-sm font-bold text-slate-600 hover:bg-slate-50 transition-colors">
                        Batal
                    </button>
                    <button type="submit" class="flex-1 rounded-xl bg-primary-600 py-2.5 text-sm font-bold text-white shadow hover:bg-primary-700 transition-colors">
                        Simpan Karyawan
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection
