<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('fine_dues', function (Blueprint $table) {
            $table->id('fine_id');
            $table->foreignId('borrow_id')->unique()->constrained('book_borrows', 'borrow_id')->cascadeOnDelete();
            $table->date('fine_date');
            $table->decimal('fine_total', 10, 2);
            $table->string('fine_status');
            $table->text('remarks')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('fine_dues');
    }
};
