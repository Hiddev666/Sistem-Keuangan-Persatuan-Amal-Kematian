<?php

namespace App\Http\Controllers;

use App\Models\Benefit;
use App\Models\CashTransaction;
use App\Models\Contribution;
use App\Models\DeathEvent;
use App\Models\Donation;
use App\Models\FamilyCard;
use App\Models\Member;
use App\Models\User;
use App\Services\CashTransactionService;
use Exception;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class BendaharaController extends Controller
{
    public function index()
    {
        $summary = CashTransaction::selectRaw("
            COALESCE(SUM(CASE WHEN type = 'income' THEN amount END), 0) AS total_income,
            COALESCE(SUM(CASE WHEN type = 'expense' THEN amount END), 0) AS total_expense,
            COALESCE(SUM(CASE WHEN type = 'income' THEN amount ELSE -amount END), 0) AS balance
            ")->first();

        $kasSummary = Contribution::selectRaw("
            COUNT(CASE WHEN status = 'pending' THEN id END) AS pending_members,
            COUNT(CASE WHEN status = 'paid' THEN id END) AS paid_members
        ")->first();

        $data = DB::table('cash_transactions')
            ->select(
                DB::raw('MONTH(created_at) as bulan'),
                DB::raw("SUM(CASE WHEN type = 'income' THEN amount ELSE 0 END) as income"),
                DB::raw("SUM(CASE WHEN type = 'expense' THEN amount ELSE 0 END) as expense")
            )
            ->whereYear("created_at", "=", "2025")
            ->groupBy('bulan')
            ->orderBy('bulan')
            ->get();
        return view('admin/index', [
            'summary' => $summary,
            'kas_summary' => $kasSummary,
            'data' => $data
        ]);
    }

    public function keanggotaan()
    {
        $familyCards = FamilyCard::with(['members', 'head'])->orderBy("updated_at", "desc")->paginate(10);
        return view('admin/keanggotaan/index', [
            "family_cards" => $familyCards
        ]);
    }

    public function anggota()
    {
        $members = Member::orderBy("updated_at", "desc")->paginate(10);
        return view('admin/anggota/index', [
            "members" => $members
        ]);
    }

    public function searchKeanggotaan(Request $request)
    {
        $keyword = $request->query('q');

        $familyCards = FamilyCard::with(['head', 'members'])->where('id', 'LIKE', "%$keyword%")
            ->orWhereHas('members', function ($q) use ($keyword) {
                $q->where('name', 'LIKE', "%$keyword%");
            })
            ->get();

        // $members = Member::query()
        //     ->when($keyword, function ($query) use ($keyword) {
        //         $query->where('id', 'LIKE', "%{$keyword}%")
        //             ->orWhere('name', 'LIKE', "%{$keyword}%");
        //     })
        //     ->orderBy('name')
        //     ->limit(10)
        //     ->get();

        return response()->json($familyCards);
    }

    public function search(Request $request)
    {
        $keyword = $request->query('q');

        $members = Member::query()
            ->when($keyword, function ($query) use ($keyword) {
                $query->where('id', 'LIKE', "%{$keyword}%")
                    ->orWhere('name', 'LIKE', "%{$keyword}%");
            })
            ->where("status", "=", "aktif")
            ->orderBy('name')
            ->limit(10)
            ->get();

        return response()->json($members);
    }

    public function addKeanggotaan()
    {
        return view('admin/keanggotaan/add');
    }

    public function addAnggota()
    {
        return view('admin/anggota/add');
    }

    public function editKeanggotaan($id)
    {
        $statuses = [
            [
                "text" => "Aktif",
                "value" => "aktif"
            ],
            [
                "text" => "Nonaktif",
                "value" => "nonaktif"
            ],
            [
                "text" => "Meninggal",
                "value" => "meninggal"
            ],
        ];
        $familyCard = FamilyCard::with('members')->find($id);
        return view('admin/keanggotaan/add', [
            "family_card" => $familyCard,
            "statuses" => $statuses
        ]);
    }

    public function editAnggota($id)
    {
        $member = Member::find($id);
        return view('admin/anggota/add', [
            "member" => $member
        ]);
    }

    public function createKeanggotaan(Request $request)
    {
        $validated = $request->validate([
            'id' => ['required', 'string'],
            'password' => ['required', 'string'],
            'head_member_id' => ['string'],
        ]);

        try {
            $familyCard = FamilyCard::create([
                'id' => $validated['id'],
                'password' => Hash::make($validated['password']),
                'head_member_id' => $validated['head_member_id'] ?? "",
            ]);

            return redirect()->route("admin_keanggotaan")->with("success", "Berhasil Menambahkan Kartu Keluarga Baru");
        } catch (QueryException $err) {
            if ($err->errorInfo[1] == 1062) {
                return redirect()
                    ->back()
                    ->withInput()
                    ->withErrors([
                        'nokk' => 'Nomor Kartu Keluarga sudah terdaftar'
                    ]);
            }

            return redirect()
                ->back()
                ->withInput()
                ->withErrors([
                    'error' => 'Terjadi kesalahan pada database'
                ]);
        }
        return "ok";
    }

    public function createAnggota(Request $request)
    {
        $validated = $request->validate([
            'id' => ['required', 'string'],
            'no_kk' => ['required', 'string'],
            'name' => ['required', 'string'],
            'password' => ['string'],
            'phone' => ['required', 'string'],
            'status' => ['required', 'string'],
            'tanggal_daftar' => ['required', 'date'],
            'address' => ['required', 'string']
        ]);

        try {
            $member = Member::create([
                'id' => $validated['id'],
                'no_kk' => $validated['no_kk'],
                'name' => $validated['name'],
                'password' => Hash::make($validated['password']),
                'phone' => $validated['phone'],
                'status' => $validated['status'],
                'tanggal_daftar' => $validated['tanggal_daftar'],
                'address' => $validated['address'],
            ]);

            return redirect()->route("admin_anggota")->with("success", "Berhasil Menambahkan Anggota Baru");
        } catch (QueryException $err) {
            if ($err->errorInfo[1] == 1062) {
                return redirect()
                    ->back()
                    ->withInput()
                    ->withErrors([
                        'nik' => 'NIK sudah terdaftar'
                    ]);
            }

            return redirect()
                ->back()
                ->withInput()
                ->withErrors([
                    'error' => 'Terjadi kesalahan pada database'
                ]);
        }
        return "ok";
    }

    public function updateKeanggotaan(Request $request)
    {
        try {
            $data = [
                'head_member_id' => $request["head_member_id"]
            ];

            if ($request["password"] != "" || $request["password"] != null) {
                $data["password"] = Hash::make($request["password"]);
            }

            $member = FamilyCard::where("id", $request["id"])->update($data);

            return redirect()->route("admin_keanggotaan")->with("success", "Data Kartu Keluarga Berhasil Diubah");
        } catch (QueryException $err) {
            if ($err->errorInfo[1] == 1062) {
                return redirect()
                    ->back()
                    ->withInput()
                    ->withErrors([
                        'nik' => 'NIK sudah terdaftar'
                    ]);
            }

            return redirect()
                ->back()
                ->withInput()
                ->withErrors([
                    'error' => $request["password"]
                ]);
        }
        return "ok";
    }

    public function updateKeanggotaanAnggota(Request $request)
    {
        try {
            $date = now();
            $register_date = $date->format('Y-m'); // 2025-01
            foreach ($request->items as $item) {
                $member = Member::updateOrCreate(
                    ['id' => $item["member_id"]],
                    [
                        'id' => $item["member_id"],
                        'name' => $item["name"],
                        'phone' => $item["phone"],
                        'status' => $item["status"],
                        'family_card_id' => $item["family_card_id"],
                        'register_date' => $register_date
                    ]
                );
            }
            session()->flash('success', 'Berhasil Mengubah Anggota');

            return response()->json([
                'redirect' => route('admin_keanggotaan_edit', $request->items[0]["family_card_id"]),
            ]);
        } catch (QueryException $err) {
            return $err->getMessage();
        }
    }

    public function updateAnggota(Request $request)
    {
        try {
            $member = Member::where("id", $request["id"])->update([
                'no_kk' => $request["no_kk"],
                'name' => $request["name"],
                'password' => $request["password"] ?? "",
                'phone' => $request["phone"],
                'status' => $request["status"],
                'tanggal_daftar' => $request["tanggal_daftar"],
                'address' => $request["address"],
            ]);

            return redirect()->route("admin_anggota")->with("success", "Data Anggota Berhasil Diubah");
        } catch (QueryException $err) {
            if ($err->errorInfo[1] == 1062) {
                return redirect()
                    ->back()
                    ->withInput()
                    ->withErrors([
                        'nik' => 'NIK sudah terdaftar'
                    ]);
            }

            return redirect()
                ->back()
                ->withInput()
                ->withErrors([
                    'error' => $request["password"]
                ]);
        }
        return "ok";
    }

    public function deleteKeanggotaan($id)
    {
        try {
            $member = FamilyCard::findOrFail($id)->delete();
            return redirect()->route("admin_keanggotaan")->with("success", "Data Keanggotaan Berhasil Dihapus");
        } catch (QueryException $err) {
            if ($err->errorInfo[1] == 1062) {
                return redirect()
                    ->back()
                    ->withInput()
                    ->withErrors([
                        'nik' => 'NIK sudah terdaftar'
                    ]);
            }
        }
        return "ok";
    }
    public function deleteAnggota($id)
    {
        try {
            $member = Member::findOrFail($id)->delete();
            return redirect()->route("admin_anggota")->with("success", "Data Anggota Berhasil Dihapus");
        } catch (QueryException $err) {
            if ($err->errorInfo[1] == 1062) {
                return redirect()
                    ->back()
                    ->withInput()
                    ->withErrors([
                        'nik' => 'NIK sudah terdaftar'
                    ]);
            }
        }
        return "ok";
    }

    // Kas Bulanan
    public function kas(Request $request)
    {
        $period = $request->period;

        $date = now();
        $value = $date->format('Y-m');
        $contributions = Contribution::where('period', "=", $value)
            ->with('family_card.head')
            ->orderBy('period', 'desc')
            ->orderBy('updated_at', 'desc')
            ->get();

        if ($period) {
            [$year, $month] = explode('-', $period);
            $contributions = Contribution::with('family_card')
                ->where('period', '=', $period)
                ->orderBy('period', 'desc')
                ->orderBy('updated_at', 'desc')
                ->get();
        }

        return view('admin/kas/index', [
            "contributions" => $contributions
        ]);
    }

    public function addKas()
    {
        return view('admin/kas/add');
    }

    public function createKas(Request $request)
    {
        $items = $request->items;
        $period = $items["period"];
        $amount = $items["amount"];
        $members = $items["members"];

        if ($members == []) {
            $members = FamilyCard::get(['id']);
        }

        try {
            foreach ($members as $member) {
                $member = Contribution::create([
                    'family_card_id' => $member["id"],
                    'period' => $period,
                    'amount' => $amount,
                    'status' => "pending",
                ]);
            }
            session()->flash('success', 'Berhasil menambahkan kas');

            return response()->json([
                'redirect' => route('admin_kas')
            ]);
        } catch (QueryException $err) {
            return $err->getMessage();
        }
    }

    public function searchKas(Request $request)
    {
        $period = $request->period;
        $keyword = $request->query('q');

        $date = now();
        $value = $date->format('Y-m');

        $contributions = Contribution::query()
            ->with('family_card')
            ->where('period', "=", $value)
            ->when($keyword, function ($query) use ($keyword) {
                $query->whereHas('family_card', function ($q) use ($keyword) {
                    $q->where('id', 'LIKE', "%{$keyword}%");
                });
            })
            ->orderBy('period', 'desc')
            ->orderBy('updated_at', 'desc')
            ->get();

        if ($period) {
            $contributions = Contribution::query()
                ->with('family_card')
                ->where('period', "=", $period)
                ->when($keyword, function ($query) use ($keyword) {
                    $query->whereHas('family_card', function ($q) use ($keyword) {
                        $q->where('id', 'LIKE', "%{$keyword}%");
                    });
                })
                ->orderBy('period', 'desc')
                ->orderBy('updated_at', 'desc')
                ->get();
        }

        return response()->json($contributions);
    }

    public function editKas($id)
    {
        $contribution = Contribution::with('family_card')
            ->orderBy('period', 'desc')
            ->orderBy('status')
            ->find($id);
        return view('admin/kas/add', [
            "contribution" => $contribution
        ]);
    }

    public function updateKas(Request $request)
    {
        try {
            $cashTransaction = new CashTransactionService();
            $contribution = Contribution::where("id", $request["id"])->update([
                'amount' => $request["amount"],
                'status' => $request["status"],
            ]);

            $contrib = Contribution::find($request["id"]);
            $cashTransaction->incomeFromContribution($contrib);

            return redirect()->route("admin_kas")->with("success", "Data Kas Berhasil Diubah");
        } catch (QueryException $err) {
            return redirect()
                ->back()
                ->withInput()
                ->withErrors([
                    'error' => $err->getMessage()
                ]);
        }
    }

    public function deleteKas($id)
    {
        try {
            $contribution = Contribution::findOrFail($id)->delete();
            return redirect()->route("admin_kas")->with("success", "Data Kas Berhasil Dihapus");
        } catch (QueryException $err) {
        }
        return "ok";
    }

    // Duka
    public function duka(Request $request)
    {
        $period = $request["period"] ?? "";

        if ($period != "") {
            [$year, $month] = explode('-', $period);
            $death_events = DeathEvent::with(['member', 'benefit'])
                ->whereYear("updated_at", $year)
                ->whereMonth("updated_at", $month)
                ->orderBy('updated_at', 'desc')
                ->get();
        } else {
            $death_events = DeathEvent::with(['member', 'benefit'])
                ->withCount([
                    'contributions as total_benefit' => function ($q) {
                        $q->where('status', 'paid');
                    }
                ])
                ->orderBy('updated_at', 'desc')
                ->get();
        }

        return view('admin/berita-duka/index', [
            "death_events" => $death_events
        ]);
    }

    public function detailDuka($id)
    {
        $contributions = Contribution::with("death_event.member")->where("death_event_id", "=", $id)->get();

        return view('admin/berita-duka/detail', [
            "contributions" => $contributions
        ]);
    }

    public function addDuka()
    {
        return view('admin/berita-duka/add');
    }

    public function createDuka(Request $request)
    {
        $items = $request->items;
        $member = $items["member"];
        $date_of_death = $items["date_of_death"];
        $address = $items["address"];
        $contribution_amount = $items["contribution_amount"];

        try {
            $death_member = Member::find($member)->update([
                "status" => "meninggal"
            ]);

            $death_event = DeathEvent::create([
                "member_id" => $member,
                "date_of_death" => $date_of_death,
                "address" => $address,
                "contribution_amount" => $contribution_amount
            ]);

            $death_event_id = $death_event::where("member_id", "=", $member)->first();

            $family_cards = FamilyCard::all();

            foreach ($family_cards as $family_card) {
                $contribution = Contribution::create([
                    'family_card_id' => $family_card["id"],
                    'death_event_id' => $death_event_id->id,
                    'amount' => $contribution_amount,
                    'status' => "pending",
                ]);
            }

            $benefit = Benefit::create([
                "id" => $death_event_id->id,
                "death_event_id" => $death_event_id->id,
                "amount" => 0,
                "status" => "planed"
            ]);

            session()->flash('success', 'Berhasil menambahkan berita duka');

            return response()->json([
                'redirect' => route('admin_duka')
            ]);
        } catch (QueryException $err) {
            return $err->getMessage();
        }
    }

    public function editDukaContrib($id)
    {
        $contribution = Contribution::with('family_card')
            ->orderBy('status')
            ->find($id);
        return view('admin/berita-duka/edit_contribution', [
            "contribution" => $contribution
        ]);
    }

    public function updateDukaContrib(Request $request)
    {
        try {
            $cashTransaction = new CashTransactionService();
            $contribution = Contribution::where("id", $request["id"])->update([
                'amount' => $request["amount"],
                'status' => $request["status"],
            ]);

            $contrib = Contribution::find($request["id"]);
            $cashTransaction->incomeFromContribution($contrib);

            return redirect()->route("admin_duka_detail", $contrib["death_event_id"])->with("success", "Data Berhasil Diubah");
        } catch (QueryException $err) {
            return redirect()
                ->back()
                ->withInput()
                ->withErrors([
                    'error' => $err->getMessage()
                ]);
        }
    }

    public function confirmDuka($id)
    {
        try {
            $death_events = DeathEvent::with(['member', 'benefit'])
                ->withCount([
                    'contributions as total_benefit' => function ($q) {
                        $q->where('status', 'paid');
                    }
                ])
                ->where("id", "=", $id)
                ->orderBy('updated_at', 'desc')
                ->first();

            $cashTransaction = new CashTransactionService();

            $benefit = Benefit::find($id);
            $cashTransaction->expenseFromBenefit($benefit);
            $benefit->update([
                "status" => "disbursed",
                "amount" => $death_events->contribution_amount * $death_events->total_benefit,
            ]);


            return redirect()->route("admin_duka_detail", $id)->with("success", "Data Berhasil Diubah");
        } catch (QueryException $err) {
            return redirect()
                ->back()
                ->withInput()
                ->withErrors([
                    'error' => $err->getMessage()
                ]);
        }
    }

    public function deleteDukaContrib($id)
    {
        try {
            $contribution = Contribution::findOrFail($id)->delete();
            return redirect()->route("admin_duka")->with("success", "Data Berhasil Dihapus");
        } catch (QueryException $err) {
        }
        return "ok";
    }

    public function deleteDuka($id)
    {
        try {
            $benefit = Benefit::where("death_event_id", "=", $id)->delete();
            $deathEvent = DeathEvent::findOrFail($id)->delete();
            return redirect()->route("admin_duka")->with("success", "Data Berita Duka Berhasil Dihapus");
        } catch (QueryException $err) {
        }
    }

    public function sumbangan(Request $request)
    {
        $date = now();
        $value = $date->format('Y-m');
        $donations = Donation::with('member')
            ->orderBy('created_at', 'desc')
            ->get();

        return view('admin/sumbangan/index', [
            "donations" => $donations
        ]);
    }

    public function addSumbangan()
    {
        return view('admin/sumbangan/add');
    }

    public function createSumbangan(Request $request)
    {
        $items = $request->items;
        $members = $items["members"][0];
        $amount = $items["amount"];

        try {
            if ($members["id"] == "Non Anggota") {
                $member = Donation::create([
                    'donor_name' => $members["name"],
                    'amount' => $amount,
                    'status' => "pending",
                ]);
            } else {
                $member = Donation::create([
                    'member_id' => $members["id"],
                    'amount' => $amount,
                    'status' => "pending",
                ]);
            }

            session()->flash('success', 'Berhasil Menambahkan Sumbangan');

            return response()->json([
                'redirect' => route('admin_sumbangan')
            ]);
        } catch (QueryException $err) {
            return response()->json([
                'err' => $err->getMessage()
            ]);
        }
    }

    public function editSumbangan($id)
    {
        $donation = Donation::with('member')
            ->orderBy('status')
            ->orderBy('created_at', 'desc')
            ->find($id);
        return view('admin/sumbangan/add', [
            "donation" => $donation
        ]);
    }


    public function updateSumbangan(Request $request)
    {
        try {
            $cashTransaction = new CashTransactionService();
            $donation = Donation::where("id", $request["id"])->update([
                'amount' => $request["amount"],
                'status' => $request["status"],
            ]);

            $donate = Donation::find($request["id"]);
            $cashTransaction->incomeFromDonation($donate);

            return redirect()->route("admin_sumbangan")->with("success", "Data Kas Berhasil Diubah");
        } catch (QueryException $err) {
            return redirect()
                ->back()
                ->withInput()
                ->withErrors([
                    'error' => $err->getMessage()
                ]);
        }
    }
}
