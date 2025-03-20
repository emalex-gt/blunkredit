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
        Schema::create('fund_statement_investors', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('fund_statement_id');
            $table->foreign('fund_statement_id')->references('id')->on('fund_statements');
            $table->unsignedBigInteger('investor_id');
            $table->foreign('investor_id')->references('id')->on('investors');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('fund_statement_investors');
    }
};
