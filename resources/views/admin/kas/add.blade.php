@extends('layouts.admin')

@section('title', 'Generate Kas | Sistem Keuangan Persatuan Amal Kematian')

@section('content')
    <div class="mb-6">
        <h1 class="text-2xl font-bold">{{ isset($contribution) ? "Edit" : "Generate" }} Kas</h1>

        <div class="mt-5">
            @error('nik')
                <div class="mb-4 rounded-md border border-red-200 bg-red-50 p-3 text-sm text-red-700">
                    <p class="text-sm text-red-600">{{ $message }}</p>
                </div>
            @enderror
            @error('error')
                <div class="mb-4 rounded-md border border-red-200 bg-red-50 p-3 text-sm text-red-700">
                    <p class="text-sm text-red-600">{{ $message }}</p>
                </div>
            @enderror
            @if (isset($contribution))
                <form action="{{ route("admin_kas_update")}}" method="post" id="form_update">
                    @csrf
                    <div class="grid grid-cols-2 gap-3">
                        <div class="hidden">
                            <label for="member_id" class="text-gray-600 text-sm">Anggota</label>
                            <input type="text" id="id" name="id"
                                value="{{ old('id') ?? $contribution->id}}"
                                class="px-3 py-2 text-sm w-full border border-gray-300 rounded-md">
                        </div>
                        <div>
                            <label for="member_id" class="text-gray-600 text-sm">Anggota</label>
                            <input type="text" id="member_id" name="member_id"
                                value="{{ old('member_id') ?? $contribution->member->id . " - " . $contribution->member->name }}"
                                class="px-3 py-2 text-sm w-full border border-gray-300 rounded-md" required {{ isset($contribution->id) ? "readonly" : "" }}>
                        </div>
                        <div>
                            <label for="amount" class="text-gray-600 text-sm">Nominal</label>
                            <input type="number" id="amount" name="amount" value="{{ old('amount') ?? $contribution->amount}}"
                                class="px-3 py-2 text-sm w-full border border-gray-300 rounded-md" required>
                        </div>
                        <div>
                            <label for="status" class="text-gray-600 text-sm">Status</label>
                            <select name="status" id="status"
                                class="px-3 py-2 text-sm w-full border border-gray-300 rounded-md bg-white">
                                @if (isset($contribution->status))
                                    <option value="{{ $contribution->status }}">{{ ucfirst($contribution->status) }}</option>
                                @endif
                                <option value="pending">Pending</option>
                                <option value="paid">Paid</option>
                            </select>
                        </div>
                        <div>
                            <div id="input-anggota-kas" class="hidden">
                                <label for="members" class="text-gray-600 text-sm">Pilih Anggota</label>
                                <div class="text-sm w-full relative">
                                    <div class="flex items-center gap-2">
                                        <input type="text" id="search" name="search"
                                            class="px-3 py-2 text-sm w-full border border-gray-300 rounded-md">
                                    </div>
                                    <div id="result"
                                        class="mt-2 border border-gray-300 p-2 absolute w-fit bg-white rounded-md flex flex-col gap-1 hidden">
                                    </div>
                                    <div id="selected" class="mt-2 flex flex-col gap-1">
                                    </div>
                                    <div id="test_selected" class="mt-2 flex flex-col gap-1">
                                    </div>
                                </div>
                            </div>
                        </div>
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
                            <a href="{{ route("admin_kas") }}">
                                <button type="button"
                                    class="px-5 py-2 flex items-center gap-1 bg-gray-200 border border-gray-300 text-sm font-semibold rounded-md transition-all duration-200 ease-in-out hover:bg-gray-300">
                                    Batal
                                </button>
                            </a>
                        </div>
                    </div>
                </form>
            @else
                <form action="{{ route("admin_kas_create")}}" method="post" id="form_add">
                    @csrf
                    <div class="grid grid-cols-2 gap-3">
                        <div>
                            <label for="period" class="text-gray-600 text-sm">Periode</label>
                            <input type="month" id="period" name="period" value="{{ old('period') }}"
                                class="px-3 py-2 text-sm w-full border border-gray-300 rounded-md" required {{ isset($member->id) ? "readonly" : "" }}>
                        </div>
                        <div>
                            <label for="amount" class="text-gray-600 text-sm">Nominal</label>
                            <input type="number" id="amount" name="amount" value="{{ old('amount')}}"
                                class="px-3 py-2 text-sm w-full border border-gray-300 rounded-md" required>
                        </div>
                        <div>
                            <label for="name" class="text-gray-600 text-sm">Untuk</label>
                            <div class="flex gap-5">
                                <div class="flex items-center gap-1" onchange="hideInputAnggotaKas()">
                                    <input type="radio" id="for_all" name="for" checked>
                                    <label for="for_all" class="text-sm">Semua Anggota Aktif</label>
                                </div>
                                <div class="flex items-center gap-2">
                                    <input type="radio" id="for_select" name="for" onchange="showInputAnggotaKas()">
                                    <label for="for_select" class="text-sm">Anggota Tertentu</label>
                                </div>
                            </div>
                        </div>
                        <div>
                            <div id="input-anggota-kas" class="hidden">
                                <label for="members" class="text-gray-600 text-sm">Pilih Anggota</label>
                                <div class="text-sm w-full relative">
                                    <div class="flex items-center gap-2">
                                        <input type="text" id="search" name="search"
                                            class="px-3 py-2 text-sm w-full border border-gray-300 rounded-md">
                                    </div>
                                    <div id="result"
                                        class="mt-2 border border-gray-300 p-2 absolute w-fit bg-white rounded-md flex flex-col gap-1 hidden">
                                    </div>
                                    <div id="selected" class="mt-2 flex flex-col gap-1">
                                    </div>
                                    <div id="test_selected" class="mt-2 flex flex-col gap-1">
                                    </div>
                                </div>
                            </div>
                        </div>
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
                            <a href="{{ route("admin_kas") }}">
                                <button type="button"
                                    class="px-5 py-2 flex items-center gap-1 bg-gray-200 border border-gray-300 text-sm font-semibold rounded-md transition-all duration-200 ease-in-out hover:bg-gray-300">
                                    Batal
                                </button>
                            </a>
                        </div>
                    </div>
                </form>
            @endif
        </div>
    </div>

    <script>
        let timeout = null;
        const input = document.getElementById('search');
        const result = document.getElementById('result');
        const selected = document.getElementById('selected');
        const testSelected = document.getElementById('test_selected');
        const formAdd = document.getElementById('form_add');
        let selectedMembers = []

        formAdd.addEventListener("submit", async (e) => {
            e.preventDefault()

            const period = document.getElementById('period').value
            const amount = document.getElementById('amount').value

            fetch('/admin/kas/create', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                },
                body: JSON.stringify({
                    items: {
                        period,
                        amount,
                        members: selectedMembers
                    }
                })
            }).then(res => res.json())
                .then(data => {
                    if (data.redirect) {
                        window.location.href = data.redirect;
                    }
                });
        })

        function removeSelected(id) {
            selectedMembers = selectedMembers.filter(item => item.id !== `${id}`);
            console.log(selectedMembers)
            render(selectedMembers)
        }

        function test(id, name) {
            selectedMembers.push({ id, name })
            let member = selectedMembers[selectedMembers.length - 1]
            console.log(selectedMembers)
            render(selectedMembers)
        }

        function render(members) {
            let tempSelected = ""
            members.map((member) => {
                tempSelected += `
                    <div class="border border-gray-300 bg-white p-2 flex items-center gap-5 justify-between rounded">
                        <p>${member["id"]} - ${member["name"]}</p>
                            <button
                                type='button'
                                onclick="removeSelected(${member["id"]})"
                                class="p-2 flex items-center gap-1 bg-gray-200 border border-gray-300 text-sm font-semibold rounded-md text-white transition-all duration-200 ease-in-out hover:bg-gray-100">
                                <svg viewBox="0 0 24 24" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" fill="#000000" class="w-4 h-4"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <title>cancel</title> <desc>Created with Sketch.</desc> <g id="icons" stroke="none" stroke-width="1" fill="none" fill-rule="evenodd"> <g id="ui-gambling-website-lined-icnos-casinoshunter" transform="translate(-2168.000000, -158.000000)" fill="#303030" fill-rule="nonzero"> <g id="1" transform="translate(1350.000000, 120.000000)"> <path d="M821.426657,38.5856848 L830.000001,47.1592624 L838.573343,38.5856848 C839.288374,37.8706535 840.421422,37.8040611 841.267835,38.4653242 L841.414315,38.5987208 C842.195228,39.3796338 842.195228,40.645744 841.414306,41.4266667 L832.840738,50 L841.414315,58.5733429 C842.129347,59.2883742 842.195939,60.4214224 841.534676,61.2678347 L841.401279,61.4143152 C840.620366,62.1952283 839.354256,62.1952283 838.573333,61.4143055 L830.000001,52.8407376 L821.426657,61.4143152 C820.711626,62.1293465 819.578578,62.1959389 818.732165,61.5346758 L818.585685,61.4012792 C817.804772,60.6203662 817.804772,59.354256 818.585694,58.5733333 L827.159262,50 L818.585685,41.4266571 C817.870653,40.7116258 817.804061,39.5785776 818.465324,38.7321653 L818.598721,38.5856848 C819.379634,37.8047717 820.645744,37.8047717 821.426657,38.5856848 Z M820.028674,60.999873 C820.023346,60.9999577 820.018018,61 820.012689,61 Z M820.161408,60.9889406 L820.117602,60.9945129 L820.117602,60.9945129 C820.132128,60.9929912 820.146788,60.9911282 820.161408,60.9889406 Z M819.865274,60.9891349 L819.883098,60.9916147 C819.877051,60.9908286 819.87101,60.9899872 819.864975,60.9890905 L819.865274,60.9891349 Z M819.739652,60.9621771 L819.755271,60.9664589 C819.749879,60.9650278 819.744498,60.9635509 819.739126,60.9620283 L819.739652,60.9621771 Z M820.288411,60.9614133 L820.234515,60.9752112 L820.234515,60.9752112 C820.252527,60.971132 820.270527,60.9665268 820.288411,60.9614133 Z M820.401572,60.921544 L820.359957,60.9380009 L820.359957,60.9380009 C820.373809,60.9328834 820.387743,60.9273763 820.401572,60.921544 Z M819.623655,60.9214803 C819.628579,60.923546 819.626191,60.9225499 819.623806,60.921544 L819.623655,60.9214803 Z M819.506361,60.8625673 L819.400002,60.7903682 C819.444408,60.8248958 819.491056,60.8551582 819.539393,60.8811554 L819.506361,60.8625673 L819.506361,60.8625673 Z M820.51858,60.8628242 L820.486378,60.8809439 L820.486378,60.8809439 C820.496939,60.8752641 820.507806,60.8691536 820.51858,60.8628242 Z M840.881155,60.4606074 L840.862567,60.4936392 L840.862567,60.4936392 L840.790368,60.5999978 C840.824896,60.555592 840.855158,60.5089438 840.881155,60.4606074 Z M840.936494,60.3386283 L840.92148,60.3763453 L840.92148,60.3763453 C840.926791,60.3637541 840.931774,60.3512293 840.936494,60.3386283 Z M840.974777,60.2110466 L840.962177,60.2603479 L840.962177,60.2603479 C840.966711,60.2443555 840.97096,60.2277405 840.974777,60.2110466 Z M840.994445,60.0928727 L840.989135,60.1347261 L840.989135,60.1347261 C840.991174,60.1210064 840.992958,60.1069523 840.994445,60.0928727 Z M839.987311,39.9996529 L830,49.9872374 L820.012689,39.9996529 L819.999653,40.0126889 L829.987237,50 L819.999653,59.9873111 L820.012689,60.0003471 L830,50.0127626 L839.987311,60.0003471 L840.000347,59.9873111 L830.012763,50 L840.000347,40.0126889 L839.987311,39.9996529 Z M840.999873,59.9713258 L840.999916,60.0003193 L840.999916,60.0003193 C841.000041,59.9907089 841.000027,59.9810165 840.999873,59.9713258 Z M840.988941,59.8385918 L840.994513,59.8823981 L840.994513,59.8823981 C840.992991,59.8678719 840.991128,59.8532122 840.988941,59.8385918 Z M840.961413,59.7115886 L840.975211,59.7654853 L840.975211,59.7654853 C840.971132,59.7474727 840.966527,59.7294733 840.961413,59.7115886 Z M840.921544,59.5984278 L840.938001,59.6400431 L840.938001,59.6400431 C840.932883,59.6261908 840.927376,59.612257 840.921544,59.5984278 Z M840.862824,59.4814199 L840.880944,59.5136217 L840.880944,59.5136217 C840.875264,59.503061 840.869154,59.4921939 840.862824,59.4814199 Z M819.119056,40.4863783 L819.134164,40.5134185 C819.128903,40.5043379 819.123796,40.4951922 819.118845,40.4859852 L819.119056,40.4863783 Z M819.061999,40.3599569 L819.075467,40.3944079 C819.070734,40.3829341 819.066223,40.3713901 819.061935,40.3597825 L819.061999,40.3599569 Z M819.024789,40.2345147 L819.033541,40.2701072 C819.030397,40.2582611 819.027473,40.2463686 819.024771,40.234436 L819.024789,40.2345147 Z M819.005077,40.1136164 L819.008385,40.1422797 C819.007138,40.1326872 819.00603,40.12308 819.005061,40.1134615 L819.005077,40.1136164 Z M819.000419,39.9836733 L819,40.0126889 C819,40.002956 819.000141,39.993223 819.000424,39.9834934 L819.000419,39.9836733 Z M819.010865,39.8652739 L819.008385,39.8830981 C819.009171,39.8770511 819.010013,39.8710099 819.010909,39.8649753 L819.010865,39.8652739 Z M819.037823,39.7396521 L819.033541,39.7552707 C819.034972,39.7498794 819.036449,39.7444978 819.037972,39.7391264 L819.037823,39.7396521 Z M819.07852,39.6236547 C819.076454,39.6285788 819.07745,39.6261907 819.078456,39.6238057 L819.07852,39.6236547 Z M819.137433,39.5063608 L819.209632,39.4000022 C819.175104,39.444408 819.144842,39.4910562 819.118845,39.5393926 L819.137433,39.5063608 L819.137433,39.5063608 Z M820.485985,39.1188446 L820.519017,39.1374327 L820.519017,39.1374327 L820.625376,39.2096318 C820.58097,39.1751042 820.534322,39.1448418 820.485985,39.1188446 Z M839.513622,39.1190561 L839.486582,39.1341644 C839.495662,39.128903 839.504808,39.1237964 839.514015,39.1188446 L839.513622,39.1190561 Z M819.539,39.1190561 L819.511959,39.1341644 C819.52104,39.128903 819.530186,39.1237964 819.539393,39.1188446 L819.539,39.1190561 Z M840.460607,39.1188446 L840.493639,39.1374327 L840.493639,39.1374327 L840.599998,39.2096318 C840.555592,39.1751042 840.508944,39.1448418 840.460607,39.1188446 Z M819.661418,39.0634885 L819.63097,39.0754675 C819.641051,39.0713084 819.651187,39.0673212 819.661372,39.0635059 L819.661418,39.0634885 Z M820.359783,39.0619346 L820.401723,39.0785197 L820.401723,39.0785197 C820.387743,39.0726237 820.373809,39.0671166 820.359783,39.0619346 Z M839.640043,39.0619991 L839.605592,39.0754675 C839.617066,39.0707338 839.62861,39.0662229 839.640217,39.0619346 L839.640043,39.0619991 Z M840.338628,39.0635059 L840.376345,39.0785197 L840.376345,39.0785197 C840.363754,39.0732095 840.351229,39.0682261 840.338628,39.0635059 Z M819.789259,39.0251536 L819.755271,39.0335411 C819.766459,39.0305713 819.777688,39.0277987 819.788953,39.0252234 L819.789259,39.0251536 Z M820.234436,39.0247709 L820.288548,39.0386257 L820.288548,39.0386257 C820.270527,39.0334732 820.252527,39.028868 820.234436,39.0247709 Z M839.765485,39.0247888 L839.729893,39.0335411 C839.741739,39.0303966 839.753631,39.0274732 839.765564,39.0247709 L839.765485,39.0247888 Z M840.211047,39.0252234 L840.260348,39.0378229 L840.260348,39.0378229 C840.244356,39.0332892 840.227741,39.0290398 840.211047,39.0252234 Z M819.911404,39.0051132 L819.883098,39.0083853 C819.892432,39.0071719 819.901779,39.0060902 819.911137,39.0051402 L819.911404,39.0051132 Z M820.113462,39.0050614 L820.161342,39.0110494 L820.161342,39.0110494 C820.145468,39.0086743 820.12948,39.006675 820.113462,39.0050614 Z M839.886384,39.005077 L839.85772,39.0083853 C839.867313,39.0071382 839.87692,39.0060303 839.886538,39.0050614 L839.886384,39.005077 Z M840.088863,39.0051402 L840.134726,39.0108651 L840.134726,39.0108651 C840.119676,39.0086288 840.104284,39.0067057 840.088863,39.0051402 Z M839.95834,39.0004173 L840.016507,39.0004238 C839.997122,38.9998609 839.977725,38.9998588 839.95834,39.0004173 Z M819.983493,39.0004238 L820.04166,39.0004173 C820.022275,38.9998588 820.002878,38.9998609 819.983493,39.0004238 Z" id="cancel"> </path> </g> </g> </g> </g></svg>
                            </button>
                        </div>
                    `;
            })
            selected.innerHTML = tempSelected
        }

        input.addEventListener("focus", () => {
            result.classList.remove("hidden")
        })

        input.addEventListener("focusout", () => {
            setTimeout(() => {
                result.classList.add("hidden")
            }, 2000);
        })

        input.addEventListener('keyup', function () {
            clearTimeout(timeout);

            timeout = setTimeout(() => {
                const keyword = this.value;

                fetch(`{{ route('admin_anggota_search') }}?q=${encodeURIComponent(keyword)}`)
                    .then(response => response.json())
                    .then(data => {
                        let html = '';

                        if (data.length === 0) {
                            html = `<li class="text-gray-500">Data tidak ditemukan</li>`;
                        } else {
                            data.forEach(member => {
                                html += `
                                <div class="border border-gray-300 bg-gray-100 p-2 flex items-center gap-5 justify-between rounded">
                                    <p>${member["id"]} - ${member["name"]}</p>
                                        <button
                                        type='button'
                                            onclick="test('${member["id"]}', '${member["name"]}')"
                                            class="p-2 flex items-center gap-1 bg-green-800 text-sm font-semibold rounded-md text-white transition-all duration-200 ease-in-out hover:bg-green-700">
                                            <svg viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" fill="#000000"
                                                class="w-4 h-4">
                                                <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                                                <g id="SVGRepo_tracerCarrier" stroke-linecap="round"
                                                    stroke-linejoin="round"></g>
                                                <g id="SVGRepo_iconCarrier">
                                                    <g id="Complete">
                                                        <g data-name="add" id="add-2">
                                                            <g>
                                                                <line fill="none" stroke="#ffffff" stroke-linecap="round"
                                                                    stroke-linejoin="round" stroke-width="2" x1="12" x2="12"
                                                                    y1="19" y2="5">
                                                                </line>
                                                                <line fill="none" stroke="#ffffff" stroke-linecap="round"
                                                                    stroke-linejoin="round" stroke-width="2" x1="5" x2="19"
                                                                    y1="12" y2="12">
                                                                </line>
                                                            </g>
                                                        </g>
                                                    </g>
                                                </g>
                                            </svg>
                                        </button>
                                </div>
                            `;
                            });
                        }

                        result.innerHTML = html;
                    })
                    .catch(error => {
                        console.error(error);
                    });

            }, 300);
        });
    </script>
@endsection
