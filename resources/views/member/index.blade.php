@extends('layouts.member')

@section('title', 'Dashboard | Sistem Keuangan Persatuan Amal Kematian')

@section('content')
    <div class="mb-8 py-4 px-0 md:px-8 flex flex-col gap-4">
        <div class="mb-8">
            <h1 class="text-3xl leading-8">
                Halo,<br>
                <span class="font-semibold">{{ auth()->user()->head->name ?? 'User' }}!</span>
            </h1>
            <p class="text-gray-500 text-sm">Nomor KK {{ auth()->user()->id }}</p>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-1 gap-4">
            @php
                $date = now();

                $cards = [
                    ['title' => 'Saldo', 'subtitle' => 'Per ' . $date->locale('id')->translatedFormat('F Y'), 'value' => rupiah($summary->balance), 'icon' => 'money-bag.svg'],
                    ['title' => 'Uang Masuk', 'subtitle' => 'Per ' . $date->locale('id')->translatedFormat('F Y'), 'value' => rupiah($summary->total_income), 'icon' => 'income.svg'],
                    ['title' => 'Uang Keluar', 'subtitle' => 'Per ' . $date->locale('id')->translatedFormat('F Y'), 'value' => rupiah($summary->total_expense), 'icon' => 'expanse.svg'],
                ];
            @endphp

            @foreach ($cards as $card)
                <div class="bg-white border border-gray-200 rounded-md p-4 flex items-start justify-between transition-all duration-300 ease-in-out hover:shadow-lg shadow-gray-100">
                    <div>
                        <div class="text-sm font-semibold text-gray-900">{{ $card['title'] }}</div>
                        <div class="text-sm text-gray-500">{{ $card['subtitle'] }}</div>
                        <div class="mt-6 text-2xl font-bold">{{ $card['value'] }}</div>
                    </div>
                    <div class="w-10 h-10 rounded-md bg-green-800 text-white flex items-center justify-center">
                        <img src="{{ asset("img/icons/" . $card["icon"]) }}" alt="" class="w-5 h-5">
                    </div>
                </div>
            @endforeach
        </div>
    </div>
@endsection
