@extends('layouts.member')

@section('title', 'Dashboard | Sistem Keuangan Persatuan Amal Kematian')

@section('content')
    <script src="{{ config('app.midtrans_snap_url') }}"
        data-client-key="{{ config('services.midtrans.client_key') }}"></script>
    <div class="mb-8 py-4 px-8 flex justify-center items-center">
        <div class="border border-gray-300 p-4  rounded w-full md:w-1/3 flex flex-col gap-4">
            <div>
                <p class="text-2xl font-semibold">Pembayaran Registrasi</p>
                <p class="text-gray-400 text-xs">{{ $params["transaction_details"]["order_id"] }}</p>
            </div>

            <table class="text-sm">
                <tr class="border-b text-gray-400 border-gray-200 transition-all ease-in-out">
                    <td class="p-2">Nomor KK</td>
                    <td class="p-2">Nomor Telepon Registrasi</td>
                </tr>
                <tr class="border-b border-gray-200 transition-all ease-in-out">
                    <td class="p-2">{{ $family_card->id }}</td>
                    <td class="p-2">{{ $family_card->phone }}</td>
                </tr>
            </table>

            <div class="p-2">
                <p class="text-sm text-gray-500">Total</p>
                <h1 class="text-2xl font-semibold">{{ rupiah($params["transaction_details"]["gross_amount"]) }}</h1>
            </div>
            <div class="w-full flex flex-col gap-2">
                <button id="pay-button" class="w-full p-3 text-sm text-white font-semibold bg-green-800 rounded">Bayar Sekarang</button>
            </div>

        </div>

    </div>

    <script>
        document.getElementById('pay-button').onclick = function () {
            snap.pay('{{ $snapToken }}');
        };
    </script>
@endsection
