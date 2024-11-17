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
        Schema::create('sector_returns', function (Blueprint $table) {
            $table->id();
            $table->string('sector', 100); // Nome do setor
            $table->float('return_percentage', 5, 2); // Retorno em porcentagem
            $table->foreignId('investment_type_id')->constrained('investment_types')->onDelete('cascade'); // Relacionado a investment_types
            $table->timestamps();
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sector_returns');
    }
};
