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
        Schema::create('region_growths', function (Blueprint $table) {
            $table->id();
            $table->string('region', 100); // Nome da região
            $table->float('growth_rate', 5, 2); // Taxa de crescimento
            $table->foreignId('investment_type_id')->constrained('investment_types')->onDelete('cascade'); // Relacionado a investment_types
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('region_growth');
    }
};
