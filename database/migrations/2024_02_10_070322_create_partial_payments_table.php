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
        Schema::create('partial_payments', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('credit_id');
            $table->foreign('credit_id')->references('id')->on('credits');
            $table->dateTime('date');
            $table->unsignedBigInteger('create_user');
            $table->foreign('create_user')->references('id')->on('users');
            $table->dateTime('payment_at');
            $table->unsignedBigInteger('payment_user');
            $table->foreign('payment_user')->references('id')->on('users');
            $table->decimal('amount');
            $table->unsignedBigInteger('amortization_schedule_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('partial_payments');
    }
};
