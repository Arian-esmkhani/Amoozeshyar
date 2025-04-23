<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('permission_user_base', function (Blueprint $table) {
            $table->id();
            $table->foreignId('permission_id')->constrained()->cascadeOnDelete();
            $table->foreignId('user_base_id')->constrained('users_base', 'id')->cascadeOnDelete();
            $table->timestamps();

            $table->unique(['permission_id', 'user_base_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('permission_user_base');
    }
};
