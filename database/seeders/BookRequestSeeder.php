<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\BookRequest;
use App\Models\BookData;
use App\Models\Member;
use App\Models\BookRequestStatus;
use App\Models\Book;

class BookRequestSeeder extends Seeder
{
    public function run(): void
    {
        $booksData = BookData::all();
        $members = Member::all();
        $statuses = BookRequestStatus::all()->keyBy('status_name');
        
        $requestsToMake = 10;
        
        for ($i = 0; $i < $requestsToMake; $i++) {
            $book = $booksData->random();
            $member = $members->random();
            
            // Check if active request already exists to prevent duplicate
            $existing = BookRequest::where('member_id', $member->member_id)
                ->where('book_data_id', $book->book_data_id)
                ->whereIn('book_request_status_id', [
                    $statuses['Pending']->book_request_status_id,
                    $statuses['Approved']->book_request_status_id,
                    $statuses['Ready for Pickup']->book_request_status_id
                ])
                ->exists();
                
            if ($existing) continue;
            
            $statusKeys = array_keys($statuses->toArray());
            $randomStatusName = $statusKeys[array_rand($statusKeys)];
            $status = $statuses[$randomStatusName];
            
            $reqDate = now()->subDays(rand(1, 30));
            $physicalBookId = null;
            $approvedAt = null;
            $readyAt = null;
            $fulfilledAt = null;
            $cancelledAt = null;
            
            if (in_array($randomStatusName, ['Approved', 'Ready for Pickup', 'Completed'])) {
                $approvedAt = (clone $reqDate)->modify('+1 day');
            }
            if (in_array($randomStatusName, ['Ready for Pickup', 'Completed'])) {
                $readyAt = (clone $reqDate)->modify('+2 days');
                $physicalBook = Book::where('book_data_id', $book->book_data_id)->first();
                $physicalBookId = $physicalBook ? $physicalBook->book_id : null;
            }
            if ($randomStatusName === 'Completed') {
                $fulfilledAt = (clone $reqDate)->modify('+3 days');
            }
            if ($randomStatusName === 'Cancelled') {
                $cancelledAt = (clone $reqDate)->modify('+1 day');
            }
            
            BookRequest::create([
                'book_data_id' => $book->book_data_id,
                'book_id' => $physicalBookId,
                'member_id' => $member->member_id,
                'book_request_status_id' => $status->book_request_status_id,
                'request_date' => $reqDate,
                'approved_at' => $approvedAt,
                'ready_at' => $readyAt,
                'fulfilled_at' => $fulfilledAt,
                'cancelled_at' => $cancelledAt,
                'expires_at' => (clone $reqDate)->modify('+5 days'),
            ]);
        }
    }
}
