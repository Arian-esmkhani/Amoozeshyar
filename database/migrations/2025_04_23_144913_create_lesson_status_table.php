<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('lesson_status', function (Blueprint $table) {
            $table->id();
            $table->integer('lesson_id');
            $table->string('lesson_name', 45)->nullable();
            $table->string('student_name', 45);
            $table->string('master_name', 45);
            $table->integer('lesson_score')->nullable();
            $table->string('lesson_status', 45)->default('فعال');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('lesson_status');
    }
};
