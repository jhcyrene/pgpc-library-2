<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('member_auth', function (Blueprint $table) {
            $table->id('member_auth_id');
            $table->foreignId('member_id')->nullable()->constrained('members', 'member_id')->nullOnDelete();
            $table->foreignId('librarian_id')->nullable()->constrained('librarians', 'librarian_id')->nullOnDelete();
            $table->string('account_type');
            $table->string('account_status')->default('Active');
            $table->string('username')->unique();
            $table->string('password_hash')->nullable();
            $table->string('provider')->nullable();
            $table->string('provider_id')->nullable();
            $table->unsignedInteger('failed_attempts')->default(0);
            $table->timestamp('last_login')->nullable();
            $table->timestamp('password_changed_at')->nullable();
            $table->string('password_token')->nullable();
            $table->timestamp('token_expiry')->nullable();
            $table->timestamp('last_modified')->nullable();
            $table->boolean('is_verified')->default(false);
            $table->timestamp('last_login_at')->nullable();
            $table->rememberToken();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('member_auth');
    }
};
