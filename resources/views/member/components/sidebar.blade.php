<aside class="w-full border-b border-gray-200 bg-white flex justify-between items-center px-5 md:px-9 text-sm">
    <div class="py-4 md:px-8">
        <div class="flex items-center gap-2">
            <img src="{{ asset('img/logo.svg') }}" alt="Logo" class="w-9 h-9">
            <div class="leading-tight hidden md:block">
                <div class="text-sm font-semibold">Sistem Keuangan</div>
                <div class="text-sm text-gray-600">Persatuan Amal Kematian</div>
            </div>
        </div>
    </div>
    <div class="flex items-center gap-5">
        <div class="flex items-center gap-5">
            <a href="{{ route("member_dashboard") }}">
                <p>Beranda</p>
            </a>
            <a href="{{ route("member_kas") }}">
                <p>Pembayaran</p>
            </a>
        </div>
        <form action="{{ route('logout') }}" method="post">
            @csrf
            <button type="submit"
                class="w-8 h-8 rounded-md bg-green-800 text-white flex items-center justify-center hover:bg-green-700">
                <span class="sr-only">Logout</span>
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-5 h-5">
                    <path fill-rule="evenodd"
                        d="M7.5 3.75A3.75 3.75 0 0 0 3.75 7.5v9a3.75 3.75 0 0 0 3.75 3.75h4.5a.75.75 0 0 0 0-1.5H7.5a2.25 2.25 0 0 1-2.25-2.25v-9A2.25 2.25 0 0 1 7.5 5.25H12a.75.75 0 0 0 0-1.5H7.5Z"
                        clip-rule="evenodd" />
                    <path fill-rule="evenodd"
                        d="M16.72 7.72a.75.75 0 0 1 1.06 0l3 3a.75.75 0 0 1 0 1.06l-3 3a.75.75 0 1 1-1.06-1.06l1.72-1.72H9.75a.75.75 0 0 1 0-1.5h8.69l-1.72-1.72a.75.75 0 0 1 0-1.06Z"
                        clip-rule="evenodd" />
                </svg>
            </button>
        </form>
    </div>
</aside>
