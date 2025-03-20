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
        Schema::create('credits', function (Blueprint $table) {
            $table->id();
            $table->string('code');
            $table->unsignedBigInteger('customer_id');
            $table->foreign('customer_id')->references('id')->on('customers');
            $table->unsignedBigInteger('tecnology_id');
            $table->foreign('tecnology_id')->references('id')->on('tecnologies');
            $table->unsignedBigInteger('fund_id');
            $table->foreign('fund_id')->references('id')->on('funds');
            $table->unsignedBigInteger('guarantee_id');
            $table->foreign('guarantee_id')->references('id')->on('guarantees');
            $table->unsignedBigInteger('credit_line_id');
            $table->foreign('credit_line_id')->references('id')->on('credit_lines');
            $table->unsignedBigInteger('time_limit_id');
            $table->foreign('time_limit_id')->references('id')->on('time_limits');
            $table->unsignedBigInteger('interest_id');
            $table->foreign('interest_id')->references('id')->on('interests');
            $table->decimal('initial_credit_capital');
            $table->decimal('amortized_credit_capital');
            $table->decimal('pending_credit_capital');
            $table->decimal('interest_paid');
            $table->decimal('delay_paid');
            $table->decimal('total_paid');
            $table->decimal('share');
            $table->unsignedBigInteger('created_user');
            $table->foreign('created_user')->references('id')->on('users');
            $table->dateTime('created_at');
            $table->unsignedBigInteger('authorized_user');
            $table->foreign('authorized_user')->references('id')->on('users');
            $table->dateTime('authorized_at');
            $table->unsignedBigInteger('expended_user');
            $table->foreign('expended_user')->references('id')->on('users');
            $table->dateTime('expended_at');
            $table->integer('status');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('credits');
    }
};
