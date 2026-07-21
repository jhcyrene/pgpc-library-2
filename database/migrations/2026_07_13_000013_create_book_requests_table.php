<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('book_requests', function (Blueprint $table) {
            $table->id('book_request_id');
            $table->foreignId('book_data_id')->constrained('book_data', 'book_data_id')->cascadeOnDelete();
            $table->foreignId('book_id')->nullable()->constrained('books', 'book_id')->nullOnDelete();
            $table->foreignId('member_id')->constrained('members', 'member_id')->cascadeOnDelete();
            $table->foreignId('book_request_status_id')->constrained('book_request_statuses', 'book_request_status_id')->cascadeOnDelete();
            $table->dateTime('request_date');
            $table->date('pickup_date')->nullable();
            $table->dateTime('approved_at')->nullable();
            $table->dateTime('ready_at')->nullable();
            $table->dateTime('fulfilled_at')->nullable();
            $table->dateTime('cancelled_at')->nullable();
            $table->dateTime('expires_at')->nullable();
            $table->text('remarks')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('book_requests');
    }
};
