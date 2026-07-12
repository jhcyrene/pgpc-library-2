<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BookRequest extends Model
{
    use HasFactory;

    protected $primaryKey = 'book_request_id';

    protected $fillable = [
        'book_data_id',
        'book_id',
        'member_id',
        'book_request_status_id',
        'request_date',
        'approved_at',
        'ready_at',
        'fulfilled_at',
        'cancelled_at',
        'expires_at',
        'remarks',
    ];

    protected $casts = [
        'request_date' => 'datetime',
        'approved_at' => 'datetime',
        'ready_at' => 'datetime',
        'fulfilled_at' => 'datetime',
        'cancelled_at' => 'datetime',
        'expires_at' => 'datetime',
    ];

    public function bookData()
    {
        return $this->belongsTo(BookData::class, 'book_data_id', 'book_data_id');
    }

    public function book()
    {
        return $this->belongsTo(Book::class, 'book_id', 'book_id');
    }

    public function member()
    {
        return $this->belongsTo(Member::class, 'member_id', 'member_id');
    }

    public function bookRequestStatus()
    {
        return $this->belongsTo(BookRequestStatus::class, 'book_request_status_id', 'book_request_status_id');
    }
}
