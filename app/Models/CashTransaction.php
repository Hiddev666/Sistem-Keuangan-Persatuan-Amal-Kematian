<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CashTransaction extends Model
{
    protected $table = 'cash_transactions';

    public $incrementing = false;

    protected $keyType = 'int';

    public $timestamps = false;

    protected $fillable = [
        'id',
        'reference_type',
        'reference_id',
        'transaction_date',
        'type',
        'amount',
        'description',
        'created_at',
    ];

    protected $casts = [
        'transaction_date' => 'date',
        'amount' => 'decimal:2',
        'created_at' => 'datetime',
    ];

    public function reference()
    {
        return $this->morphTo(__FUNCTION__, 'reference_type', 'reference_id');
    }

    public function donation() {
        return $this->belongsTo(Donation::class, "reference_id", "id");
    }

    public function contribution() {
        return $this->belongsTo(Contribution::class, "reference_id", "id");
    }
}
