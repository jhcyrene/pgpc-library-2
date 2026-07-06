<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BookRequest_Status extends Model
{
    protected $fillable = [
        'available_status_id',
        'available_date',
        'nearest_available_date'
    ];

    public function requests()
    {
        return $this->hasMany(BookRequest::class,'available_status_id');
    }
}
