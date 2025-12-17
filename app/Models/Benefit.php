<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Benefit extends Model
{
    protected $table = 'benefits';

    public $incrementing = false;

    protected $keyType = 'int';

    public $timestamps = false;

    protected $fillable = [
        'id',
        'death_event_id',
        'amount',
        'disbursement_date',
        'status',
        'notes',
        'created_at',
    ];

    protected $casts = [
        'amount' => 'decimal:2',
        'disbursement_date' => 'date',
        'created_at' => 'datetime',
    ];

    public function deathEvent()
    {
        return $this->belongsTo(DeathEvent::class, 'death_event_id');
    }

    public function cashTransactions()
    {
        return $this->morphMany(CashTransaction::class, 'reference', 'reference_type', 'reference_id');
    }
}
