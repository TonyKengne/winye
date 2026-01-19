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
        Schema::create('utilisateurs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('compte_utilisateur_id')
                  ->constrained('compte_utilisateurs')
                  ->onDelete('cascade');
            $table->string('nom');
            $table->string('prenom');
            $table->date('date_naissance')->nullable();
            $table->string('telephone')->nullable();
            $table->enum('mode', ['standard', 'premium'])->default('standard');
            $table->date('date_debut_premium')->nullable();
            $table->date('date_fin_premium')->nullable();
            $table->string('photo_profil')->nullable();
            $table->foreignId('filiere_id')->nullable()->constrained('filieres');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('utilisateurs');
    }
};
