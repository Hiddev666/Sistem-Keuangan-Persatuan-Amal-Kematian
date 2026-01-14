<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DeathEvent extends Model
{
    protected $table = 'death_events';

    public $incrementing = false;

    protected $keyType = 'int';

    public $timestamps = true;

    protected $fillable = [
        'member_id',
        'date_of_death',
        'address',
        'contribution_amount',
        'created_at',
        'updated_at',
    ];

    protected $casts = [
        'date_of_death' => 'date',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public function contributions()
    {
        return $this->hasMany(Contribution::class);
    }


    public function member()
    {
        return $this->belongsTo(Member::class, 'member_id', 'id');
    }

    public function benefit()
    {
        return $this->hasOne(Benefit::class, 'death_event_id');
    }
}
