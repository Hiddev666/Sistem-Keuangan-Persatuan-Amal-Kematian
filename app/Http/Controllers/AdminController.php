<?php

namespace App\Http\Controllers;

use App\Models\Member;
use App\Models\User;
use Exception;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{
    public function index()
    {
        $users = User::all();
        return view('admin/index', [
            'users' => $users,
        ]);
    }

    public function anggota()
    {
        $members = Member::all();
        return view('admin/anggota/index', [
            "members" => $members
        ]);
    }

    public function addAnggota()
    {
        $members = Member::all();
        return view('admin/anggota/add', [
            "members" => $members
        ]);
    }

    public function createAnggota(Request $request)
    {
        $validated = $request->validate([
            'id' => ['required', 'string'],
            'no_kk' => ['required', 'string'],
            'name' => ['required', 'string'],
            'password' => ['string'],
            'phone' => ['required', 'string'],
            'status' => ['required', 'string'],
            'tanggal_daftar' => ['required', 'date'],
            'address' => ['required', 'string']
        ]);

        try {
            $member = Member::create([
                'id' => $validated['id'],
                'no_kk' => $validated['no_kk'],
                'name' => $validated['name'],
                'password' => Hash::make($validated['password']),
                'phone' => $validated['phone'],
                'status' => $validated['status'],
                'tanggal_daftar' => $validated['tanggal_daftar'],
                'address' => $validated['address'],
            ]);
        } catch (QueryException $err) {
            if ($err->errorInfo[1] == 1062) {
                return redirect()
                    ->back()
                    ->withInput()
                    ->withErrors([
                        'nik' => 'NIK sudah terdaftar'
                    ]);
            }

            return redirect()
                ->back()
                ->withInput()
                ->withErrors([
                    'error' => 'Terjadi kesalahan pada database'
                ]);
        }
        return "ok";
    }
}
