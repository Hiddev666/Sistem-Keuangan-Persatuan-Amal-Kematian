<?php

namespace App\Http\Controllers;

use App\Models\CashTransaction;
use App\Models\Contribution;
use App\Models\Donation;
use App\Models\Member;
use Illuminate\Http\Request;

class MemberController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $summary = CashTransaction::selectRaw("
        COALESCE(SUM(CASE WHEN type = 'income' THEN amount END), 0) AS total_income,
        COALESCE(SUM(CASE WHEN type = 'expense' THEN amount END), 0) AS total_expense,
        COALESCE(SUM(CASE WHEN type = 'income' THEN amount ELSE -amount END), 0) AS balance
        ")->first();
        $contributions = Contribution::where("family_card_id", "=", auth()->user()->id)->get();
        return view('member/index', [
            "contributions" => $contributions,
            'summary' => $summary,
        ]);
    }

    public function kas()
    {
        $donations = Donation::where("member_id", "=", auth()->user()->id)->get();
        $contributions = Contribution::with(["death_event.member"])->where("family_card_id", "=", auth()->user()->id)->get();
        return view('member/kas/index', [
            "contributions" => $contributions,
            "donations" => $donations,
        ]);
    }

    public function donasi()
    {
        return view('member/kas/donation');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Member $member)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Member $member)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Member $member)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Member $member)
    {
        //
    }
}
