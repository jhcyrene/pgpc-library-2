<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BookBorrow extends Model
{
    use HasFactory;

    protected $primaryKey = 'borrow_id';

    protected $fillable = [
        'book_id',
        'member_id',
        'librarian_id',
        'issue_date',
        'due_date',
        'return_date',
        'status',
    ];

    protected $casts = [
        'issue_date' => 'datetime',
        'due_date' => 'datetime',
        'return_date' => 'datetime',
    ];

    public function book()
    {
        return $this->belongsTo(Book::class, 'book_id', 'book_id');
    }

    public function member()
    {
        return $this->belongsTo(Member::class, 'member_id', 'member_id');
    }

    public function librarian()
    {
        return $this->belongsTo(Librarian::class, 'librarian_id', 'librarian_id');
    }

    public function fineDue()
    {
        return $this->hasOne(FineDue::class, 'borrow_id', 'borrow_id');
    }
}
