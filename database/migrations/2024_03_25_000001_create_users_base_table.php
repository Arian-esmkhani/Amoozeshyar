<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('users_base', function (Blueprint $table) {
            $table->id();
            $table->string('username', 45)->unique()->nullable();
            $table->string('password', 255);
            $table->string('email', 45)->unique();
            $table->enum('role', ['admin', 'teacher', 'student'])->default('student');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('users_base');
    }
};
