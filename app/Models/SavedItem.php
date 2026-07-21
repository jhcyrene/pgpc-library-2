<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SavedItem extends Model
{
    use HasFactory;

    protected $primaryKey = 'saved_item_id';

    protected $fillable = [
        'member_id',
        'book_data_id',
    ];

    public function member()
    {
        return $this->belongsTo(Member::class, 'member_id', 'member_id');
    }

    public function bookData()
    {
        return $this->belongsTo(BookData::class, 'book_data_id', 'book_data_id');
    }
}
