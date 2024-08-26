<?php

use App\Enums\Ticket\TicketStatusEnum;
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
        Schema::create('tickets', function (Blueprint $table) {
            $table->id();
            $table->uuid();
            $table->string('price');
            $table->string('seat');
            $table->foreignId('movie_id')->constrained('movies')->onUpdate('cascade')->onDelete('cascade');
            $table->string('status')->default(TicketStatusEnum::created);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tickets');
    }
};
