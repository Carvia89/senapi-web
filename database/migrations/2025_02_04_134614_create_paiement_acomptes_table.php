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
        Schema::create('paiement_acomptes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('bon_depense_id')->constrained('bon_depenses')->onDelete('cascade');
            $table->string('beneficiaire');
            $table->date('date_paiement');
            $table->float('montant_acompte');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('paiement_acomptes');
    }
};
