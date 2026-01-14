@extends('layouts.member')

@section('title', 'Dashboard | Sistem Keuangan Persatuan Amal Kematian')

@section('content')
    <div class="mb-8 py-4 px-8 flex justify-center items-center">
            <div class="border border-gray-300 p-3 rounded w-full md:w-1/3 flex flex-col gap-2">
                <h1 class="font-semibold text-2xl">Donasi</h1>
                <form action="{{ route("member_donasi_pay") }}" method="post" class="flex flex-col gap-2">
                    @csrf
                    <div>
                        <label for="amount" class="text-gray-600 text-sm">Nominal Donasi</label>
                        <input type="text" id="amount" name="amount"
                            class="p-3 text-sm w-full border border-gray-300 rounded-md"
                            autofocus>
                    </div>
                    <button type="submit" id="pay-button" class="w-full p-2 text-white font-semibold bg-green-800 rounded">Bayar Sekarang</button>
                </form>
            </div>

    </div>
@endsection
