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

        if (! $user) {
            $username = str($googleUser->nickname ?: $googleUser->name)->slug('_')->limit(30, '')->toString();
            $username = $username !== '' ? $username : 'user_google';

            $baseUsername = $username;
            $counter = 1;
            while (User::query()->where('username', $username)->exists()) {
                $username = "{$baseUsername}_{$counter}";
                $counter++;
            }

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

        $message = (! $user->phone || str_ends_with($user->email, '@local.user'))
            ? 'Login berhasil. Lengkapi profil Anda terlebih dahulu.'
            : 'Login Google berhasil.';

        return redirect('/')->with('success', $message);
    }
}
