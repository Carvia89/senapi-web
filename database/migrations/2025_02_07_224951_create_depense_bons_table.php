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
        Schema::create('depense_bons', function (Blueprint $table) {
            $table->id();
            $table->foreignId('bon_depense_id')->constrained('bon_depenses')->onDelete('cascade');
            $table->foreignId('reference_imputation_id')->constrained('reference_imputations')->onDelete('cascade');
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->date('date_depense');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('depense_bons');
    }
};
