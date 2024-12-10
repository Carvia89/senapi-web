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
        Schema::create('gestion_articles', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('designation_id')->unique();
            $table->unsignedBigInteger('unite_id');
            $table->foreign('designation_id')->references('id')->on('articles')->onDelete('cascade');
            $table->foreign('unite_id')->references('id')->on('unit_articles')->onDelete('cascade');
            $table->float('stock_initial');
            $table->float('stock_minimal');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('gestion_articles');
    }
};
