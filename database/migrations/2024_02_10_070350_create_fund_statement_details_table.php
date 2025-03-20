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
        Schema::create('fund_statement_details', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('fund_statement_id');
            $table->foreign('fund_statement_id')->references('id')->on('fund_statements');
            $table->string('credit_code');
            $table->text('info');
            $table->string('receipt_number');
            $table->decimal('amount');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('fund_statement_details');
    }
};
