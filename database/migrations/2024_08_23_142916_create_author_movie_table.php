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
        Schema::create('author_movie', function (Blueprint $table) {
            $table->id();
            $table->timestamps();

            $table->foreignId('author_id')->constrained()->cascadeOnUpdate()->cascadeOnDelete();
            $table->foreignId('movie_id')->constrained()->cascadeOnUpdate()->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('author_movie');
    }
};
