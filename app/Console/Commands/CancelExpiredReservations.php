<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\BookRequest;
use App\Models\BookRequestStatus;
use Illuminate\Support\Facades\DB;

class CancelExpiredReservations extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'reservations:cancel-expired';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Cancel reservations that have passed their expiration date';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $expiredStatus = BookRequestStatus::whereRaw('LOWER(status_name) = ?', ['expired'])->first();
        
        if (!$expiredStatus) {
            $this->error('Expired status not found in database.');
            return;
        }

        $readyForPickupStatus = BookRequestStatus::whereRaw('LOWER(status_name) = ?', ['ready for pickup'])->first();

        if (!$readyForPickupStatus) {
            $this->error('Ready for pickup status not found.');
            return;
        }

        $expiredReservations = BookRequest::where('book_request_status_id', $readyForPickupStatus->book_request_status_id)
            ->whereNotNull('expires_at')
            ->where('expires_at', '<', now())
            ->get();

        if ($expiredReservations->isEmpty()) {
            $this->info('No expired reservations found.');
            return;
        }

        $count = 0;
        foreach ($expiredReservations as $reservation) {
            DB::transaction(function () use ($reservation, $expiredStatus) {
                $reservation->book_request_status_id = $expiredStatus->book_request_status_id;
                $reservation->cancelled_at = now();
                $reservation->remarks = trim($reservation->remarks . "\nSystem: Auto-cancelled due to not being picked up on time.");
                
                // Clear the assigned book so it can be picked up by someone else
                $reservation->book_id = null;

                $reservation->save();
            });
            $count++;
        }

        $this->info("Successfully cancelled {$count} expired reservations.");
    }
}
