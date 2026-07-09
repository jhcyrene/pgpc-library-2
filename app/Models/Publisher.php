<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Publisher extends Model
{
    use HasFactory;
    protected $fillable = [
        'publisher_name',
        'publication_origin',
        'publication_type'
    ];

    public function bookData()
    {
        return $this->hasMany(BookData::class);
    }
}
