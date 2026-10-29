<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('plans_pai', function (Blueprint $table) {
            $table->id();
            $table->year('annee')->unique();
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
        Schema::dropIfExists('plans_pai');
    }
};
