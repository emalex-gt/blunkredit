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
        Schema::create('amortization_schedules', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('credit_id');
            $table->foreign('credit_id')->references('id')->on('credits');
            $table->dateTime('share_number');
            $table->dateTime('share_date');
            $table->dateTime('payment_date');
            $table->string('receipt_number');
            $table->decimal('capital');
            $table->decimal('interest');
            $table->decimal('delay');
            $table->decimal('total');
            $table->decimal('total_payment');
            $table->decimal('capital_balance');
            $table->decimal('interest_balance');
            $table->decimal('total_balance');
            $table->decimal('capital_balance_payment');
            $table->decimal('interest_balance_payment');
            $table->decimal('total_balance_payment');
            $table->integer('days_delayed');
            $table->unsignedBigInteger('created_user');
            $table->foreign('created_user')->references('id')->on('users');
            $table->dateTime('created_at');
            $table->unsignedBigInteger('payment_user');
            $table->foreign('payment_user')->references('id')->on('users');
            $table->dateTime('payment_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('amortization_schedules');
    }
};
