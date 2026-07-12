<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    use HasFactory;

    protected $primaryKey = 'book_id';

    protected $fillable = [
        'book_data_id',
        'accession_number',
        'barcode',
        'status',
        'location',
        'date_acquired',
        'last_modified',
    ];

    protected $casts = [
        'date_acquired' => 'date',
        'last_modified' => 'datetime',
    ];

    public function bookData()
    {
        return $this->belongsTo(BookData::class, 'book_data_id', 'book_data_id');
    }

    public function bookBorrows()
    {
        return $this->hasMany(BookBorrow::class, 'book_id', 'book_id');
    }

    public function bookRequests()
    {
        return $this->hasMany(BookRequest::class, 'book_id', 'book_id');
    }
}