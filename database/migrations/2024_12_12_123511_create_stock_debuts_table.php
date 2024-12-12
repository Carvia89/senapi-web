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
        Schema::create('stock_debuts', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('classe_id');
            $table->foreign('classe_id')->references('id')->on('kelasis')->onDelete('cascade');
            $table->unsignedBigInteger('option_id');
            $table->foreign('option_id')->references('id')->on('options')->onDelete('cascade');
            //$table->foreignId('option_id')->constrained()->onDelete('cascade');
            $table->integer('stock_debut');
            $table->timestamps();

            // Ajoutez la contrainte d'unicité
            // $table->unique(['option_id', 'classe_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('stock_debuts');
    }
};
