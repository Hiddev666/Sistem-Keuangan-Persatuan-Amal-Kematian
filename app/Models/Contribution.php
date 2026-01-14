<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Contribution extends Model
{
    protected $table = 'contributions';

    protected $fillable = [
        'family_card_id',
        'death_event_id',
        'amount',
        'status',
        'payment_id',
    ];

    protected $casts = [
        'amount' => 'decimal:2',
    ];

    public function family_card()
    {
        return $this->belongsTo(FamilyCard::class, 'family_card_id', 'id');
    }

    public function death_event()
    {
        return $this->belongsTo(DeathEvent::class, 'death_event_id', 'id');
    }

    public function payment()
    {
        return $this->belongsTo(Payment::class, 'payment_id');
    }

    public function cashTransactions()
    {
        return $this->morphMany(CashTransaction::class, 'reference', 'reference_type', 'reference_id');
    }
}
