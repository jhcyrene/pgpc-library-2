<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FinePayment extends Model
{
    use HasFactory;

    protected $primaryKey = 'fine_payment_id';

    protected $fillable = [
        'fine_id',
        'payment_date',
        'payment_amount',
        'payment_method',
        'official_receipt_no',
        'received_by',
        'remarks',
    ];

    protected $casts = [
        'payment_date' => 'datetime',
        'payment_amount' => 'decimal:2',
    ];

    public function fineDue()
    {
        return $this->belongsTo(FineDue::class, 'fine_id', 'fine_id');
    }

    public function librarian()
    {
        return $this->belongsTo(Librarian::class, 'received_by', 'librarian_id');
    }
}
