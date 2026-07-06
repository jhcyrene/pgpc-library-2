<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Member extends Model
{
    protected $fillable = [
        'student_number',
        'first_name',
        'last_name',
        'middle_name',
        'email',
        'contact_num',
        'program',
        'year_level',
        'created_at',
        'modified_at',
        'member_status_id'
    ];

    public function auth()
    {
        return $this->hasOne(MemberAuth::class);
    }

    public function requests()
    {
        return $this->hasMany(BookRequest::class);
    }

    public function borrows()
    {
        return $this->hasMany(BookBorrow::class);
    }
}
