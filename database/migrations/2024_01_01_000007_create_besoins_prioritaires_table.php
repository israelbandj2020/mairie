<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('besoins_prioritaires', function (Blueprint $table) {
            $table->id();
            $table->foreignId('canton_id')->constrained('cantons')->cascadeOnDelete();
            $table->string('titre')->nullable();
            $table->text('description');
            $table->enum('priorite', ['haute', 'moyenne', 'basse'])->default('moyenne');
            $table->enum('statut', ['en_cours', 'traite', 'rejete'])->default('en_cours');
            $table->foreignId('cree_par')->constrained('users')->cascadeOnDelete();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('besoins_prioritaires');
    }
};
