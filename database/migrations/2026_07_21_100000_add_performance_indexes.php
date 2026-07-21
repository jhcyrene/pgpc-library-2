<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // -------------------------------------------------------
        // book_requests
        // Powers: reservations list, student reservation history,
        //         expiry jobs, status filtering
        // -------------------------------------------------------
        Schema::table('book_requests', function (Blueprint $table) {
            // Filter by status (pending / approved / ready for pickup)
            $table->index('book_request_status_id', 'idx_br_status');

            // Load all requests belonging to one member
            $table->index('member_id', 'idx_br_member');

            // Sort reservations by date (list page default order)
            $table->index('request_date', 'idx_br_request_date');

            // Background job: find reservations that have expired
            $table->index('expires_at', 'idx_br_expires_at');

            // Composite: active reservations per member
            // (WHERE member_id = ? AND book_request_status_id = ?)
            $table->index(['member_id', 'book_request_status_id'], 'idx_br_member_status');
        });

        // -------------------------------------------------------
        // book_borrows
        // Powers: borrow history per member, overdue checks,
        //         book circulation history
        // -------------------------------------------------------
        Schema::table('book_borrows', function (Blueprint $table) {
            // Load all borrows for a member
            $table->index('member_id', 'idx_bb_member');

            // Borrow history for a specific book copy
            $table->index('book_id', 'idx_bb_book');

            // Filter active/returned borrows
            $table->index('status', 'idx_bb_status');

            // Detect overdue borrows: WHERE due_date < NOW()
            $table->index('due_date', 'idx_bb_due_date');

            // Composite: active borrows per member
            // (WHERE member_id = ? AND status = 'Borrowed')
            $table->index(['member_id', 'status'], 'idx_bb_member_status');
        });

        // -------------------------------------------------------
        // fine_dues
        // Powers: fine reports, unpaid fine checks per member
        // -------------------------------------------------------
        Schema::table('fine_dues', function (Blueprint $table) {
            // Filter paid vs unpaid fines
            $table->index('fine_status', 'idx_fd_status');

            // Date-range reports: WHERE fine_date BETWEEN ? AND ?
            $table->index('fine_date', 'idx_fd_date');
        });

        // -------------------------------------------------------
        // book_data
        // Powers: catalog search, book listing, filtering
        // -------------------------------------------------------
        Schema::table('book_data', function (Blueprint $table) {
            // Filter by year
            $table->index('copyright_year', 'idx_bd_year');

            // Filter by language
            $table->index('language', 'idx_bd_language');
        });

        // PostgreSQL GIN index on tsvector for fast full-text search on book_title
        // Replaces slow LIKE '%keyword%' full-table scans.
        // Usage: BookData::whereRaw("to_tsvector('english', book_title) @@ plainto_tsquery('english', ?)", [$query])
        DB::statement("CREATE INDEX idx_bd_title_fulltext ON book_data USING GIN (to_tsvector('english', book_title))");


        // -------------------------------------------------------
        // members
        // Powers: member search, program filtering, status filters
        // -------------------------------------------------------
        Schema::table('members', function (Blueprint $table) {
            // Search by last name prefix (WHERE last_name LIKE 'S%')
            $table->index('last_name', 'idx_m_last_name');

            // Filter by course/program
            $table->index('program', 'idx_m_program');

            // Filter active/inactive/suspended members
            $table->index('member_status_id', 'idx_m_status');
        });

        // -------------------------------------------------------
        // member_auth
        // Powers: login, OAuth (social login), account type filters
        // -------------------------------------------------------
        Schema::table('member_auth', function (Blueprint $table) {
            // Distinguish admin vs student accounts
            $table->index('account_type', 'idx_ma_account_type');

            // Filter active/locked accounts
            $table->index('account_status', 'idx_ma_account_status');

            // Composite: social login lookup
            // (WHERE provider = 'google' AND provider_id = ?)
            $table->index(['provider', 'provider_id'], 'idx_ma_provider');
        });
    }

    public function down(): void
    {
        Schema::table('book_requests', function (Blueprint $table) {
            $table->dropIndex('idx_br_status');
            $table->dropIndex('idx_br_member');
            $table->dropIndex('idx_br_request_date');
            $table->dropIndex('idx_br_expires_at');
            $table->dropIndex('idx_br_member_status');
        });

        Schema::table('book_borrows', function (Blueprint $table) {
            $table->dropIndex('idx_bb_member');
            $table->dropIndex('idx_bb_book');
            $table->dropIndex('idx_bb_status');
            $table->dropIndex('idx_bb_due_date');
            $table->dropIndex('idx_bb_member_status');
        });

        Schema::table('fine_dues', function (Blueprint $table) {
            $table->dropIndex('idx_fd_status');
            $table->dropIndex('idx_fd_date');
        });

        Schema::table('book_data', function (Blueprint $table) {
            $table->dropIndex('idx_bd_year');
            $table->dropIndex('idx_bd_language');
        });

        DB::statement('DROP INDEX IF EXISTS idx_bd_title_fulltext');

        Schema::table('members', function (Blueprint $table) {
            $table->dropIndex('idx_m_last_name');
            $table->dropIndex('idx_m_program');
            $table->dropIndex('idx_m_status');
        });

        Schema::table('member_auth', function (Blueprint $table) {
            $table->dropIndex('idx_ma_account_type');
            $table->dropIndex('idx_ma_account_status');
            $table->dropIndex('idx_ma_provider');
        });
    }
};
