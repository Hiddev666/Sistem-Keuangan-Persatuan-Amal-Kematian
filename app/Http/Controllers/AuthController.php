<?php

namespace App\Http\Controllers;

use App\Models\Member;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function signIn(Request $request)
    {
        return view('auth/login');
    }

    public function login(Request $request)
    {
        $validated = $request->validate([
            'username' => ['required', 'string'],
            'password' => ['required', 'string'],
        ]);

        $user = User::query()->where('username', $validated['username'])->first()
            ?? Member::query()->where('id', $validated['username'])->first();

        if (!$user) {
            return back()
                ->withErrors(['username' => 'NIK/Username tidak ditemukan.'])
                ->onlyInput('username');
        }

        $passwordOk = Hash::check($validated['password'], (string) $user->password);

        // Backward-compatible: kalau password di DB masih plaintext, izinkan sekali lalu re-hash.
        if (! $passwordOk && hash_equals((string) $user->password, (string) $validated['password'])) {
            $user->password = $validated['password'];
            $user->save();
            $passwordOk = true;
        }

        if (! $passwordOk) {
            return back()
                ->withErrors(['password' => 'Password salah.'])
                ->onlyInput('username');
        }

        if (Auth::guard('web')->attempt([
            'username' => $validated['username'],
            'password' => $validated['password']
        ])) {
            $request->session()->regenerate();
            return redirect()->route('admin_dashboard');
        };

        if (Auth::guard('member')->attempt([
            'id' => $validated['username'],
            'password' => $validated['password']
        ])) {
            $request->session()->regenerate();
            return redirect()->route('member_dashboard');
        };
    }

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('sign-in');
    }
}
