<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Member extends Authenticatable
{
    use HasApiTokens;
    use HasFactory;
    use Notifiable;
    protected $table = 'members';

    /**
     * members.id adalah string (bukan auto-increment).
     */
    public $incrementing = false;

    protected $keyType = 'string';

    protected $fillable = [
        'id',
        'name',
        'family_card_id',
        'phone',
        'status',
        'register_date',
    ];

    protected $casts = [
        'register_date' => 'date',
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

    public function family_card()
    {
        return $this->belongsTo(FamilyCard::class, 'family_card_id', 'id');
    }
}
