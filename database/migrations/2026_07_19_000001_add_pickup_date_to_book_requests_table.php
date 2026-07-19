<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (! Schema::hasColumn('book_requests', 'pickup_date')) {
            Schema::table('book_requests', function (Blueprint $table) {
                $table->dateTime('pickup_date')->nullable()->after('request_date');
            });
        }
    }

    public function down(): void
    {
        if (Schema::hasColumn('book_requests', 'pickup_date')) {
            Schema::table('book_requests', function (Blueprint $table) {
                $table->dropColumn('pickup_date');
            });
        }
    }
};
