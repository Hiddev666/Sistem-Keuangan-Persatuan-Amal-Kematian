@extends('layouts.admin')

@section('title', 'Kas Bulanan | Sistem Keuangan Persatuan Amal Kematian')

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

        <h1 class="text-2xl font-bold">Pemberian Santunan</h1>

        <div class="mt-5">
            <form action="{{ route("admin_duka_confirm")}}" method="post" id="form_update">
                @csrf
                <div class="grid grid-cols-2 gap-3">
                    <div class="hidden">
                        <label for="member_id" class="text-gray-600 text-sm">Anggota</label>
                        <input type="text" id="id" name="id" value="{{ old('id') ?? $death_event->id}}"
                            class="px-3 py-2 text-sm w-full border border-gray-300 rounded-md">
                    </div>
                    <div>
                        <label for="amount" class="text-gray-600 text-sm">Nominal Santunan</label>
                        <input type="number" id="amount" name="amount"
                            class="px-3 py-2 text-sm w-full border border-gray-300 rounded-md" required>
                    </div>
                    <div></div>
                    <div class="flex items-center gap-2">
                        <button type="submit"
                            class="px-8 py-2 flex items-center gap-1 bg-green-800 text-sm font-semibold rounded-md text-white transition-all duration-200 ease-in-out hover:bg-green-700">
                            <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" class="w-5 h-5">
                                <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                                <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
                                <g id="SVGRepo_iconCarrier">
                                    <path
                                        d="M17 20.75H7C6.27065 20.75 5.57118 20.4603 5.05546 19.9445C4.53973 19.4288 4.25 18.7293 4.25 18V6C4.25 5.27065 4.53973 4.57118 5.05546 4.05546C5.57118 3.53973 6.27065 3.25 7 3.25H14.5C14.6988 3.25018 14.8895 3.32931 15.03 3.47L19.53 8C19.6707 8.14052 19.7498 8.33115 19.75 8.53V18C19.75 18.7293 19.4603 19.4288 18.9445 19.9445C18.4288 20.4603 17.7293 20.75 17 20.75ZM7 4.75C6.66848 4.75 6.35054 4.8817 6.11612 5.11612C5.8817 5.35054 5.75 5.66848 5.75 6V18C5.75 18.3315 5.8817 18.6495 6.11612 18.8839C6.35054 19.1183 6.66848 19.25 7 19.25H17C17.3315 19.25 17.6495 19.1183 17.8839 18.8839C18.1183 18.6495 18.25 18.3315 18.25 18V8.81L14.19 4.75H7Z"
                                        fill="#ffffff"></path>
                                    <path
                                        d="M16.75 20H15.25V13.75H8.75V20H7.25V13.5C7.25 13.1685 7.3817 12.8505 7.61612 12.6161C7.85054 12.3817 8.16848 12.25 8.5 12.25H15.5C15.8315 12.25 16.1495 12.3817 16.3839 12.6161C16.6183 12.8505 16.75 13.1685 16.75 13.5V20Z"
                                        fill="#ffffff"></path>
                                    <path
                                        d="M12.47 8.75H8.53001C8.3606 8.74869 8.19311 8.71403 8.0371 8.64799C7.88109 8.58195 7.73962 8.48582 7.62076 8.36511C7.5019 8.24439 7.40798 8.10144 7.34437 7.94443C7.28075 7.78741 7.24869 7.61941 7.25001 7.45V4H8.75001V7.25H12.25V4H13.75V7.45C13.7513 7.61941 13.7193 7.78741 13.6557 7.94443C13.592 8.10144 13.4981 8.24439 13.3793 8.36511C13.2604 8.48582 13.1189 8.58195 12.9629 8.64799C12.8069 8.71403 12.6394 8.74869 12.47 8.75Z"
                                        fill="#ffffff"></path>
                                </g>
                            </svg>
                            Simpan
                        </button>
                        <a href="{{ route("admin_duka") }}">
                            <button type="button"
                                class="px-5 py-2 flex items-center gap-1 bg-gray-200 border border-gray-300 text-sm font-semibold rounded-md transition-all duration-200 ease-in-out hover:bg-gray-300">
                                Batal
                            </button>
                        </a>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection
