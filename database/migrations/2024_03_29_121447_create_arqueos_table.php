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
        Schema::create('arqueos', function (Blueprint $table) {
            $table->id();
            $table->date('date');
            $table->decimal('b200');
            $table->decimal('b100');
            $table->decimal('b50');
            $table->decimal('b20');
            $table->decimal('b10');
            $table->decimal('b5');
            $table->decimal('b1');
            $table->decimal('m1');
            $table->decimal('m05');
            $table->decimal('m025');
            $table->decimal('m01');
            $table->decimal('m005');
            $table->decimal('m001');
            $table->decimal('total_efectivo');
            $table->decimal('total_cheque');
            $table->decimal('total_arqueado');
            $table->decimal('informe_diario');
            $table->decimal('diferencia');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('arqueos');
    }
};
