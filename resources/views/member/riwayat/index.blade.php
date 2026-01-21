@extends('layouts.member')

@section('title', 'Dashboard | Sistem Keuangan Persatuan Amal Kematian')

@section('content')
    <div class="mt-5 mb-8 py-4 px-0 md:px-8 flex flex-col gap-5">
        <div class="">
            <h1 class="text-3xl font-semibold">
                Riwayat
            </h1>
        </div>

        <table class="text-sm w-full">
            <thead class="bg-gray-100 border border-gray-300">
                <th class="font-normal p-3 text-start">Tanggal</th>
                <th class="font-normal p-3 text-start">Jenis Transaksi</th>
                <th class="font-normal p-3 text-start">Nominal</th>
                <th class="font-normal p-3 text-start">Deskripsi</th>
            </thead>
            <tbody id="result">
                @foreach ($histories as $history)
                            <tr class="border-b border-gray-200 transition-all ease-in-out">
                                <td class="font-normal p-2 text-start font-semibold w-max">{{ formatTanggalIndonesia($history->created_at) }}</td>
                                <td class="font-normal p-2 text-start font-semibold w-max">
                                    @if ($history->reference_type == "donation")
                                        Donasi
                                    @elseif ($history->reference_type == "contribution")
                                        Tagihan Duka
                                    @elseif ($history->reference_type == "registration")
                                        Registrasi
                                    @endif
                                </td>
                                <td class="font-normal p-2 text-start font-semibold w-max">{{ rupiah($history->amount) }}</td>
                                <td class="font-normal p-2 text-start font-semibold w-max">{{ $history->description }}</td>
                            </tr>
                @endforeach
            </tbody>
        </table>
        </div>
    </div>
@endsection
