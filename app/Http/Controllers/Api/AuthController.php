<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $validated = $request->validate([
            'username' => ['required', 'string'],
            'password' => ['required', 'string'],
            'device_name' => ['sometimes', 'nullable', 'string', 'max:255'],
        ]);

        $user = User::query()
            ->where('username', $validated['username'])
            ->first();

        if (! $user) {
            throw ValidationException::withMessages([
                'username' => ['Username tidak ditemukan.'],
            ]);
        }

        $passwordOk = Hash::check($validated['password'], (string) $user->password);

        // Backward-compatible: kalau password di DB masih plaintext, izinkan sekali lalu re-hash.
        if (! $passwordOk && hash_equals((string) $user->password, (string) $validated['password'])) {
            $user->password = $validated['password'];
            $user->save();
            $passwordOk = true;
        }

        if (! $passwordOk) {
            throw ValidationException::withMessages([
                'password' => ['Password salah.'],
            ]);
        }

        $token = $user->createToken($validated['device_name'] ?? 'api')->plainTextToken;

        return response()->json([
            'token' => $token,
            'token_type' => 'Bearer',
            'user' => $user,
        ]);
    }

    public function me(Request $request)
    {
        return response()->json([
            'user' => $request->user(),
        ]);
    }

    public function logout(Request $request)
    {
        $request->user()?->currentAccessToken()?->delete();

        return response()->json([
            'message' => 'Logged out',
        ]);
    }
}
