<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DeathEvent extends Model
{
    protected $table = 'death_events';

    public $incrementing = false;

    protected $keyType = 'int';

    public $timestamps = false;

    protected $fillable = [
        'id',
        'member_id',
        'date_of_death',
        'heir_name',
        'heir_address',
        'created_at',
    ];

    protected $casts = [
        'date_of_death' => 'date',
        'created_at' => 'datetime',
    ];

    public function member()
    {
        return $this->belongsTo(Member::class, 'member_id', 'id');
    }

    public function benefit()
    {
        return $this->hasOne(Benefit::class, 'death_event_id');
    }
}
