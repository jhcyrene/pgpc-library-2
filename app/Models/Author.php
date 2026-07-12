<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Author extends Model
{
    use HasFactory;

    protected $primaryKey = 'author_id';

    protected $fillable = [
        'first_name',
        'middle_name',
        'last_name',
        'suffix',
    ];

    public function bookData()
    {
        return $this->belongsToMany(BookData::class, 'book_author', 'author_id', 'book_data_id')->withPivot('role');
    }
}
