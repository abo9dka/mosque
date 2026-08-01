<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Widen the enum first so existing 'غائب' rows stay valid while we migrate them.
        DB::statement("ALTER TABLE attendance_logs MODIFY status ENUM('حاضر', 'غائب', 'غياب بعذر', 'غياب بدون عذر', 'متأخر') NOT NULL");

        // Existing absences had no excuse-tracking, so treat them as unexcused.
        DB::table('attendance_logs')->where('status', 'غائب')->update(['status' => 'غياب بدون عذر']);

        DB::statement("ALTER TABLE attendance_logs MODIFY status ENUM('حاضر', 'غياب بعذر', 'غياب بدون عذر', 'متأخر') NOT NULL");

        Schema::table('attendance_logs', function (Blueprint $table) {
            $table->string('absence_reason')->nullable()->after('status');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('attendance_logs', function (Blueprint $table) {
            $table->dropColumn('absence_reason');
        });

        DB::statement("ALTER TABLE attendance_logs MODIFY status ENUM('حاضر', 'غياب بعذر', 'غياب بدون عذر', 'متأخر') NOT NULL");

        DB::table('attendance_logs')
            ->whereIn('status', ['غياب بعذر', 'غياب بدون عذر'])
            ->update(['status' => 'غائب']);

        DB::statement("ALTER TABLE attendance_logs MODIFY status ENUM('حاضر', 'غائب', 'متأخر') NOT NULL");
    }
};
