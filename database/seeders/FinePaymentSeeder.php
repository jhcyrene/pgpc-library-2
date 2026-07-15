<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\FinePayment;
use App\Models\FineDue;
use App\Models\Librarian;

class FinePaymentSeeder extends Seeder
{
    public function run(): void
    {
        // Add payments to paid fines
        $paidFines = FineDue::where('fine_status', 'Paid')->get();
        $librarian = Librarian::first();
        
        $counter = 1;
        foreach ($paidFines as $fine) {
            $orNumber = str_pad($counter, 6, '0', STR_PAD_LEFT);
            
            FinePayment::create([
                'fine_id' => $fine->fine_id,
                'payment_date' => $fine->fine_date->modify('+2 days'),
                'payment_amount' => $fine->fine_total,
                'payment_method' => 'Cash',
                'official_receipt_no' => "OR-$orNumber",
                'received_by' => $librarian ? $librarian->librarian_id : null,
            ]);
            $counter++;
        }
    }
}
