<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    use HasFactory;
    protected $fillable = [
        'accession_id',
        'book_data_id',
        'status',
        'lastModified'
    ];

    public function bookData()
    {
        return $this->belongsTo(BookData::class);
    }

    public function authors()
    {
        return $this->belongsToMany(Author::class,'book_authors');
    }

    public function borrows()
    {
        return $this->hasMany(BookBorrow::class);
    }

    public function requests()
    {
        return $this->hasMany(BookRequest::class);
    }
}
