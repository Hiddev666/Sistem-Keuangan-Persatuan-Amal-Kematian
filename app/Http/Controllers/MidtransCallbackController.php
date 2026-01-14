<?php

namespace App\Http\Controllers;

use App\Models\Contribution;
use App\Models\Payment;
use App\Services\CashTransactionService;
use Illuminate\Http\Request;

class MidtransCallbackController extends Controller
{
    public function handle(Request $request) {
        $payment = Payment::with("contribution")->where('order_id', $request->order_id)->first();
        if(!$payment) {
            $payment = Payment::with("donation")->where('order_id', $request->order_id)->first();
        }

        $payment->update([
            'transaction_status' => $request->transaction_status,
            'payment_type' => $request->payment_type,
            'paid_at' => now()
        ]);

        if(in_array($request->transaction_status, ['settlement', 'capture'])) {
            $cashTransaction = new CashTransactionService();
            $contrib = Contribution::find($payment->snap_token);
            $cashTransaction->incomeFromContribution($contrib);
            $contrib->update([
                'status' => "paid"
            ]);
            $payment->update([
                'fraud_status' => 'paid'
            ]);
        }

        return response()->json(['status' => 'ok']);
    }
}
