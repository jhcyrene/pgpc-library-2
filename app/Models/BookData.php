<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BookData extends Model
{
    protected $fillable = [
        'call_number', //
        'isbn', //
        'book_title',//
        'author',//
        'classification_letter',//
        'category_id',//
        'publisher_id',//
        'publication_year',//
        'edition',//
        'description',//
        'copies_total',//
        'copies_available',//
        'cover_image',//
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

    public function classification()
    {
        return $this->belongsTo(Classification::class, 'classification_letter', 'letter');
    }
}
