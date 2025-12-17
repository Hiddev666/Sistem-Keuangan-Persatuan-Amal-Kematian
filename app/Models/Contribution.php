<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Contribution extends Model
{
    protected $table = 'contributions';

    protected $fillable = [
        'member_id',
        'period',
        'amount',
        'status',
        'payment_id',
    ];

    protected $casts = [
        'amount' => 'decimal:2',
    ];

    public function member()
    {
        return $this->belongsTo(Member::class, 'member_id', 'id');
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
