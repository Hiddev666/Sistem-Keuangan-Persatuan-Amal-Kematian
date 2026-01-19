@extends('layouts.member')

@section('title', 'Dashboard | Sistem Keuangan Persatuan Amal Kematian')

@section('content')
<script src="https://app.midtrans.com/snap/snap.js"
    data-client-key="{{ config('services.midtrans.client_key') }}"></script>
    <div class="mb-8 py-4 px-8 flex justify-center items-center">
            <div class="border border-gray-300 p-3 rounded w-full md:w-1/3 flex flex-col gap-4">
                <div>
                    <p class="text-gray-500 text-sm">{{ $payment->order_id }}</p>
                    <p class="text-xl font-semibold">Pembayaran</p>
                </div>
                <h1 class="text-2xl font-semibold">{{ rupiah($payment->gross_amount) }}</h1>
                <button id="pay-button" class="w-full p-2 text-white font-semibold bg-green-800 rounded">Bayar Sekarang</button>
            </div>

    </div>

    <script>
    document.getElementById('pay-button').onclick = function () {
        snap.pay('{{ $snapToken }}');
    };
    </script>
@endsection
