<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Member extends Model
{
    protected $table = 'members';

    /**
     * members.id adalah string (bukan auto-increment).
     */
    public $incrementing = false;

    protected $keyType = 'string';

    protected $fillable = [
        'id',
        'name',
        'no_kk',
        'password',
        'address',
        'phone',
        'status',
        'tanggal_daftar',
    ];

    protected $hidden = [
        'password',
    ];

    protected $casts = [
        'tanggal_daftar' => 'date',
    ];

    public function contributions()
    {
        return $this->hasMany(Contribution::class, 'member_id', 'id');
    }

    public function donations()
    {
        return $this->hasMany(Donation::class, 'member_id', 'id');
    }

    public function deathEvents()
    {
        return $this->hasMany(DeathEvent::class, 'member_id', 'id');
    }
}
