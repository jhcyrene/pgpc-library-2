<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BookDetail extends Model
{
    use HasFactory;

    protected $fillable = [
        'book_data_id',
        'isbn',
        'issn',
        'publisher_id',
        'publication_year',
        'edition',
        'pages',
        'call_number',
        'classification',
        'book_type',
        'format',
        'cover_image',
    ];

    public function bookData()
    {
        return $this->belongsTo(BookData::class, 'book_data_id', 'book_data_id');
    }

    public function publisher()
    {
        return $this->belongsTo(Publisher::class, 'publisher_id', 'publisher_id');
    }
}
