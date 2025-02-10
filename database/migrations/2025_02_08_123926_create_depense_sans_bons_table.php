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
        Schema::create('depense_sans_bons', function (Blueprint $table) {
            $table->id();
            $table->date('date_depense');
            $table->foreignId('reference_imputation_id')->constrained('reference_imputations')->onDelete('cascade');
            $table->string('libelle');
            $table->decimal('montant_depense', 15, 2);
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('dossier_id')->nullable()->constrained('dossiers')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('depense_sans_bons');
    }
};
