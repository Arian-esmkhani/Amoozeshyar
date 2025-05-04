<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('users_gpa', function (Blueprint $table) {
            $table->id(); // شناسه‌ی یکتا برای هر رکورد
            $table->foreignId('user_id')->constrained('users_base')->onDelete('cascade'); // شناسه‌ی کاربر با رابطه‌ی خارجی
            $table->decimal('semester_gpa', 4, 2)->nullable(); // معدل ترم جاری
            $table->decimal('last_gpa', 4, 2)->nullable(); // معدل ترم قبل
            $table->decimal('cumulative_gpa', 4, 2)->nullable(); // معدل کل
            $table->decimal('major_gpa', 4, 2)->nullable(); // معدل رشته‌ی تخصصی
            $table->decimal('general_gpa', 4, 2)->nullable(); // معدل عمومی
            $table->integer('total_units')->default(0); // مجموع واحدهای گذرانده شده
            $table->longText('passed_listen')->nullable(); // لیست دروس گذرانده شده
            $table->enum('academic_status', ['active', 'probation', 'suspended', 'graduated', 'withdrawn'])->default('active'); // وضعیت تحصیلی
            $table->timestamps(); // زمان ایجاد و آخرین تغییر
            $table->softDeletes(); // قابلیت حذف نرم (soft delete)
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('users_gpa'); // حذف جدول در صورت برگشت تغییرات
    }
};
