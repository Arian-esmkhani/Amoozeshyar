<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('users_gpa', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users_base')->onDelete('cascade');
            $table->decimal('semester_gpa', 4, 2)->nullable();
            $table->decimal('last_gpa', 4, 2)->nullable();
            $table->decimal('cumulative_gpa', 4, 2)->nullable();
            $table->decimal('major_gpa', 4, 2)->nullable();
            $table->decimal('general_gpa', 4, 2)->nullable();
            $table->integer('total_units')->default(0);
            $table->longText('passed_listen')->nullable();
            $table->enum('academic_status', ['active', 'probation', 'suspended', 'graduated', 'withdrawn'])->default('active');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('users_gpa');
    }
};
