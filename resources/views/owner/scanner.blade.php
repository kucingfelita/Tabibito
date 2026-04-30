@extends('layouts.app')

@section('content')
    <h1 class="text-xl font-semibold">Scanner Tiket</h1>
    <p class="mt-2 text-sm text-slate-500">Masukkan token QR hasil scan dari aplikasi kamera scanner Anda.</p>
    <form x-data="{ token:'', result:'' }" @submit.prevent="fetch('{{ route('owner.scanner.verify') }}',{method:'POST',headers:{'Content-Type':'application/json','X-CSRF-TOKEN':'{{ csrf_token() }}'},body:JSON.stringify({qr_code_token:token})}).then(r=>r.json()).then(d=>result=d.message)" class="mt-4 max-w-xl rounded-xl bg-white p-4 shadow-sm">
        <input x-model="token" class="w-full rounded-lg border px-3 py-2" placeholder="QR Code Token">
        <button class="mt-3 rounded-lg bg-emerald-600 px-4 py-2 text-white">Verifikasi Tiket</button>
        <p x-text="result" class="mt-3 text-sm text-slate-600"></p>
    </form>
@endsection
