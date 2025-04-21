<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('term_access', function (Blueprint $table) {
            $table->id();
            $table->integer('term_number'); // شماره ترم
            $table->boolean('is_active')->default(false); // آیا دسترسی فعال است؟
            $table->dateTime('start_date')->nullable(); // تاریخ شروع دسترسی
            $table->dateTime('end_date')->nullable(); // تاریخ پایان دسترسی
            $table->text('message')->nullable(); // پیام نمایشی برای کاربران بدون دسترسی
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('term_access');
    }
};
