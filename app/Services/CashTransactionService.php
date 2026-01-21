<?php

namespace App\Services;

use App\Models\Benefit;
use App\Models\CashTransaction;
use App\Models\Contribution;
use App\Models\DeathEvent;
use App\Models\Donation;
use App\Models\FamilyCard;

class CashTransactionService
{
    public function incomeFromContribution(Contribution $contribution): void
    {
        if ($contribution->status != "paid" && $this->exists('contribution', $contribution->id)) {
            $cashTransaction = CashTransaction::where([
                ["reference_id", "=", $contribution->id],
                ["reference_type", "=", "contribution"],
            ])->first();
            $test = CashTransaction::findOrFail($cashTransaction->id)->delete();
        } else {
            // ❌ Cegah double kas
            if ($this->exists('contribution', $contribution->id)) {
                return;
            }

            $benefit = Benefit::where("death_event_id", "=", $contribution->death_event_id);
            $benefitData = $benefit->first();
            $benefit->update([
                "amount" => $benefitData->amount + $contribution->amount
            ]);

            $deathEvent = DeathEvent::with('member')->find($contribution->death_event_id);

            CashTransaction::create([
                'reference_type'   => 'contribution',
                'reference_id'     => $contribution->id,
                'type'             => 'income',
                'amount'           => $contribution->amount,
                'transaction_date' => now(),
                'description'      => sprintf(
                    'Tagihan Duka %s Untuk %s',
                    $contribution->family_card_id,
                    $deathEvent->member->name,
                ),
            ]);
        }
    }

    public function expenseFromBenefit(Benefit $benefit): void
    {
        // 🔄 Kalau status BUKAN paid tapi transaksi udah ada → rollback
        if ($benefit->status !== 'paid' && $this->exists('benefit', $benefit->id)) {

            $cashTransaction = CashTransaction::where([
                ['reference_type', '=', 'benefit'],
                ['reference_id', '=', $benefit->id],
            ])->first();

            if ($cashTransaction) {
                $cashTransaction->delete();
            }

            return;
        }

        // ❌ Cegah double expense
        if ($this->exists('benefit', $benefit->id)) {
            return;
        }

        // 🚨 Validasi saldo (optional tapi recommended)
        // $saldoKas = CashTransaction::where('type', 'income')->sum('amount')
        //            - CashTransaction::where('type', 'expense')->sum('amount');
        //
        // if ($saldoKas < $benefit->amount) {
        //     throw new \Exception('Saldo kas tidak mencukupi');
        // }
        $death_event = DeathEvent::with('member')->find($benefit->death_event_id);

        // 💸 Buat transaksi kas (uang keluar)
        CashTransaction::create([
            'reference_type'   => 'benefit',
            'reference_id'     => $benefit->id,
            'type'             => 'expense',
            'amount'           => $benefit->amount,
            'transaction_date' => now(),
            'description'      => sprintf(
                'Pembayaran Santunan %s',
                $death_event->member->name
            ),
        ]);
    }


    public function incomeFromDonation(Donation $donation): void
    {
        if ($donation->status != "paid" && $this->exists('donation', $donation->id)) {
            $cashTransaction = CashTransaction::where([
                ["reference_id", "=", $donation->id],
                ["reference_type", "=", "donation"],
            ])->first();
            $test = CashTransaction::findOrFail($cashTransaction->id)->delete();
        } else {
            // ❌ Cegah double kas
            if ($this->exists('donation', $donation->id)) {
                return;
            }

            $run = CashTransaction::create([
                'reference_type'   => 'donation',
                'reference_id'     => $donation->id,
                'type'             => 'income',
                'amount'           => $donation->amount,
                'transaction_date' => now(),
                'description'      => sprintf(
                    'Donasi dari %s',
                    $donation->family_card->id ?? $donation->donor_name
                ),
            ]);
        }
    }

    public function incomeFromRegistration(FamilyCard $familyCard): void
    {
        // ❌ Cegah double kas
        if ($this->exists('family_card', $familyCard->id)) {
            return;
        }

        CashTransaction::create([
            'reference_type'   => 'registration',
            'reference_id'     => $familyCard->id,
            'type'             => 'income',
            'amount'           => 100000,
            'transaction_date' => now(),
            'description'      => sprintf(
                'Registration %s',
                $familyCard->id
            ),
        ]);
    }

    protected function exists(string $type, int $id): bool
    {
        return CashTransaction::where('reference_type', $type)
            ->where('reference_id', $id)
            ->exists();
    }
}
