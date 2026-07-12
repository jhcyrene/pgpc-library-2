<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BookRequestStatus extends Model
{
    use HasFactory;

    protected $primaryKey = 'book_request_status_id';

    protected $fillable = [
        'status_name',
        'description',
    ];

    public function bookRequests()
    {
        return $this->hasMany(BookRequest::class, 'book_request_status_id', 'book_request_status_id');
    }
}
