<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Librarian extends Model
{
    use HasFactory;

    protected $primaryKey = 'librarian_id';

    protected $fillable = [
        'employee_number',
        'first_name',
        'middle_name',
        'last_name',
        'email',
        'position',
    ];

    public function memberAuth()
    {
        return $this->hasOne(MemberAuth::class, 'librarian_id', 'librarian_id');
    }

    public function bookBorrows()
    {
        return $this->hasMany(BookBorrow::class, 'librarian_id', 'librarian_id');
    }

    public function finePayments()
    {
        return $this->hasMany(FinePayment::class, 'received_by', 'librarian_id');
    }
}
