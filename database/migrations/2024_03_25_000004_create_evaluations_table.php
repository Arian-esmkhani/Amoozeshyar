<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('evaluations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('course_id')->constrained()->onDelete('cascade');
            $table->integer('teaching_quality');
            $table->integer('course_content');
            $table->integer('classroom_management');
            $table->integer('student_interaction');
            $table->text('comments')->nullable();
            $table->timestamps();

            $table->unique(['user_id', 'course_id']);
            $table->index(['user_id', 'created_at']);
            $table->index(['course_id', 'created_at']);
        });

        // اضافه کردن فیلدهای میانگین به جدول دروس
        Schema::table('courses', function (Blueprint $table) {
            $table->decimal('average_teaching_quality', 3, 2)->nullable();
            $table->decimal('average_course_content', 3, 2)->nullable();
            $table->decimal('average_classroom_management', 3, 2)->nullable();
            $table->decimal('average_student_interaction', 3, 2)->nullable();
            $table->integer('evaluation_count')->default(0);
        });
    }

    public function down(): void
    {
        Schema::table('courses', function (Blueprint $table) {
            $table->dropColumn([
                'average_teaching_quality',
                'average_course_content',
                'average_classroom_management',
                'average_student_interaction',
                'evaluation_count'
            ]);
        });

        Schema::dropIfExists('evaluations');
    }
};
