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
        Schema::create('in_stocks', function (Blueprint $table) {
            $table->id();
            $table->date('date_entree');
            $table->unsignedBigInteger('article_id');
            $table->unsignedBigInteger('unite_id');
            $table->integer('quantite');
            $table->unsignedBigInteger('fournisseur_id');
            $table->string('num_facture');
            $table->string('ref_bon_CMD');
            $table->timestamps();

            $table->foreign('article_id')->references('id')->on('articles')->onDelete('cascade');
            $table->foreign('unite_id')->references('id')->on('unit_articles')->onDelete('cascade');
            $table->foreign('fournisseur_id')->references('id')->on('fournisseurs')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('in_stocks');
    }
};
