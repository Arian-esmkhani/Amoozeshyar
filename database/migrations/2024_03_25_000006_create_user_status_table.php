<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('user_status', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users_base')->onDelete('cascade');
            $table->integer('min_unit')->default(12);
            $table->integer('max_unit')->default(20);
            $table->integer('passed_units')->default(0);
            $table->integer('loss_units')->default(0);
            $table->integer('unit_interm')->default(0);
            $table->integer('unit_intership')->default(0);
            $table->integer('free_unit')->default(0);
            $table->integer('pass_term')->default(0);
            $table->json('take_listen')->nullable();
            $table->integer('allowed_term')->default(8);
            $table->enum('student_status', ['active', 'probation', 'suspended', 'graduated', 'withdrawn'])->default('active');
            $table->enum('can_take_courses', ['yes', 'no'])->default('yes');
            $table->text('academic_notes')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->index(['user_id', 'student_status']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('user_status');
    }
};
