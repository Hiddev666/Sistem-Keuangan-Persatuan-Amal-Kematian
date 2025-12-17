@extends('layouts.main')

@section('title', 'Login | Sistem Keuangan Persatuan Amal Kematian')

@section('content')
    <div class="w-full h-screen flex justify-between items-center">
        <div class="w-2/5 h-full bg-white flex items-center justify-center">
            <div class="w-2/3">
                <div class="flex items-center gap-2 mb-9">
                    <img src="{{ asset('img/logo.svg') }}" alt="Logo" class="w-9 h-9">
                    <div class="leading-tight">
                        <div class="text-sm font-semibold">Sistem Keuangan</div>
                        <div class="text-sm text-gray-600">Persatuan Amal Kematian</div>
                    </div>
                </div>
                <h1 class="text-3xl font-bold">Sign In</h1>

                @if ($errors->any())
                    <div class="mt-4 rounded-md border border-red-200 bg-red-50 p-3 text-sm text-red-700">
                        <p class="font-semibold">Login gagal:</p>
                        <ul class="mt-1 list-disc pl-5">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ route("login") }}" method="post" class="mt-4 flex flex-col gap-3">
                    @csrf
                    <div>
                        <label for="username" class="text-gray-600 text-sm">NIK / Username</label>
                        <input type="text" id="username" name="username" value="{{ old('username') }}"
                            class="p-3 text-sm w-full border border-gray-300 rounded-md @error('username') border-red-400 @enderror"
                            autofocus>
                        @error('username')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <label for="password" class="text-gray-600 text-sm">Password</label>
                        <div class="relative w-full max-w-sm">
                            <input type="password" id="password" name="password" placeholder="******"
                                class="p-3 text-sm w-full border border-gray-300 rounded-md @error('password') border-red-400 @enderror">
                            <button type="button" onclick="togglePassword()"
                                class="absolute inset-y-0 right-3 flex items-center text-gray-500 hover:text-gray-700">
                                👁
                            </button>
                        </div>
                        @error('password')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <button
                            class="bg-green-800 mt-2 p-3 text-sm w-full rounded-md text-white font-semibold transition-all duration-200 ease-in-out hover:bg-green-700 active:py-2">Sign
                            In</button>
                    </div>
                </form>
                <p class="text-center mt-4 text-gray-600 text-sm">Sistem Keuangan PAK ©2025</p>
            </div>
        </div>
        <div class="w-3/5 h-screen bg-gradient-to-t from-green-800 to-green-500 flex justify-center items-center">
            <div class="flex items-center gap-5 opacity-75">
                <img src="{{ asset("img/logo-icon.svg") }}" alt="Logo">
                <div class="flex flex-col">
                    <p class="leading-7 text-3xl text-white">Sistem Keuangan <br> <span class="font-semibold">Persatuan Amal
                            Kematian</span></p>
                </div>
            </div>
        </div>
    </div>
@endsection
