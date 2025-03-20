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
        Schema::create('prepayments', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('amortization_schedule_id');
            $table->foreign('amortization_schedule_id')->references('id')->on('amortization_schedules');
            $table->dateTime('date');
            $table->dateTime('payment_date');
            $table->string('receipt_number');
            $table->unsignedBigInteger('payment_user');
            $table->foreign('payment_user')->references('id')->on('users');
            $table->dateTime('payment_at');
            $table->boolean('status');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('prepayments');
    }
};
