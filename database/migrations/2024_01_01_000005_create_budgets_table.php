<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('budgets', function (Blueprint $table) {
            $table->id();
            $table->year('annee');
            $table->enum('type', ['annuel', 'supplementaire'])->default('annuel');
            $table->decimal('montant', 15, 2);
            $table->string('chemin');
            $table->string('nom_original');
            $table->string('mime');
            $table->unsignedBigInteger('taille');
            $table->foreignId('cree_par')->constrained('users')->cascadeOnDelete();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('budgets');
    }
};
