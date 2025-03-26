<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('users_account', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users_base')->onDelete('cascade');
            $table->integer('balance')->default(0);
            $table->integer('debt')->default(0);
            $table->integer('credit')->default(0);
            $table->enum('payment_status', ['active', 'suspended', 'blocked'])->default('active');
            $table->string('bank_account_number', 16)->nullable();
            $table->string('transaction_reference', 16)->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('users_account');
    }
};
