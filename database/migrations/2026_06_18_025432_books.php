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
        Schema::create('books',function(Blueprint $table){
            $table->id();
            $table->string('BookID',10);
            $table->string('ISBN',20);
            $table->string('BookTitle',150);
            $table->date('DatePublished');
            $table->string('Author',10);
            $table->string('Publisher',10);
            $table->string('Category',10);
            $table->string('SubCategory',30);
            $table->string('Status',10);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
