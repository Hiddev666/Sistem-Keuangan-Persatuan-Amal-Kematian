@extends('layouts.admin')

@section('title', 'Dashboard | Sistem Keuangan Persatuan Amal Kematian')

@section('content')
    <div class="mb-8">
        <h1 class="text-3xl leading-8">
            Halo,<br>
            <span class="font-semibold">{{ auth()->user()->name ?? 'User' }}!</span>
        </h1>
        <p class="text-gray-500 text-sm">Selamat Datang Di Dashboard Admin👋</p>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
        @php
            $cards = [
                ['title' => 'Saldo Kas', 'subtitle' => 'Per Desember 2025', 'value' => 'Rp 15.000.000'],
                ['title' => 'Kas Masuk', 'subtitle' => 'Per Desember 2025', 'value' => 'Rp 15.000.000'],
                ['title' => 'Kas Keluar', 'subtitle' => 'Per Desember 2025', 'value' => 'Rp 15.000.000'],
            ];
        @endphp

        @foreach ($cards as $card)
            <div class="bg-white border border-gray-200 rounded-md p-4 flex items-start justify-between">
                <div>
                    <div class="text-sm font-semibold text-gray-900">{{ $card['title'] }}</div>
                    <div class="text-sm text-gray-500">{{ $card['subtitle'] }}</div>
                    <div class="mt-6 text-2xl font-bold">{{ $card['value'] }}</div>
                </div>

                <div class="w-10 h-10 rounded-md bg-green-800 text-white flex items-center justify-center">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-5 h-5">
                        <path fill-rule="evenodd" d="M12 1.5a.75.75 0 0 1 .75.75v1.569a6.75 6.75 0 0 1 6 6.69v2.999a2.25 2.25 0 0 1-2.25 2.25h-9A2.25 2.25 0 0 1 5.25 13.5V10.51a6.75 6.75 0 0 1 6-6.691V2.25A.75.75 0 0 1 12 1.5Zm0 4.5a5.25 5.25 0 0 0-5.25 5.25V13.5c0 .414.336.75.75.75h9a.75.75 0 0 0 .75-.75v-2.25A5.25 5.25 0 0 0 12 6Z" clip-rule="evenodd" />
                        <path d="M9 18.75a.75.75 0 0 0 0 1.5h6a.75.75 0 0 0 0-1.5H9Z" />
                    </svg>
                </div>
            </div>
        @endforeach
    </div>
@endsection
