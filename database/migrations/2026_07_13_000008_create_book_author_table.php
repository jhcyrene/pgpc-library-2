<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('book_author', function (Blueprint $table) {
            $table->id('book_author_id');
            $table->foreignId('book_data_id')->constrained('book_data', 'book_data_id')->cascadeOnDelete();
            $table->foreignId('author_id')->constrained('authors', 'author_id')->cascadeOnDelete();
            $table->string('role')->nullable();
            
            $table->unique(['book_data_id', 'author_id', 'role']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('book_author');
    }
};
