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
        Schema::create('sortie_fournitures', function (Blueprint $table) {
            $table->id();
            // Ajout de la clé étrangère
            $table->foreignId('commande_vente_id')->constrained('commande_ventes')->onDelete('cascade');
            $table->integer('qte_livree');
            $table->date('date_sortie');
            $table->string('etat')->nullable();
            $table->timestamps();
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sortie_fournitures');
    }
};
