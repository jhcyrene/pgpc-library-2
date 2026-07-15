<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('book_data', function (Blueprint $table) {
            $table->id('book_data_id');
            $table->string('book_title');
            $table->string('subtitle')->nullable();
            $table->text('description')->nullable();
            $table->string('series_title')->nullable();
            $table->text('notes')->nullable();
            $table->string('language')->nullable();
            $table->year('copyright_year')->nullable();
            $table->longText('marc_record')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('book_data');
    }
};
