<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('session_documents', function (Blueprint $table) {
            $table->id();
            $table->foreignId('session_travail_id')->constrained('sessions_travail')->cascadeOnDelete();
            $table->enum('type', ['document', 'ordre_du_jour', 'ordre_du_jour_valide', 'compte_rendu', 'decision']);
            $table->string('titre')->nullable();
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
        Schema::dropIfExists('session_documents');
    }
};
