<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Publisher extends Model
{
    use HasFactory;

    protected $primaryKey = 'publisher_id';

    protected $fillable = [
        'publisher_name',
        'publication_origin',
        'publication_type',
    ];

    public function bookDetails()
    {
        return $this->hasMany(BookDetail::class, 'publisher_id', 'publisher_id');
    }
}
