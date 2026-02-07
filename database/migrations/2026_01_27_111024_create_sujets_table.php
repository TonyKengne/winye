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
        Schema::create('sujets', function (Blueprint $table) {
            $table->id();
            $table->foreignId('matiere_id')->constrained()->cascadeOnDelete();
            $table->string('titre');
           $table->enum('type', [
                'CC',          // Contrôle Continu
                'TD_TP',       // Travaux Dirigés / Travaux Pratiques
                'EXAMEN',      // Examen normal
                'RATTRAPAGE'   // Examen de rattrapage
            ]);
            $table->enum('session', ['NORMALE', 'RATTRAPAGE'])->nullable();
            $table->tinyInteger('semestre'); // 1 ou 2
            $table->string('annee_academique'); // ex: 2023-2024
            $table->enum('statut', [
                'en_attente',
                'valide',
                'refuse'
            ])->default('en_attente');

            // Contenu
            $table->text('description')->nullable();
            $table->string('fichier')->nullable(); // chemin PDF
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sujets');
    }
};
