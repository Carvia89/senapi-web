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
        Schema::create('fiche_stocks', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('article_id');
            $table->date('date_entree')->nullable();
            $table->integer('stock_initial')->nullable();
            $table->integer('stock_entree')->nullable();
            $table->integer('stock_total')->nullable();
            $table->date('date_sortie')->nullable();
            $table->integer('stock_sortie')->nullable();
            $table->integer('stock_actuel')->nullable();
            $table->unsignedBigInteger('fournisseur_id')->nullable();
            $table->unsignedBigInteger('bureau_id')->nullable();
            $table->timestamps();

            $table->foreign('article_id')->references('id')->on('articles')->onDelete('cascade');
            $table->foreign('bureau_id')->references('id')->on('bureaus')->onDelete('cascade');
            $table->foreign('fournisseur_id')->references('id')->on('fournisseurs')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('fiche_stocks');
    }
};
