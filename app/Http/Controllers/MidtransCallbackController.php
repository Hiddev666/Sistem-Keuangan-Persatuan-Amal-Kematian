<?php

namespace App\Http\Controllers;

use App\Models\Contribution;
use App\Models\Donation;
use Illuminate\Support\Facades\Log;
use App\Models\FamilyCard;
use App\Models\Payment;
use Illuminate\Support\Str;
use App\Services\CashTransactionService;
use App\Services\FonnteService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class MidtransCallbackController extends Controller
{
    public function handle(Request $request) {
        $payment = Payment::with(["contribution", "donation"])->where('order_id', $request->order_id);

        Log::info("CHECKPAYMENT : " . $payment->get());

        $payment->update([
            'transaction_status' => $request->transaction_status,
            'payment_type' => $request->payment_type,
            'paid_at' => now()
        ]);

        if(in_array($request->transaction_status, ['settlement', 'capture'])) {
            $cashTransaction = new CashTransactionService();
            $orderType = explode("--", $payment->first()->order_id)[0];
            if($orderType == "CONTRIBUTION") {
                $contributions = Contribution::where("family_card_id", "=", $payment->first()->snap_token)->where("status", "=", "pending")->get();
                Log::info("DONE BANG : " . $contributions);
                foreach ($contributions as $contribution) {
                    $cashTransaction->incomeFromContribution($contribution);
                    $contribution->update([
                        'status' => "paid"
                    ]);
                }
            } elseif ($orderType == "DONATION") {
                $donation = Donation::where("payment_id", "=", $payment->first()->id)->first();
                $cashTransaction->incomeFromDonation($donation);
            } elseif ($orderType == "REGISTRATION") {
                $family_card = FamilyCard::find(explode("--", $payment->first()->order_id)[1]);

                $fonnte = new FonnteService();
                $id = $family_card->id;
                $password = Str::random(7);
                $url = config('app.url') . "/sign-in";
                $fonnte->send($family_card->phone, "*Registrasi Keanggotaan Persatuan Amal Kematian* \n \n Registrasi keanggotaan anda telah berhasil! \n Anda bisa masuk ke dashboard anggota dengan link dan akun di bawah ini. \n \n Link: $url \n Username: $id \n Password: $password \n \n Harap untuk tidak membagikan akun kepada siapapun. Terima Kasih. \n \n Salam hangat, \n Pengurus Persatuan Amal Kematian");

                $family_card->update([
                    "password" => Hash::make($password),
                    "phone" => null
                ]);
                $cashTransaction->incomeFromRegistration($family_card);
            }
            $payment->update([
                'fraud_status' => 'paid'
            ]);
        }

        return response()->json(['status' => 'ok']);
    }
}
