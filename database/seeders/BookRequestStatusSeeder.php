<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\BookRequestStatus;

class BookRequestStatusSeeder extends Seeder
{
    public function run(): void
    {
        $statuses = [
            'Pending',
            'Approved',
            'Ready for Pickup',
            'Completed',
            'Cancelled',
            'Rejected',
            'Expired',
        ];

        foreach ($statuses as $status) {
            BookRequestStatus::firstOrCreate(
                ['status_name' => $status]
            );
        }
    }
}
