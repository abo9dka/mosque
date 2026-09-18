<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('progress_logs', function (Blueprint $table) {
            $table->unsignedTinyInteger('surah_number')->nullable()->after('surah');
        });
    }

    public function down(): void
    {
        Schema::table('progress_logs', function (Blueprint $table) {
            $table->dropColumn('surah_number');
        });
    }
};
