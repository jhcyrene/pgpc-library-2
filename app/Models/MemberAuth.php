<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MemberAuth extends Model
{
    protected $fillable = [
        'member_id',
        'account_type',
        'username',
        'password_hash',
        'password_changed_at',
        'password_token',
        'token_expiry',
        'last_modified'
    ];

    protected $hidden = [
        'password_hash',
        'password_token'
    ];

    public function member()
    {
        return $this->belongsTo(Member::class);
    }
}
