<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Laravel\Sanctum\HasApiTokens;

class MemberAuth extends Authenticatable
{
    use HasFactory, HasApiTokens, Notifiable, SoftDeletes;

    protected $table = 'member_auth';
    protected $primaryKey = 'member_auth_id';

    protected $fillable = [
        'member_id',
        'librarian_id',
        'account_type',
        'account_status',
        'username',
        'password_hash',
        'profile_image',
        'provider',
        'provider_id',
        'failed_attempts',
        'last_login',
        'password_changed_at',
        'password_token',
        'last_login_at',
        'token_expiry',
        'last_modified',
        'is_verified',
        'remember_token',
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
        return $this->password_hash ?? '';
    }

    public function hasPassword(): bool
    {
        return !empty($this->password_hash);
    }

    public function isGoogleLinked(): bool
    {
        return $this->provider === 'google' && !empty($this->provider_id);
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
