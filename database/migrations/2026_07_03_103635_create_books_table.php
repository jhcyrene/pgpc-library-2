<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('books', function (Blueprint $table) {
            $table->id();

            $table->foreignId('book_data_id')
                ->constrained('book_data')
                ->cascadeOnDelete();

            $table->string('accession_number')->unique();

            $table->enum('status', [
                'Available',
                'Borrowed',
                'Reserved',
                'Lost',
                'Damaged'
            ])->default('Available');

            $table->timestamp('last_modified')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('books');
    }
};
