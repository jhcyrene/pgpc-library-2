<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BookAuthor extends Model
{
    protected $fillable = [
        'bookData_id',
        'author_id'
    ];

    public $timestamps = false;
}
