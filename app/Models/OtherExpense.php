<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OtherExpense extends Model
{
    protected $table = 'other_expenses';

    public $incrementing = false;

    protected $keyType = 'int';

    public $timestamps = false;

    protected $fillable = [
        'id',
        'expense_date',
        'category',
        'amount',
        'description',
        'created_at',
    ];

    protected $casts = [
        'expense_date' => 'date',
        'amount' => 'decimal:2',
        'created_at' => 'datetime',
    ];

    public function cashTransactions()
    {
        return $this->morphMany(CashTransaction::class, 'reference', 'reference_type', 'reference_id');
    }
}
