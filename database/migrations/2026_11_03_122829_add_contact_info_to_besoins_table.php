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
        Schema::table('besoins_prioritaires', function (Blueprint $table) {
            $table->string('nom')->nullable()->after('description');
            $table->string('prenom')->nullable()->after('nom');
            $table->string('telephone')->nullable()->after('prenom');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('besoins_prioritaires', function (Blueprint $table) {
            $table->dropColumn(['nom', 'prenom', 'telephone']);
        });
    }
};
