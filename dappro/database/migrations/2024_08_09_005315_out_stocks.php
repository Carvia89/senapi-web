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
        Schema::create('out_stocks', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('bureau_id');
            $table->unsignedBigInteger('article_id');
            $table->float('quantiteLivree');
            $table->string('reception');
            $table->date('date_sortie');

            $table->foreign('article_id')->references('id')->on('articles')->onDelete('cascade');
            $table->foreign('bureau_id')->references('id')->on('bureaus')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('out_stocks');
    }
};
