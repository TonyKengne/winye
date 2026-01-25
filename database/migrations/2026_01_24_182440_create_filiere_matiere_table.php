<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('filiere_matiere', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('filiere_id');
            $table->unsignedBigInteger('matiere_id');
            $table->timestamps();

            $table->foreign('filiere_id')
                  ->references('id')
                  ->on('filieres')
                  ->onDelete('cascade');

            $table->foreign('matiere_id')
                  ->references('id')
                  ->on('matieres')
                  ->onDelete('cascade');

            $table->unique(['filiere_id', 'matiere_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('filiere_matiere');
    }
};

