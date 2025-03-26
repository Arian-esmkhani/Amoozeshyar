<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('student_data', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users_base')->onDelete('cascade');
            $table->date('enrollment_date');
            $table->date('expected_graduation')->nullable();
            $table->integer('konkoor_number');
            $table->integer('helf_date');
            $table->string('student_number', 20);
            $table->enum('study_type', ['full_time', 'part_time', 'distance_learning'])->default('full_time');
            $table->enum('degree_level', ['associate', 'bachelor', 'master', 'doctorate']);
            $table->string('major', 100);
            $table->string('faculty', 100);
            $table->timestamps();
            $table->softDeletes();

            $table->index('student_number');
            $table->index(['major', 'faculty']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('student_data');
    }
};
