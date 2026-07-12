<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class MemberAuth extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $table = 'member_auth';
    protected $primaryKey = 'member_auth_id';

    protected $fillable = [
        'member_id',
        'librarian_id',
        'account_type',
        'account_status',
        'username',
        'password_hash',
        'failed_attempts',
        'last_login',
        'password_changed_at',
        'password_token',
        'token_expiry',
        'last_modified',
    ];

    protected $hidden = [
        'password_hash',
        'password_token',
        'remember_token',
    ];

    protected $casts = [
        'last_login' => 'datetime',
        'password_changed_at' => 'datetime',
        'token_expiry' => 'datetime',
        'last_modified' => 'datetime',
    ];

    public function getAuthPassword()
    {
        return $this->password_hash;
    }

    public function member()
    {
        return $this->belongsTo(Member::class, 'member_id', 'member_id');
    }

    public function librarian()
    {
        return $this->belongsTo(Librarian::class, 'librarian_id', 'librarian_id');
    }
}
