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
        Schema::table('member_auth', function (Blueprint $table) {
            if (!Schema::hasColumn('member_auth', 'provider')) {
                $table->string('provider')->nullable()->after('password_hash');
            }
            if (!Schema::hasColumn('member_auth', 'provider_id')) {
                $table->string('provider_id')->nullable()->after('provider');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('member_auth', function (Blueprint $table) {
            if (Schema::hasColumn('member_auth', 'provider_id')) {
                $table->dropColumn('provider_id');
            }
            if (Schema::hasColumn('member_auth', 'provider')) {
                $table->dropColumn('provider');
            }
        });
    }
};
