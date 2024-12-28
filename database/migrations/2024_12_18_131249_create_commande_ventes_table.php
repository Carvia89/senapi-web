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
        Schema::create('commande_ventes', function (Blueprint $table) {
            $table->id();
            $table->string('num_cmd');
            $table->string('libelle');
            $table->foreignId('client_id')->constrained('client_ventes')->onDelete('cascade');
            $table->foreignId('option_id')->constrained('options')->onDelete('cascade');
            $table->foreignId('classe_id')->constrained('kelasis')->onDelete('cascade');
            $table->integer('qte_cmdee');
            $table->date('date_cmd');
            $table->string('type_cmd');
            $table->string('category_cmd');
            $table->integer('etat_cmd')->default('1');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('commande_ventes');
    }
};
