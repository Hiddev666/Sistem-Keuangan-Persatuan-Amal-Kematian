<?php

namespace App\Http\Controllers;

use App\Models\Contribution;
use App\Models\Payment;
use Illuminate\Http\Request;
use Midtrans\Snap;

class ContributionPaymentController extends Controller
{
    public function pay(Contribution $contribution)
    {
        $payment = Payment::create([
            'gross_amount' => $contribution->amount,
            'transaction_status' => 'pending'
        ]);

        $orderId = "CONTRIB-" . $contribution->id . "-" . time();

        $params = [
            'transaction_details' => [
                'order_id' => $orderId,
                'gross_amount' => $payment->gross_amount
            ],
            'customer_details' => [
                'first_name' => $contribution->member->name,
                'phone' => $contribution->member->phone
            ],
            'item_details' => [
                'id' => 'iuran-' . $contribution->id,
                'price' => $payment->gross_amount,
                'quantity' => 1,
                'name' => 'Iuran Bulanan ' . $contribution->period
            ]
        ];

        $snapToken = Snap::getSnapToken($params);

        $payment->update([
            'order_id' => $orderId,
            'payment_type' => 'midtrans',
            'snap_token' => $snapToken
        ]);

        $contribution->update([
            'payment_id' => $payment->id
        ]);

        return response()->json([
            'snap_token' => $snapToken
        ]);
    }
}
