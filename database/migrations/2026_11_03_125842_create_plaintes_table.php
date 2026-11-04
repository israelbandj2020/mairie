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
        Schema::create('plaintes', function (Blueprint $table) {
            $table->id();
            $table->enum('type_plainte', ['executif', 'agent_mairie', 'conseiller', 'autres']);
            $table->string('nom');
            $table->string('prenom');
            $table->string('telephone')->nullable();
            $table->text('description');
            $table->string('photo')->nullable();
            $table->enum('statut_validation', ['en_attente', 'valide', 'rejete'])->default('en_attente');
            $table->unsignedBigInteger('cree_par')->nullable();
            $table->timestamps();

            $table->foreign('cree_par')->references('id')->on('users')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('plaintes');
    }
};
