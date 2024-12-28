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
        Schema::create('stock_debut_ventes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('classe_id')->constrained('kelasis')->onDelete('cascade');
            $table->foreignId('option_id')->constrained('options')->onDelete('cascade');
            $table->integer('stock_debut');
            $table->timestamps();

            // La contrainte d'unicité
            $table->unique(['option_id', 'classe_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('stock_debut_ventes');
    }
};
