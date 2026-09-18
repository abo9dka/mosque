<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * جدول أسبوعي متكرر (وليس مرتبطًا بتاريخ محدد): كل عنصر يخص يومًا من
     * أيام الأسبوع (0 = الأحد .. 6 = السبت، وفق ترقيم Carbon/PHP نفسه)
     * ويُعرض كل يوم لكل من الأستاذ وولي الأمر حسب يوم اليوم الحالي.
     */
    public function up(): void
    {
        Schema::create('schedule_items', function (Blueprint $table) {
            $table->id();
            $table->unsignedTinyInteger('day_of_week'); // 0=الأحد ... 6=السبت (Carbon)
            $table->string('content');
            $table->unsignedInteger('sort_order')->default(0);
            $table->timestamps();

            $table->index(['day_of_week', 'sort_order']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('schedule_items');
    }
};
