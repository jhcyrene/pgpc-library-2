<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Librarian extends Model
{
    protected $fillable = [
        'librarian_number',
        'first_name',
        'last_name'
    ];
}
