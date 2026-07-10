<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $fillable = [
        'letter',
        'category_name'
    ];

    public function bookData()
    {
        return $this->hasMany(BookData::class);
    }
}
