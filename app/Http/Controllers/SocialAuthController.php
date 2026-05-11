<?php

namespace App\Http\Controllers;

use App\Jobs\SendWelcomeMailJob;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;

class SocialAuthController extends Controller
{
    public function redirectToGoogle(): RedirectResponse
    {
        return Socialite::driver('google')->redirect();
    }

    public function handleGoogleCallback(): RedirectResponse
    {
        $googleUser = Socialite::driver('google')->stateless()->user();

        $user = User::query()->where('google_id', $googleUser->id)
            ->orWhere('email', $googleUser->email)
            ->first();

        $isNewUser = false;

        if (! $user) {
            $isNewUser = true;
            // Gunakan email sebagai username agar user bisa login manual nantinya
            $username = $googleUser->email;

            $user = User::query()->create([
                'name' => $googleUser->name,
                'username' => $username,
                'email' => $googleUser->email,
                'google_id' => $googleUser->id,
                'tipe_user' => User::TYPE_USER,
                'password' => bcrypt(str()->random(40)),
            ]);

            SendWelcomeMailJob::dispatch($user);
        } elseif (! $user->google_id) {
            $user->update(['google_id' => $googleUser->id]);
        }

        Auth::login($user);
        request()->session()->regenerate();

        if ($isNewUser) {
            return redirect()->route('google.set-password');
        }

        return redirect('/')->with('success', 'Login berhasil.');
    }
}
