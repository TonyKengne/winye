<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('documents', function (Blueprint $table) {
            $table->id();

            // Relation optionnelle avec sujet
            $table->foreignId('sujet_id')
                  ->nullable()
                  ->constrained()
                  ->onDelete('cascade');

            // Relation optionnelle avec corrigé
            $table->foreignId('corrige_id')
                  ->nullable()
                  ->constrained()
                  ->onDelete('cascade');

            $table->string('nom');
            $table->string('fichier');
            $table->string('type')->nullable();

            // Auteur du document (optionnel)
            $table->foreignId('auteur_id')
                  ->nullable()
                  ->constrained('utilisateurs')
                  ->onDelete('set null');

            // Nombre de vues
            $table->integer('nb_vues')->default(0);

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('documents');
    }
};
