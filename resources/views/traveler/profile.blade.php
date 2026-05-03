@extends('layouts.app')

@section('content')
    <div class="mx-auto max-w-xl rounded-xl bg-white p-6 shadow-sm">
        <h1 class="text-xl font-semibold">Profile</h1>
        <form method="POST" action="{{ route('profile.update') }}" class="mt-4 space-y-3">
            @csrf
            @method('PUT')
            
            <div class="space-y-1">
                <label class="text-sm font-medium text-slate-700">Informasi Pribadi</label>
                <input name="name" value="{{ auth()->user()->name }}" class="w-full rounded-lg border px-3 py-2" placeholder="Nama Lengkap">
                <input name="phone" value="{{ auth()->user()->phone }}" placeholder="No HP" class="w-full rounded-lg border px-3 py-2">
            </div>

            <div class="space-y-1 pt-3 border-t">
                <label class="text-sm font-medium text-slate-700">Keamanan</label>
                <input type="password" name="password" placeholder="Password baru (opsional)" class="w-full rounded-lg border px-3 py-2">
                <input type="password" name="password_confirmation" placeholder="Konfirmasi password baru" class="w-full rounded-lg border px-3 py-2">
            </div>

            @if(auth()->user()->tipe_user == \App\Models\User::TYPE_OWNER)
            <div class="space-y-1 pt-3 border-t">
                <label class="text-sm font-medium text-slate-700">Rekening Pencairan Dana</label>
                <p class="text-xs text-slate-500 mb-2">Pilih bank yang didukung untuk pencairan otomatis.</p>
                <select name="bank_code" class="w-full rounded-lg border px-3 py-2">
                    <option value="">Pilih Bank / E-Wallet</option>
                    @php
                        $banks = ['bca' => 'BCA', 'bni' => 'BNI', 'bri' => 'BRI', 'mandiri' => 'Mandiri', 'cimb' => 'CIMB Niaga', 'permata' => 'Permata', 'gopay' => 'GoPay', 'ovo' => 'OVO', 'dana' => 'DANA', 'shopeepay' => 'ShopeePay'];
                    @endphp
                    @foreach($banks as $code => $name)
                        <option value="{{ $code }}" {{ auth()->user()->bank_code == $code ? 'selected' : '' }}>{{ $name }}</option>
                    @endforeach
                </select>
                <input name="bank_account_number" value="{{ auth()->user()->bank_account_number }}" placeholder="Nomor Rekening / Akun" class="w-full rounded-lg border px-3 py-2 mt-2">
                <input name="bank_account_name" value="{{ auth()->user()->bank_account_name }}" placeholder="Nama Pemilik Rekening" class="w-full rounded-lg border px-3 py-2 mt-2">
            </div>
            @endif

            <div class="pt-4">
                <button class="w-full rounded-lg bg-emerald-600 px-4 py-2 text-white font-medium hover:bg-emerald-700 transition">Simpan Perubahan</button>
            </div>
        </form>
    </div>
@endsection
