<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('books', function (Blueprint $table) {
            $table->id('book_id');
            $table->foreignId('book_data_id')->constrained('book_data', 'book_data_id')->cascadeOnDelete();
            $table->string('accession_number')->unique();
            $table->string('barcode')->nullable()->unique();
            $table->string('status')->default('Available');
            $table->string('location')->nullable();
            $table->date('date_acquired')->nullable();
            $table->timestamp('last_modified')->nullable();
            $table->timestamps();
            
            $table->index('book_data_id');
            $table->index('status');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('books');
    }
};
