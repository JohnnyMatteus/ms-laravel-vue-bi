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
        Schema::create('asset_distributions', function (Blueprint $table) {
            $table->id();
            $table->string('category', 50); // Categoria do ativo
            $table->float('percentage', 5, 2); // Porcentagem de distribuição
            $table->foreignId('investment_type_id')->constrained('investment_types')->onDelete('cascade');
            $table->text('details'); // Detalhes adicionais
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('asset_distribution');
    }
};
