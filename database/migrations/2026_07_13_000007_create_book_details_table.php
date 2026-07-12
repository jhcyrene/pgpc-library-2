<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('book_details', function (Blueprint $table) {
            $table->id();
            $table->foreignId('book_data_id')->constrained('book_data', 'book_data_id')->cascadeOnDelete();
            $table->string('isbn')->nullable()->index();
            $table->string('issn')->nullable()->index();
            $table->foreignId('publisher_id')->nullable()->constrained('publishers', 'publisher_id')->nullOnDelete();
            $table->year('publication_year')->nullable();
            $table->string('edition')->nullable();
            $table->string('pages')->nullable();
            $table->string('call_number')->nullable()->index();
            $table->string('classification')->nullable()->index();
            $table->string('book_type')->nullable();
            $table->string('format')->nullable();
            $table->string('cover_image')->nullable();
            $table->timestamps();
            
            $table->unique('book_data_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('book_details');
    }
};
