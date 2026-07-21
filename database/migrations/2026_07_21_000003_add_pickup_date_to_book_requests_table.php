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
        Schema::table('book_requests', function (Blueprint $table) {
            if (!Schema::hasColumn('book_requests', 'pickup_date')) {
                $table->date('pickup_date')->nullable()->after('request_date');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('book_requests', function (Blueprint $table) {
            if (Schema::hasColumn('book_requests', 'pickup_date')) {
                $table->dropColumn('pickup_date');
            }
        });
    }
};
