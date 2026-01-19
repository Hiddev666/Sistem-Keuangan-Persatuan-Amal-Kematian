<nav class="border border-b-gray-300">
    <div class="p-3 px-9 flex items-center justify-between">
        <div class="flex items-center gap-2">
            <img src="{{ asset('img/logo.svg') }}" alt="Logo" class="w-9 h-9">
            <div class="leading-tight">
                <div class="text-sm font-semibold">Sistem Keuangan</div>
                <div class="text-sm text-gray-600">Persatuan Amal Kematian</div>
            </div>
        </div>
        <a href="{{ route("sign-in") }}">
            <button
                class="px-3 py-2 flex items-center gap-1 bg-green-800 text-sm font-semibold rounded-md text-white transition-all duration-200 ease-in-out hover:bg-green-700">
                <svg fill="#FFFFFF" viewBox="0 0 256 256" id="Flat" xmlns="http://www.w3.org/2000/svg" class="w-5 h-5">
                    <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                    <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
                    <g id="SVGRepo_iconCarrier">
                        <path
                            d="M144.48633,136.48438l-41.98926,42a12.0001,12.0001,0,0,1-16.97266-16.96875L107.03467,140H24a12,12,0,0,1,0-24h83.03467L85.52441,94.48438a12.0001,12.0001,0,0,1,16.97266-16.96875l41.98926,42A12.00093,12.00093,0,0,1,144.48633,136.48438ZM192,28H136a12,12,0,0,0,0,24h52V204H136a12,12,0,0,0,0,24h56a20.02229,20.02229,0,0,0,20-20V48A20.02229,20.02229,0,0,0,192,28Z">
                        </path>
                    </g>
                </svg>
                Sign In</button>
        </a>
    </div>
</nav>
