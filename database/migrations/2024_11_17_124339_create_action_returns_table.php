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
        Schema::create('action_returns', function (Blueprint $table) {
            $table->id();
            $table->string('action_code', 10); // Código da ação
            $table->string('name'); // Nome do ativo
            $table->text('description');
            $table->float('return_percentage'); // Retorno em porcentagem
            $table->foreignId('investment_type_id')->constrained('investment_types')->onDelete('cascade'); // Relacionado a `investment_types`
            $table->date('date'); // Data da análise ou relatório
            $table->timestamps();
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('action_returns');
    }
};
