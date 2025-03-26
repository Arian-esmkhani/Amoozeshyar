<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('lesten_offered', function (Blueprint $table) {
            $table->id();
            $table->integer('lesten_id')->unique();
            $table->string('lesten_name', 145);
            $table->string('major', 100);
            $table->string('lesten_master', 45);
            $table->dateTime('lesten_date');
            $table->string('lesten_sex', 45)->nullable();
            $table->dateTime('lesten_final')->nullable();
            $table->integer('unit_count')->default(1);
            $table->integer('capacity')->nullable();
            $table->integer('registered_count')->default(0);
            $table->integer('lesten_price');
            $table->enum('class_type', ['theoretical', 'practical', 'mixed'])->default('theoretical');
            $table->string('classroom', 45)->nullable();
            $table->json('class_schedule')->nullable();
            $table->enum('status', ['active', 'cancelled', 'completed'])->default('active');
            $table->text('prerequisites')->nullable();
            $table->string('lesten_type', 45);
            $table->timestamps();
            $table->softDeletes();

            $table->index('lesten_name');
            $table->index('lesten_master');
            $table->index(['lesten_date', 'lesten_final']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('lesten_offered');
    }
};
