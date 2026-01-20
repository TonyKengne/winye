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
        Schema::create('filiere_matiere', function (Blueprint $table) {
            $table->id();
            $table->foreignId('filiere_id')->constrained('filieres')->onDelete('cascade');
            $table->foreignId('matiere_id')->constrained('matieres')->onDelete('cascade');
            $table->foreignId('niveau_id')->nullable()->constrained('niveaux')->onDelete('cascade');
            $table->timestamps();
            $table->unique(['filiere_id','matiere_id','niveau_id']); 
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('filiere_matiere');
    }
};
