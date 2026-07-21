<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('book_borrows', function (Blueprint $table) {
            $table->id('borrow_id');
            $table->foreignId('book_id')->constrained('books', 'book_id')->cascadeOnDelete();
            $table->foreignId('member_id')->constrained('members', 'member_id')->cascadeOnDelete();
            $table->foreignId('librarian_id')->nullable()->constrained('librarians', 'librarian_id')->nullOnDelete();
            $table->dateTime('issue_date');
            $table->dateTime('due_date');
            $table->dateTime('return_date')->nullable();
            $table->string('status');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('book_borrows');
    }
};
