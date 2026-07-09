<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BookBorrow extends Model
{
    use HasFactory;
    protected $fillable = [
        'book_id',
        'member_id',
        'issue_date',
        'return_date',
        'issue_status',
        'issued_by_staff_id'
    ];
}
