@extends('layouts.admin')

@section('title', 'Dashboard | Sistem Keuangan Persatuan Amal Kematian')

@section('content')
    <div class="mb-8">
        <h1 class="text-3xl leading-8">
            Halo,<br>
            <span class="font-semibold">{{ auth()->user()->name ?? 'User' }}!</span>
        </h1>
        <p class="text-gray-500 text-sm">Selamat Datang Di Dashboard Admin</p>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
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
    <div class="flex items-start gap-4 mt-4">
        <div class="w-2/3 bg-white p-3 border border-gray-300 rounded-md transition-all duration-300 ease-in-out hover:shadow-lg shadow-gray-100">
            <canvas id="chart"></canvas>
        </div>
        <div class="flex flex-col w-1/3 gap-2">
            <div
                class="w-full bg-gray-100 p-3 border border-gray-300 rounded-md text-sm flex items-center justify-between">
                <div class="flex items-center gap-1">
                    <div class="w-3 h-3 rounded-full bg-green-800">
                    </div>
                    <p>Telah Dibayar</p>
                </div>
                <p class="font-semibold text-lg">{{ $kas_summary->paid_members }}</p>
            </div>
            <div
                class="w-full bg-gray-100 p-3 border border-gray-300 rounded-md text-sm flex items-center justify-between">
                <div class="flex items-center gap-1">
                    <div class="w-3 h-3 rounded-full bg-orange-500">
                    </div>
                    <p>Belum Dibayar</p>
                </div>
                <p class="font-semibold text-lg">{{ $kas_summary->pending_members }}</p>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        const chartData = @json($data);
    </script>
    <script>
        const labels = chartData.map(item => 'Bulan ' + item.bulan);
        const income = chartData.map(item => item.income);
        const expense = chartData.map(item => item.expense);

        new Chart(document.getElementById('chart'), {
            type: 'line',
            data: {
                labels: labels,
                datasets: [
                    {
                        label: 'Uang Masuk',
                        data: income,
                        borderColor: '#016630',
                        backgroundColor: '#069147',
                    },
                    {
                        label: 'Uang Keluar',
                        data: expense,
                        borderColor: '#940000',
                        backgroundColor: '#B70909',
                    }
                ]
            }
        });
    </script>
@endsection
