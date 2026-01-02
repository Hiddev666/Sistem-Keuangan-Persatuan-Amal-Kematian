<aside class="w-72 shrink-0 border-r border-gray-200 bg-white min-h-screen flex flex-col">
    <div class="fixed w-72 h-screen flex flex-col">
        <div class="p-6">
            <div class="flex items-center gap-2">
                <img src="{{ asset('img/logo.svg') }}" alt="Logo" class="w-9 h-9">
                <div class="leading-tight">
                    <div class="text-sm font-semibold">Sistem Keuangan</div>
                    <div class="text-sm text-gray-600">Persatuan Amal Kematian</div>
                </div>
            </div>
        </div>

        <nav class="px-4 mt-3">
            @php
                $linkBase = 'flex items-center gap-3 px-4 py-3 rounded-md text-sm font-medium transition-colors';
                $linkActive = 'bg-green-800 text-white';
                $linkInactive = 'text-gray-700 hover:bg-gray-100';
            @endphp

            <a href="{{ route('admin_dashboard') }}"
                class="{{ $linkBase }} {{ request()->routeIs('admin_dashboard') ? $linkActive : $linkInactive }}">
                <span>Dashboard</span>
            </a>

            <a href="{{ route('admin_keanggotaan') }}"
                class="{{ $linkBase }} {{ request()->routeIs(['admin_keanggotaan', 'admin_keanggotaan_add', 'admin_anggota', 'admin_anggota_add', 'admin_anggota_edit']) ? $linkActive : $linkInactive }} mt-1">
                <span>Keanggotaan</span>
            </a>

            <a href="{{ route('admin_kas') }}"
                class="{{ $linkBase }} {{ request()->routeIs(['admin_kas', 'admin_kas_add', 'admin_kas_edit']) ? $linkActive : $linkInactive }} mt-1">
                <span>Kas Bulanan</span>
            </a>

            <a href="{{ route('admin_sumbangan') }}"
                class="{{ $linkBase }} {{ request()->routeIs(['admin_sumbangan', 'admin_sumbangan_add', 'admin_sumbangan_edit']) ? $linkActive : $linkInactive }} mt-1">
                <span>Sumbangan</span>
            </a>

        </nav>

        <div class="mt-auto p-4">
            <div class="flex items-center justify-between gap-3">
                <div>
                    <div class="text-sm font-semibold text-gray-900">
                        {{ auth()->user()->name ?? 'User' }}
                    </div>
                    <div class="text-sm text-gray-500">
                        {{ ucfirst(auth()->user()->role ?? '') }}
                    </div>
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
        </div>
    </div>
</aside>
