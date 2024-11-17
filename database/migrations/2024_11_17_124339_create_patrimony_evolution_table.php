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
        Schema::create('patrimony_evolutions', function (Blueprint $table) {
            $table->id();
            $table->string('month', 50); // Nome do mês
            $table->integer('year'); // Ano
            $table->float('value', 10, 2); // Valor da evolução
            $table->text('description')->nullable(); // Descrição opcional
            $table->foreignId('investment_type_id')->constrained('investment_types')->onDelete('cascade'); // Relacionamento com investment_types
            $table->timestamps();
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('patrimony_evolution');
    }
};
