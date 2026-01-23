@extends('layouts.admin')

@section('title', 'Sumbangan | Sistem Keuangan Persatuan Amal Kematian')

@section('content')
    <div class="mb-6">
        <div class="fixed w-full h-screen bg-black bg-opacity-50 left-0 top-0 flex justify-center items-center hidden"
            id="delete-popup">
            <div class="bg-white border border-gray-300 p-5 w-fit rounded-md flex flex-col items-center gap-3">
                <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" class="w-20 h-20 mb-5">
                    <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                    <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
                    <g id="SVGRepo_iconCarrier">
                        <circle cx="12" cy="17" r="1" fill="#909090"></circle>
                        <path d="M12 10L12 14" stroke="#909090" stroke-width="2" stroke-linecap="round"
                            stroke-linejoin="round"></path>
                        <path
                            d="M3.44722 18.1056L10.2111 4.57771C10.9482 3.10361 13.0518 3.10362 13.7889 4.57771L20.5528 18.1056C21.2177 19.4354 20.2507 21 18.7639 21H5.23607C3.7493 21 2.78231 19.4354 3.44722 18.1056Z"
                            stroke="#909090" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
                    </g>
                </svg>
                <p class="text-sm">Yakin ingin menghapus data ini?</p>
                <div class="w-full flex flex-col gap-1">
                    <button class="py-2 px-3 bg-green-800 w-full rounded font-semibold text-white text-sm" id="btn-delete">
                        Yakin
                    </button>
                    <button class="py-2 px-3 bg-gray-300 border border-gray-400 w-full rounded font-semibold text-sm"
                        id="delete-cancel" onclick="closeDeletePopup()">
                        Batal
                    </button>
                </div>
            </div>
        </div>

        <h1 class="text-2xl font-bold">Sumbangan</h1>

        <div class="mt-5 flex flex-col gap-5">
            @if (session('success'))
                <div class="mb-4 rounded-md border border-green-200 bg-green-50 p-3 text-sm text-green-700" id="success-flash"
                    onshow="flash()">
                    <p class="text-sm text-green-600">{{ session("success") }}</p>
                </div>
            @endif
            <div class="w-full flex justify-between items-center">
                <a href="{{ route("admin_sumbangan_add") }}">
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
                        Tambahkan Sumbangan</button>
                </a>
                <div class="flex items-center gap-3">
                    <div class="flex items-center gap-2">
                        <input type="text" id="search" name="search"
                            class="px-3 py-2 text-sm w-full border border-gray-300 rounded-md">
                        <button
                            class="bg-green-800 rounded-md p-3 flex justify-center items-center transition-all duration-200 ease-in-out hover:bg-green-700">
                            <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" class="w-4 h-4">
                                <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                                <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
                                <g id="SVGRepo_iconCarrier">
                                    <path
                                        d="M15.7955 15.8111L21 21M18 10.5C18 14.6421 14.6421 18 10.5 18C6.35786 18 3 14.6421 3 10.5C3 6.35786 6.35786 3 10.5 3C14.6421 3 18 6.35786 18 10.5Z"
                                        stroke="#ffffff" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    </path>
                                </g>
                            </svg>
                        </button>
                    </div>
                    <form action="{{ route("admin_sumbangan") }}" method="get">
                        <select onchange="this.form.submit()" name="period"
                            class="flex items-center gap-2 text-sm border border-gray-300 py-2 px-3 rounded-md transition-all duration-200 ease-in-out hover:bg-gray-100">
                            @for ($i = 0; $i < 12; $i++)
                                @php
                                    $date = now()->subMonths($i);
                                    $value = $date->format('Y-m'); // 2025-01
                                @endphp

                                <option value="{{ $value }}" {{ request('period') == $value ? 'selected' : '' }} {{ request('period') == $value ? 'selected' : '' }}>
                                    {{ $date->locale('id')->translatedFormat('F Y') }}
                                </option>
                            @endfor
                        </select>
                    </form>
                </div>
            </div>
            <table class="text-sm w-full">
                <thead class="bg-gray-100 border border-gray-300">
                    <th class="font-normal p-3 text-left">Nama</th>
                    <th class="font-normal p-3 text-left">Keanggotaan</th>
                    <th class="font-normal p-3 text-left">Nominal</th>
                    <th class="font-normal p-3 text-center">Status Pembayaran</th>
                    <th class="font-normal p-3 text-right">Action</th>
                </thead>
                <tbody id="result">
                    @foreach ($donations as $donation)
                                <tr class="border-b border-gray-200 transition-all ease-in-out">
                                    <td class="font-normal p-2 text-left font-semibold">
                                        {{ $donation->family_card->head->name ?? $donation->donor_name }}
                                    </td>
                                    <td class="font-normal p-2 text-left">
                                        {{ $donation->donor_name ? "Non Anggota" : "Anggota"}}
                                    </td>
                                    <td class="font-normal p-2 text-left font-medium">{{ rupiah($donation->amount) }}</td>
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
                                                {{ ucfirst($donation->status) }}
                                            </p>
                                        </div>
                                    </td>
                                    @if($donation->status != "paid")
                                        <td class="font-normal p-2 text-right font-medium">
                                            <div class="flex items-center justify-end gap-1">
                                                <a href="{{ route("admin_sumbangan_edit", $donation["id"]) }}">
                                                    <button class="p-2 border border-gray-200 rounded-md bg-white hover:bg-gray-200">
                                                        <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"
                                                            class="w-4 h-4">
                                                            <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                                                            <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round">
                                                            </g>
                                                            <g id="SVGRepo_iconCarrier">
                                                                <path d="M18 10L21 7L17 3L14 6M18 10L8 20H4V16L14 6M18 10L14 6"
                                                                    stroke="#303030" stroke-width="1.5" stroke-linecap="round"
                                                                    stroke-linejoin="round"></path>
                                                            </g>
                                                        </svg>
                                                    </button>
                                                </a>
                                                <button class="p-2 border border-gray-200 rounded-md bg-white hover:bg-gray-200"
                                                    onclick="showDeletePopup('{{ $donation['id'] }}', this, 'sumbangan/delete')">
                                                    <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" class="w-4 h-4">
                                                        <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                                                        <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
                                                        <g id="SVGRepo_iconCarrier">
                                                            <path
                                                                d="M18 6L17.1991 18.0129C17.129 19.065 17.0939 19.5911 16.8667 19.99C16.6666 20.3412 16.3648 20.6235 16.0011 20.7998C15.588 21 15.0607 21 14.0062 21H9.99377C8.93927 21 8.41202 21 7.99889 20.7998C7.63517 20.6235 7.33339 20.3412 7.13332 19.99C6.90607 19.5911 6.871 19.065 6.80086 18.0129L6 6M4 6H20M16 6L15.7294 5.18807C15.4671 4.40125 15.3359 4.00784 15.0927 3.71698C14.8779 3.46013 14.6021 3.26132 14.2905 3.13878C13.9376 3 13.523 3 12.6936 3H11.3064C10.477 3 10.0624 3 9.70951 3.13878C9.39792 3.26132 9.12208 3.46013 8.90729 3.71698C8.66405 4.00784 8.53292 4.40125 8.27064 5.18807L8 6M14 10V17M10 10V17"
                                                                stroke="#303030" stroke-width="2" stroke-linecap="round"
                                                                stroke-linejoin="round"></path>
                                                        </g>
                                                    </svg>
                                                </button>
                                            </div>
                                        </td>
                                    @endif
                                </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        @if (count($donations) <= 0)
            <div class="w-full flex justify-center items-center">
                <div class="mt-4 rounded-md border border-green-200 bg-green-100 py-2 px-4 text-sm text-green-700 w-fit">
                    <p class="text-center text-sm">Maaf, Data Tidak Tersedia</p>
                </div>
            </div>
        @endif
    </div>

    <script>
        let timeout = null;
        const input = document.getElementById('search');
        const result = document.getElementById('result');

        function formatYMIndonesia(date = new Date()) {
            return new Intl.DateTimeFormat('en-CA', {
                timeZone: 'Asia/Jakarta',
                year: 'numeric',
                month: '2-digit'
            }).format(date);
        }

        function rupiah(angka) {
            return 'Rp ' + Number(angka).toLocaleString('id-ID');
        }

        input.addEventListener('keyup', function () {
            clearTimeout(timeout);

            timeout = setTimeout(() => {
                const keyword = this.value;
                const urlParams = new URLSearchParams(window.location.search);
                const today = formatYMIndonesia();
                const period = urlParams.get('period') ?? today;
                fetch(`{{ route('admin_sumbangan_search') }}?q=${encodeURIComponent(keyword)}&period=${period}`)
                    .then(response => response.json())
                    .then(data => {
                        let html = '';

                        if (data.length === 0) {
                            html = `<li class="text-gray-500">Data tidak ditemukan</li>`;
                        } else {
                            data.forEach(member => {
                                console.log(member)
                                html += `
                                                                            <tr class="border-b border-gray-200 transition-all ease-in-out">
                                                                                <td class="font-normal p-2 text-left font-semibold">${member["member"]["id"]}</td>
                                                                                <td class="font-normal p-2 text-left font-semibold">${member["member"]["name"]}</td>
                                                                                <td class="font-normal p-2 text-left font-medium">${rupiah(member["amount"])}</td>
                                                                                <td class="font-normal p-2 text-center font-medium align-middle">
                                                                                    <div class="flex items-center gap-1 justify-center">
                                                                                        <div class="w-3 h-3 rounded-full ${member["status"] === "failed" || member["status"] === "expired"
                                        ? "bg-red-800"
                                        : member["status"] === "pending"
                                            ? "bg-orange-500"
                                            : member["status"] === "paid"
                                                ? "bg-green-800"
                                                : ""
                                    }
                                        ">
                                                                                        </div>
                                                                                        <p class="p-0 m-0">
                                                                                            ${member["status"].charAt(0).toUpperCase() + member["status"].slice(1)}
                                                                                        </p>
                                                                                    </div>
                                                                                </td>
                                                                                <td class="font-normal p-2 text-center font-semibold">${member["period"]}</td>
                                                                            <td class="font-normal p-2 text-right font-medium">
                                                            <div class="flex items-center justify-end gap-1">
                                                                <a href="kas/edit/${member["id"]}">
                                                                    <button class="p-2 border border-gray-200 rounded-md bg-white hover:bg-gray-200">
                                                                        <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"
                                                                            class="w-4 h-4">
                                                                            <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                                                                            <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round">
                                                                            </g>
                                                                            <g id="SVGRepo_iconCarrier">
                                                                                <path d="M18 10L21 7L17 3L14 6M18 10L8 20H4V16L14 6M18 10L14 6"
                                                                                    stroke="#303030" stroke-width="1.5" stroke-linecap="round"
                                                                                    stroke-linejoin="round"></path>
                                                                            </g>
                                                                        </svg>
                                                                    </button>
                                                                </a>
                                                                <button class="p-2 border border-gray-200 rounded-md bg-white hover:bg-gray-200"
                                                                    onclick="showDeletePopup('${member["id"]}', this, 'kas/delete')">
                                                                    <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" class="w-4 h-4">
                                                                        <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                                                                        <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
                                                                        <g id="SVGRepo_iconCarrier">
                                                                            <path
                                                                                d="M18 6L17.1991 18.0129C17.129 19.065 17.0939 19.5911 16.8667 19.99C16.6666 20.3412 16.3648 20.6235 16.0011 20.7998C15.588 21 15.0607 21 14.0062 21H9.99377C8.93927 21 8.41202 21 7.99889 20.7998C7.63517 20.6235 7.33339 20.3412 7.13332 19.99C6.90607 19.5911 6.871 19.065 6.80086 18.0129L6 6M4 6H20M16 6L15.7294 5.18807C15.4671 4.40125 15.3359 4.00784 15.0927 3.71698C14.8779 3.46013 14.6021 3.26132 14.2905 3.13878C13.9376 3 13.523 3 12.6936 3H11.3064C10.477 3 10.0624 3 9.70951 3.13878C9.39792 3.26132 9.12208 3.46013 8.90729 3.71698C8.66405 4.00784 8.53292 4.40125 8.27064 5.18807L8 6M14 10V17M10 10V17"
                                                                                stroke="#303030" stroke-width="2" stroke-linecap="round"
                                                                                stroke-linejoin="round"></path>
                                                                        </g>
                                                                    </svg>
                                                                </button>
                                                            </div>
                                                        </td>
                                                                                </tr>
                                                                            `;
                            });
                        }

                        result.innerHTML = html;
                    })
                    .catch(error => {
                        console.error(error);
                    });

            }, 300); // ⏱ debounce 300ms
        });
    </script>
@endsection
