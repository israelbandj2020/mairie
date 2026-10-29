<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('sessions_travail', function (Blueprint $table) {
            $table->id();
            $table->string('numero')->unique();
            $table->string('nom')->nullable();
            $table->date('date');
            $table->string('lieu')->nullable();
            $table->enum('statut', ['planifiee', 'en_cours', 'terminee', 'annulee'])->default('planifiee');
            $table->foreignId('cree_par')->constrained('users')->cascadeOnDelete();
            $table->timestamps();

            $table->index('numero');
            $table->index('nom');
            $table->index('date');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('sessions_travail');
    }
};
