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
        Schema::create('bon_depenses', function (Blueprint $table) {
            $table->id();
            $table->string('num_bon');
            $table->string('type_bon');
            $table->foreignId('beneficiaire_id')->constrained('beneficiaires')->onDeledte('cascade');
            $table->date('date_emission');
            $table->foreignId('direction_id')->constrained('directions')->onDelete('cascade');
            $table->foreignId('etat_besoin_id')->nullable()->constrained('etat_besoins')->onDelete('cascade');
            $table->decimal('montant_bon', 15, 2);
            $table->string('motif');
            $table->string('num_enreg');
            $table->string('pour_acquit')->nullable();
            $table->foreignId('dossier_id')->nullable()->constrained('dossiers')->onDelete('cascade');
            $table->foreignId('imputation_id')->nullable()->constrained('imputations')->onDelete('cascade');
            $table->integer('etat');
            $table->string('num_chek')->nullable();
            $table->date('date_acquit')->nullable();
            $table->foreignId('banque_id')->nullable()->constrained('banques')->onDelete('cascade');
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bon_depenses');
    }
};
