<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    protected $primaryKey = 'category_id';

    protected $fillable = [
        'category_name',
        'description',
    ];

    public function bookData()
    {
        return $this->belongsToMany(BookData::class, 'book_category', 'category_id', 'book_data_id')->withTimestamps();
    }
}