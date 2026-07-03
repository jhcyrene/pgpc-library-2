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
        Schema::create('book_data', function (Blueprint $table) {
            $table->id();

            $table->string('call_number')->unique();
            $table->string('isbn')->unique();
            $table->string('book_title');

            $table->foreignId('category_id')
                ->constrained('categories')
                ->cascadeOnDelete();

            $table->foreignId('publisher_id')
                ->constrained('publishers')
                ->cascadeOnDelete();

            $table->year('publication_year')->nullable();
            $table->string('edition')->nullable();
            $table->text('description')->nullable();

            $table->unsignedInteger('copies_total')->default(1);
            $table->unsignedInteger('copies_available')->default(1);

            $table->timestamp('date_created')->useCurrent();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('book_data');
    }
};
