<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('users_data', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users_base')->onDelete('cascade');
            $table->string('name', 85);
            $table->string('father_name', 45);
            $table->string('national_code', 10)->unique();
            $table->date('birth_date');
            $table->enum('gender', ['male', 'female']);
            $table->string('religion', 20)->nullable();
            $table->string('denomination', 20)->nullable();
            $table->enum('health_status', ['healthy', 'physical_disability', 'mental_disability', 'both'])->default('healthy');
            $table->text('address')->nullable();
            $table->string('phone_number', 15)->nullable();
            $table->string('emergency_contact', 15)->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->index('name');
            $table->index('national_code');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('users_data');
    }
};
