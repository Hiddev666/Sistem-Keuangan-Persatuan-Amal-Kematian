@extends('layouts.admin')

@section('title', 'Anggota | Sistem Keuangan Persatuan Amal Kematian')

@section('content')
    <div class="mb-6">
        <h1 class="text-2xl font-bold">Anggota</h1>
        <div class="mt-5 flex flex-col gap-5">
            <div class="w-full flex justify-between items-center">
                <a href="{{ route("admin_anggota_add") }}">
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
                        Daftarkan Anggota Baru</button>
                </a>
                <div class="flex items-center gap-3">
                    <div class="flex items-center gap-2">
                        <input type="text" id="username" name="username"
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
                    <button
                        class="flex items-center gap-2 text-sm border border-gray-300 py-2 px-3 rounded-md transition-all duration-200 ease-in-out hover:bg-gray-100">
                        Filter
                        <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" class="w-5 h-5">
                            <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                            <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
                            <g id="SVGRepo_iconCarrier">
                                <path d="M4 7H20" stroke="#303030" stroke-width="2" stroke-linecap="round"
                                    stroke-linejoin="round"></path>
                                <path d="M7 12L17 12" stroke="#303030" stroke-width="2" stroke-linecap="round"
                                    stroke-linejoin="round"></path>
                                <path d="M11 17H13" stroke="#303030" stroke-width="2" stroke-linecap="round"
                                    stroke-linejoin="round"></path>
                            </g>
                        </svg>
                    </button>
                </div>
            </div>
            <table class="text-sm w-full">
                <thead class="bg-gray-100 border border-gray-300">
                    <th class="font-normal p-3 text-left">NIK</th>
                    <th class="font-normal p-3 text-left">Nama</th>
                    <th class="font-normal p-3 text-left">Nomor Telepon</th>
                    <th class="font-normal p-3 text-center">Status Anggota</th>
                    <th class="font-normal p-3 text-right">Action</th>
                </thead>
                <tbody>
                    @foreach ($members as $member)
                        <tr
                            class="border-b border-gray-200 transition-all ease-in-out {{ $member["status"] == "aktif" ? "" : "bg-gray-100" }}">
                            <td class="font-normal p-3 text-left font-semibold">{{ $member["id"] }}</td>
                            <td class="font-normal p-3 text-left font-medium">{{ $member["name"] }}</td>
                            <td class="font-normal p-3 text-left font-medium">{{ $member["phone"] }}</td>
                            <td class="font-normal p-3 text-center font-medium flex justify-center items-center gap-1">
                                <div
                                    class="w-3 h-3 rounded-full {{ $member["status"] == "aktif" ? "bg-green-800" : "bg-red-800" }}">
                                </div>
                                <p class="">
                                    {{ ucfirst($member["status"]) }}
                                </p>
                            </td>
                            <td class="font-normal p-3 text-right font-medium">
                                <div class="flex items-center justify-end gap-1">
                                    <button class="p-2 border border-gray-200 rounded-md bg-white hover:bg-gray-200">
                                        <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" class="w-4 h-4">
                                            <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                                            <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
                                            <g id="SVGRepo_iconCarrier">
                                                <path fill-rule="evenodd" clip-rule="evenodd"
                                                    d="M12 9C10.3431 9 9 10.3431 9 12C9 13.6569 10.3431 15 12 15C13.6569 15 15 13.6569 15 12C15 10.3431 13.6569 9 12 9ZM11 12C11 11.4477 11.4477 11 12 11C12.5523 11 13 11.4477 13 12C13 12.5523 12.5523 13 12 13C11.4477 13 11 12.5523 11 12Z"
                                                    fill="#303030"></path>
                                                <path fill-rule="evenodd" clip-rule="evenodd"
                                                    d="M21.83 11.2807C19.542 7.15186 15.8122 5 12 5C8.18777 5 4.45796 7.15186 2.17003 11.2807C1.94637 11.6844 1.94361 12.1821 2.16029 12.5876C4.41183 16.8013 8.1628 19 12 19C15.8372 19 19.5882 16.8013 21.8397 12.5876C22.0564 12.1821 22.0536 11.6844 21.83 11.2807ZM12 17C9.06097 17 6.04052 15.3724 4.09173 11.9487C6.06862 8.59614 9.07319 7 12 7C14.9268 7 17.9314 8.59614 19.9083 11.9487C17.9595 15.3724 14.939 17 12 17Z"
                                                    fill="#303030"></path>
                                            </g>
                                        </svg>
                                    </button>
                                    <button class="p-2 border border-gray-200 rounded-md bg-white hover:bg-gray-200">
                                        <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" class="w-4 h-4">
                                            <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                                            <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
                                            <g id="SVGRepo_iconCarrier">
                                                <path d="M18 10L21 7L17 3L14 6M18 10L8 20H4V16L14 6M18 10L14 6" stroke="#303030"
                                                    stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                                            </g>
                                        </svg>
                                    </button>
                                    <button class="p-2 border border-gray-200 rounded-md bg-white hover:bg-gray-200">
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
                    @endforeach
                </tbody>
            </table>
        </div>
        @if (count($members) <= 0)
            <div class="w-full flex justify-center items-center">
                <div class="mt-4 rounded-md border border-green-200 bg-green-100 py-2 px-4 text-sm text-green-700 w-fit">
                    <p class="text-center text-sm">Maaf, Data Tidak Tersedia</p>
                </div>
            </div>
        @endif
    </div>
@endsection
