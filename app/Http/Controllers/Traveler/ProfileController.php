<?php

namespace App\Http\Controllers\Traveler;

use App\Http\Controllers\Controller;
use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Hash;
use Illuminate\View\View;

class ProfileController extends Controller
{
    public function edit(): View
    {
        return view('traveler.profile');
    }

    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        $data = $request->validated();
        $user = $request->user();

        $user->name = $data['name'];
        $user->phone = $data['phone'] ?? null;

        if (! empty($data['password'])) {
            $user->password = Hash::make($data['password']);
        }

        if ($user->tipe_user == \App\Models\User::TYPE_OWNER) {
            $user->bank_code = $request->input('bank_code');
            $user->bank_account_number = $request->input('bank_account_number');
            $user->bank_account_name = $request->input('bank_account_name');
        }

        $user->save();

        return back()->with('success', 'Profil berhasil diperbarui.');
    }
}
