<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Member extends Model
{
    use HasFactory, SoftDeletes;

    protected $primaryKey = 'member_id';

    protected $fillable = [
        'student_id_number',
        'first_name',
        'middle_name',
        'last_name',
        'email',
        'contact_num',
        'program',
        'year_level',
        'member_status_id',
    ];

    public function memberAuth()
    {
        return $this->hasOne(MemberAuth::class, 'member_id', 'member_id');
    }

    public function bookBorrows()
    {
        return $this->hasMany(BookBorrow::class, 'member_id', 'member_id');
    }

    public function bookRequests()
    {
        return $this->hasMany(BookRequest::class, 'member_id', 'member_id');
    }
}
