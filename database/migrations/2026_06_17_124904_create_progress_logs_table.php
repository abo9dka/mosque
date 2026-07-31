<?php


    use Illuminate\Database\Migrations\Migration;
    use Illuminate\Database\Schema\Blueprint;
    use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('progress_logs', function (Blueprint $table) {
            $table->id();

            // علاقة الطالب
            $table->foreignId('student_id')->constrained()->cascadeOnDelete();

            // نوع السجل
            $table->enum('type', ['memorization', 'big_review']);

            /*
            =========================
            الحفظ الجديد
            =========================
            */
            $table->string('surah')->nullable();
            $table->integer('from_ayah')->nullable();
            $table->integer('to_ayah')->nullable();
            $table->integer('score')->nullable();

            $table->string('homework')->nullable();
            $table->string('daily_review')->nullable();
            $table->integer('review_score')->nullable();
            $table->string('review_homework')->nullable();
            $table->text('notes')->nullable();

            /*
            =========================
            المراجعة الكبرى
            =========================
            */
            $table->string('weekly_memorization')->nullable();
            // (score already exists)
            // (review_homework already exists)

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('student_progress');
    }
};
