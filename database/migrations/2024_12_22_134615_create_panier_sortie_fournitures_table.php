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
        Schema::create('panier_sortie_fournitures', function (Blueprint $table) {
            $table->id();
            // Ajout de la clé étrangère
            $table->foreignId('commande_vente_id')->constrained('commande_ventes')->onDelete('cascade');
            $table->string('libelle');
            $table->foreignId('client_id')->constrained('client_ventes')->onDelete('cascade');
            $table->foreignId('option_id')->constrained('options')->onDelete('cascade');
            $table->foreignId('classe_id')->constrained('kelasis')->onDelete('cascade');
            $table->integer('qte_cmdee');
            $table->date('date_cmd');
            $table->string('type_cmd');
            $table->string('category_cmd');
            $table->integer('qte_livree');
            $table->date('date_sortie');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('panier_sortie_fournitures');
    }
};
