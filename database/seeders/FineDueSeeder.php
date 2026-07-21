<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\FineDue;
use App\Models\BookBorrow;

class FineDueSeeder extends Seeder
{
    public function run(): void
    {
        // Add fines to some Overdue records
        $overdueBorrows = BookBorrow::where('status', 'Overdue')->get();
        
        foreach ($overdueBorrows as $borrow) {
            FineDue::firstOrCreate(
                ['borrow_id' => $borrow->borrow_id],
                [
                    'fine_date' => $borrow->due_date->modify('+1 day'),
                    'fine_total' => 100.00,
                    'fine_status' => 'Unpaid',
                ]
            );
        }
        
        // Add some Paid fines to Returned records that were late
        $returnedBorrows = BookBorrow::where('status', 'Returned')
            ->whereColumn('return_date', '>', 'due_date')
            ->get();
            
        foreach ($returnedBorrows as $borrow) {
            FineDue::firstOrCreate(
                ['borrow_id' => $borrow->borrow_id],
                [
                    'fine_date' => $borrow->due_date->modify('+1 day'),
                    'fine_total' => 50.00,
                    'fine_status' => 'Paid',
                ]
            );
        }
    }
}
