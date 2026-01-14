<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class FamilyCard extends Authenticatable
{
    use HasApiTokens;
    use HasFactory;
    use Notifiable;
    protected $table = 'family_cards';

    /**
     * members.id adalah string (bukan auto-increment).
     */
    public $incrementing = false;

    protected $keyType = 'string';

    protected $fillable = [
        'id',
        'head_member_id',
        'password'
    ];

    protected $hidden = [
        'password',
    ];

    public function members()
    {
        return $this->hasMany(Member::class, 'family_card_id', 'id');
    }

    public function head()
    {
        return $this->belongsTo(Member::class, 'head_member_id', 'id');
    }
}
