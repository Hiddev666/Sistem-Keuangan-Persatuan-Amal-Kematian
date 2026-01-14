<?php

namespace App\Http\Controllers;

use App\Models\Contribution;
use App\Models\Donation;
use App\Models\Payment;
use App\Services\MidtransService;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Midtrans\Snap;

class PaymentController extends Controller
{
    public function payContribution($id)
    {
        $contribution = Contribution::with("family_card.head")->findOrFail($id);

        MidtransService::init();

        $orderID = 'ORDER-' . Str::uuid();
        $payment = Payment::create([
            'order_id' => $orderID,
            'payment_type' => 'midtrans',
            'transaction_status' => 'pending',
            'gross_amount' => $contribution->amount,
            'snap_token' => $id
        ]);

        $params = [
            'transaction_details' => [
                'order_id' => $orderID,
                'gross_amount' => $contribution->amount
            ],
            'customer_details' => [
                'first_name' => $contribution->family_card->head->name,
                'phone' => $contribution->family_card->head->phone
            ]
        ];

        $snapToken = Snap::getSnapToken($params);
        return view('member/kas/pay', compact('snapToken', 'payment', 'contribution'));
    }

    public function payDonation(Request $request)
    {
        MidtransService::init();

        $id = Str::uuid();
        $orderID = 'ORDER-' . Str::uuid();

        $donation = Donation::create([
            "member_id" => auth()->user()->id,
            "amount" => $request->amount,
            "status" => "pending"
        ]);

        $payment = Payment::create([
            'order_id' => $orderID,
            'payment_type' => 'midtrans',
            'transaction_status' => 'pending',
            'gross_amount' => $request->amount,
            'snap_token' => $id
        ]);

        $donation = Donation::where("id", "=", $payment->id)->update([
            "payment_id" => $payment->id,
            "status" => "paid"
        ]);

        $params = [
            'transaction_details' => [
                'order_id' => $orderID,
                'gross_amount' => $request->amount
            ],
            'customer_details' => [
                'first_name' => $request->name,
                'phone' => $request->phone
            ]
        ];

        $snapToken = Snap::getSnapToken($params);
        return view('member/kas/pay_donation', compact('snapToken', 'payment'));
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
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
    public function show(Payment $payment)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Payment $payment)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Payment $payment)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Payment $payment)
    {
        //
    }
}
