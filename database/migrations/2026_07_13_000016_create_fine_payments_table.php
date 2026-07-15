<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('fine_payments', function (Blueprint $table) {
            $table->id('fine_payment_id');
            $table->foreignId('fine_id')->constrained('fine_dues', 'fine_id')->cascadeOnDelete();
            $table->dateTime('payment_date');
            $table->decimal('payment_amount', 10, 2);
            $table->string('payment_method')->nullable();
            $table->string('official_receipt_no')->nullable()->unique();
            $table->foreignId('received_by')->nullable()->constrained('librarians', 'librarian_id')->nullOnDelete();
            $table->text('remarks')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('fine_payments');
    }
};
