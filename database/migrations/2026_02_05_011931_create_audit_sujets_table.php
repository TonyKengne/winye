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
        Schema::create('audit_sujets', function (Blueprint $table) {
          $table->id();
            $table->unsignedBigInteger('sujet_id');
            $table->unsignedBigInteger('auteur_id');   // qui a soumis
            $table->unsignedBigInteger('valideur_id')->nullable(); // qui a validé/refusé
            $table->enum('statut', ['en_attente', 'valide', 'refuse'])->default('en_attente');
            $table->text('message')->nullable(); // message envoyé à l'auteur
            $table->timestamps();

            $table->foreign('sujet_id')->references('id')->on('sujets')->onDelete('cascade');
            
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('audit_sujets');
    }
};
