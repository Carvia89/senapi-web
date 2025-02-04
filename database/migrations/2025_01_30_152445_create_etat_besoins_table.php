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
        Schema::create('etat_besoins', function (Blueprint $table) {
            $table->id();
            $table->foreignId('bureau_id')->constrained('bureaus')->onDelete('cascade');
            $table->foreignId('dossier_id')->nullable()->constrained('dossiers')->onDelete('cascade');
            $table->string('description')->nullable();
            $table->integer('etat')->nullable();
            $table->date('date_reception');
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->string('fichier'); // Ce champ va stocker le chemin du fichier PDF
            $table->float('montant');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('etat_besoins');
    }
};
