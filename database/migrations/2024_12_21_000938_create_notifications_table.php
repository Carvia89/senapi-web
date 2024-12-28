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
        Schema::create('notifications', function (Blueprint $table) {
            $table->id();  // Identifiant unique
            $table->foreignId('user_id')->constrained()->onDelete('cascade');  // Clé étrangère vers la table users
            $table->string('type');  // Type de notification
            $table->morphs('notifiable');  // Crée notifiable_id et notifiable_type
            $table->text('data');  // Données de la notification
            $table->boolean('read_at')->nullable();  // Date de lecture
            $table->timestamps();  // Champs created_at et updated_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('notifications');
    }
};
