<?php

namespace App\Http\Controllers\Owner;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;
use Illuminate\View\View;

class EmployeeController extends Controller
{
    public function index(): View
    {
        $employees = User::query()
            ->where('owner_id', auth()->id())
            ->where('tipe_user', User::TYPE_EMPLOYEE)
            ->orderByDesc('created_at')
            ->get();

        return view('owner.employees.index', compact('employees'));
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'name'     => ['required', 'string', 'max:100'],
            'username' => ['required', 'string', 'max:50', 'unique:users,username'],
            'password' => ['required', 'string', Password::min(6)],
        ]);

        User::query()->create([
            'name'      => $data['name'],
            'username'  => $data['username'],
            'email'     => sprintf('%s@employee.local', $data['username']),
            'password'  => Hash::make($data['password']),
            'tipe_user' => User::TYPE_EMPLOYEE,
            'owner_id'  => auth()->id(),
        ]);

        return back()->with('success', 'Akun karyawan berhasil dibuat.');
    }

    public function destroy(User $employee): RedirectResponse
    {
        // Pastikan karyawan ini benar-benar milik owner yang sedang login
        if ($employee->owner_id !== auth()->id() || $employee->tipe_user !== User::TYPE_EMPLOYEE) {
            abort(403, 'Anda tidak berhak menghapus karyawan ini.');
        }

        $employee->delete();

        return back()->with('success', 'Akun karyawan berhasil dihapus.');
    }
}
