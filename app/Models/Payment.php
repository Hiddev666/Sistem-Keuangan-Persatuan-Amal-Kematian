<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    protected $table = 'payments';

    public $incrementing = true;

    protected $keyType = 'int';

    public $timestamps = false;

    protected $fillable = [
        'id',
        'order_id',
        'payment_type',
        'gross_amount',
        'transaction_status',
        'fraud_status',
        'snap_token',
        'paid_at',
        'created_at',
    ];

    protected $casts = [
        'gross_amount' => 'decimal:2',
        'paid_at' => 'datetime',
        'created_at' => 'datetime',
    ];

    public function contribution()
    {
        return $this->hasOne(Contribution::class, 'payment_id');
    }

    public function donation()
    {
        return $this->hasOne(Donation::class, 'payment_id');
    }
}
