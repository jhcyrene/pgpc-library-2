<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FineDue extends Model
{
    use HasFactory;

    protected $primaryKey = 'fine_id';

    protected $fillable = [
        'borrow_id',
        'fine_date',
        'fine_total',
        'fine_status',
        'remarks',
    ];

    protected $casts = [
        'fine_date' => 'date',
        'fine_total' => 'decimal:2',
    ];

    public function bookBorrow()
    {
        return $this->belongsTo(BookBorrow::class, 'borrow_id', 'borrow_id');
    }

    public function finePayments()
    {
        return $this->hasMany(FinePayment::class, 'fine_id', 'fine_id');
    }
}
