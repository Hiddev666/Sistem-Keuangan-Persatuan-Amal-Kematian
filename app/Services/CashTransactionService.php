<?php

namespace App\Services;

use App\Models\CashTransaction;
use App\Models\Contribution;
use App\Models\Donation;

class CashTransactionService
{
    public function incomeFromContribution(Contribution $contribution): void
    {
        // ❌ Cegah double kas
        if ($this->exists('contribution', $contribution->id)) {
            return;
        }

        CashTransaction::create([
            'reference_type'   => 'contribution',
            'reference_id'     => $contribution->id,
            'type'             => 'income',
            'amount'           => $contribution->amount,
            'transaction_date' => now(),
            'description'      => sprintf(
                'Contribution %s - %s (%s)',
                $contribution->period,
                $contribution->member->name,
                $contribution->member->id
            ),
        ]);
    }

    public function incomeFromDonation(Donation $donation): void
    {
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
            'description'      => "donation ssadasdasd"
        ]);

        dd($run);
    }

    protected function exists(string $type, int $id): bool
    {
        return CashTransaction::where('reference_type', $type)
            ->where('reference_id', $id)
            ->exists();
    }
}
