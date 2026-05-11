<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Jobs\SendWelcomeMailJob;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\View\View;

class AuthController extends Controller
{
    public function showLogin(): View
    {
        return view('auth.login');
    }

    public function showRegister(): View
    {
        return view('auth.register');
    }

    public function login(LoginRequest $request): RedirectResponse
    {
        $credentials = $request->validated();
        $field = filter_var($credentials['login'], FILTER_VALIDATE_EMAIL) ? 'email' : 'username';

        if (! Auth::attempt([$field => $credentials['login'], 'password' => $credentials['password']])) {
            return back()->withInput()->withErrors([
                'login' => 'Kredensial tidak valid.',
            ]);
        }

        $request->session()->regenerate();

        $user = Auth::user();
        $redirectTo = '/';
        if ($user->tipe_user == 1) {
            $redirectTo = '/admin/dashboard';
        } elseif ($user->tipe_user == 3) {
            $redirectTo = '/owner/dashboard';
        } elseif ($user->tipe_user == 4) {
            $redirectTo = '/owner/scanner';
        }

        return redirect($redirectTo)->with('success', 'Login berhasil.');
    }

    public function register(RegisterRequest $request): RedirectResponse
    {
        $user = User::query()->create([
            'name' => $request->string('name')->toString(),
            'username' => $request->string('username')->toString(),
            'email' => sprintf('%s@local.user', $request->string('username')->toString()),
            'phone' => $request->string('phone')->toString() ?: null,
            'password' => Hash::make($request->string('password')->toString()),
            'tipe_user' => User::TYPE_USER,
        ]);

        Auth::login($user);
        $request->session()->regenerate();
        SendWelcomeMailJob::dispatch($user);

        return redirect('/')->with('success', 'Akun berhasil dibuat.');
    }

    public function logout(): RedirectResponse
    {
        Auth::logout();
        request()->session()->invalidate();
        request()->session()->regenerateToken();

        return redirect('/')->with('success', 'Logout berhasil.');
    }

    public function showSetGooglePassword(): View
    {
        return view('auth.google-password');
    }

    public function storeGooglePassword(\Illuminate\Http\Request $request): RedirectResponse
    {
        $request->validate([
            'password' => ['required', 'confirmed', \Illuminate\Validation\Rules\Password::min(8)],
        ]);

        /** @var \App\Models\User $user */
        $user = Auth::user();
        $user->password = Hash::make($request->password);
        $user->save();

        return redirect('/')->with('success', 'Registrasi berhasil. Silakan nikmati layanan kami.');
    }
}
