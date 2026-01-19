@extends('layouts.member')

@section('title', 'Dashboard | Sistem Keuangan Persatuan Amal Kematian')

@section('content')
    <div class="mt-5 mb-8 py-4 px-0 md:px-8 flex flex-col gap-5">
        <div class="">
            <h1 class="text-3xl font-semibold">
                Pembayaran
            </h1>
        </div>

        @if (request('success'))
        <div class="mb-4 rounded-md border border-green-200 bg-green-50 p-3 text-sm text-green-700 w-fit" id="success-flash"
            onshow="flash()">
            <p class="text-sm text-green-600">{{ request('success') }}</p>
        </div>
        @endif

        <div class="flex justify-center gap-5 w-full flex-col md:flex-row">
            <div class="w-full md:w-1/2 p-3 border border-gray-300 rounded-md flex flex-col gap-5 overflow-x-auto">
                <div class="flex items-center justify-between">
                    <div>
                        <div class="flex items-center gap-2">
                            <div class="w-4 h-4 bg-green-800 rounded-full"></div>
                            <h2 class="text-xl font-semibold">Tagihan Duka</h2>
                        </div>
                        <p class="text-sm text-gray-500">Tagihan Wajib Untuk Setiap Kabar Duka</p>
                    </div>
                </div>
                <table class="text-sm w-full">
                    <thead class="bg-gray-100 border border-gray-300">
                        <th class="font-normal p-3 text-start">Tanggal</th>
                        <th class="font-normal p-3 text-start">Yang Berpulang</th>
                        <th class="font-normal p-3 text-start">Nominal</th>
                    </thead>
                    <tbody id="result">
                        @foreach ($contributions as $contribution)
                                    <tr class="border-b border-gray-200 transition-all ease-in-out">
                                        <td class="font-normal p-2 text-start font-semibold w-max">{{ formatTanggalIndonesia($contribution->created_at) }}</td>
                                        <td class="font-normal p-2 text-start font-semibold w-max">{{ $contribution->death_event->member->name }}</td>
                                        <td class="font-normal p-2 text-start font-medium w-max">{{ rupiah($contribution->amount) }}</td>
                                    </tr>
                        @endforeach
                    </tbody>
                </table>
                <div class="w-full flex justify-between items-center px-3">
                    <div>
                        <p class="text-gray-500 text-sm">Total</p>
                        <p class="text-xl font-bold">{{ rupiah($contributions->sum("amount")) }}</p>
                    </div>
                    <a href="{{ route("member_kas_pays") }}">
                        <button
                            class="px-3 py-2 flex items-center gap-1 bg-green-800 text-sm font-semibold rounded-md text-white transition-all duration-200 ease-in-out hover:bg-green-700">
                            Bayar Semua</button>
                    </a>
                </div>
            </div>

            <div class="w-full md:w-1/2 p-3 border border-gray-300 rounded-md flex flex-col gap-5 overflow-x-auto">
                <div class="flex justify-between items-center">
                    <div class="flex items-center justify-between">
                        <div>
                            <div class="flex items-center gap-2">
                                <div class="w-4 h-4 bg-green-800 rounded-full"></div>
                                <h2 class="text-xl font-semibold">Donasi</h2>
                            </div>
                            <p class="text-sm text-gray-500">Donasi Sukarela</p>
                        </div>
                    </div>
                    <a href="{{ route("member_donasi") }}">
                        <button
                            class="px-3 py-2 flex items-center gap-1 bg-green-800 text-sm font-semibold rounded-md text-white transition-all duration-200 ease-in-out hover:bg-green-700">
                            <svg viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" fill="#000000" class="w-5 h-5">
                                <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                                <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
                                <g id="SVGRepo_iconCarrier">
                                    <g id="Complete">
                                        <g data-name="add" id="add-2">
                                            <g>
                                                <line fill="none" stroke="#ffffff" stroke-linecap="round"
                                                    stroke-linejoin="round" stroke-width="2" x1="12" x2="12" y1="19" y2="5">
                                                </line>
                                                <line fill="none" stroke="#ffffff" stroke-linecap="round"
                                                    stroke-linejoin="round" stroke-width="2" x1="5" x2="19" y1="12" y2="12">
                                                </line>
                                            </g>
                                        </g>
                                    </g>
                                </g>
                            </svg>
                            Donasi</button>
                    </a>
                </div>
                <table class="text-sm w-full">
                    <thead class="bg-gray-100 border border-gray-300">
                        <th class="font-normal p-3 text-center">Tanggal</th>
                        <th class="font-normal p-3 text-center">Nominal</th>
                        <th class="font-normal p-3 text-center">Status Pembayaran</th>
                        <th class="font-normal p-3 text-center">Action</th>
                    </thead>
                    <tbody id="result">
                        @foreach ($donations as $donation)
                                    <tr class="border-b border-gray-200 transition-all ease-in-out">
                                        <td class="font-normal p-2 text-center font-semibold w-max">{{ formatTanggalIndonesia($donation->created_at) }}</td>
                                        <td class="font-normal p-2 text-center font-medium">{{ rupiah($donation->amount) }}</td>
                                        <td class="font-normal p-2 text-center font-medium align-middle">
                                            <div class="flex items-center gap-1 justify-center">
                                                <div class="w-3 h-3 rounded-full {{ $donation->status == 'failed' || $donation->status == 'expired'
                            ? 'bg-red-800'
                            : ($donation->status == 'pending'
                                ? 'bg-orange-500'
                                : ($donation->status == 'paid'
                                    ? 'bg-green-800'
                                    : ''
                                )
                            ) }}">
                                                </div>
                                                <p class="p-0 m-0">
                                                    {{ $donation->status == "paid" ? "Dibayar" : "Belum Dibayar" }}
                                                </p>
                                            </div>
                                        </td>
                                        <td class="font-normal p-2 text-center font-medium">
                                            @if($donation->status != "paid")
                                            <a href="{{ route("member_kas_pay", $donation["id"]) }}">
                                                <button class="p-2 px-4 rounded-md bg-green-800 font-semibold text-white hover:bg-green-700 w-max">
                                                    Bayar Di Sini
                                                </button>
                                            </a>
                                            @else
                                            <p>-</p>
                                            @endif
                                        </td>
                                    </tr>
                        @endforeach
                    </tbody>
                </table>
                @if(count($donations) == 0)
                    <p class="text-sm text-center text-gray-700">Belum Ada Donasi</p>
                @endif
            </div>
        </div>
    </div>
@endsection
