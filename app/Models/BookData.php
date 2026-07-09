<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BookData extends Model
{
    use HasFactory;
    protected $fillable = [
        'call_number',
        'ISBN_code',
        'book_title',
        'category_id',
        'publisher_id',
        'publication_year',
        'book_edition',
        'book_description',
        'copies_total',
        'copies_available',
        'location_id',
        'dateCreated'
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function publisher()
    {
        return $this->belongsTo(Publisher::class);
    }

    public function books()
    {
        return $this->hasMany(Book::class);
    }
}
