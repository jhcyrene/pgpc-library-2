<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BookData extends Model
{
    use HasFactory;

    protected $table = 'book_data';
    protected $primaryKey = 'book_data_id';

    protected $fillable = [
        'book_title',
        'subtitle',
        'description',
        'series_title',
        'notes',
        'language',
        'copyright_year',
        'marc_record',
    ];

    public function getTitleAttribute()
    {
        return $this->attributes['book_title'] ?? null;
    }

    public function authors()
    {
        return $this->belongsToMany(Author::class, 'book_author', 'book_data_id', 'author_id')->withPivot('role');
    }

    public function categories()
    {
        return $this->belongsToMany(Category::class, 'book_category', 'book_data_id', 'category_id')->withTimestamps();
    }

    public function bookDetail()
    {
        return $this->hasOne(BookDetail::class, 'book_data_id', 'book_data_id');
    }

    public function books()
    {
        return $this->hasMany(Book::class, 'book_data_id', 'book_data_id');
    }
}