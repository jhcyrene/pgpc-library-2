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
        Schema::create('saved_items', function (Blueprint $table) {
            $table->id('saved_item_id');
            $table->unsignedBigInteger('member_id');
            $table->unsignedBigInteger('book_data_id');
            $table->timestamps();

            // Prevent duplicate saved items
            $table->unique(['member_id', 'book_data_id']);
            
            $table->foreign('member_id')->references('member_id')->on('members')->cascadeOnDelete();
            $table->foreign('book_data_id')->references('book_data_id')->on('book_data')->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('saved_items');
    }
};
