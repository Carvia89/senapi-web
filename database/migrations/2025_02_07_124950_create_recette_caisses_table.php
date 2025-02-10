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
        Schema::create('recette_caisses', function (Blueprint $table) {
            $table->id();
            $table->string('libelle');
            $table->date('date_recette');
            $table->decimal('montant_recu', 15, 2);
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('dossier_id')->nullable()->constrained('dossiers')->onDelete('cascade');
            $table->foreignId('reference_imputation_id')->constrained('reference_imputations')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('recette_caisses');
    }
};
