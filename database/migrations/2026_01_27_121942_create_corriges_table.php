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
        Schema::create('corriges', function (Blueprint $table) {
            $table->id();
            
            $table->foreignId('sujet_id')
                  ->constrained()
                  ->cascadeOnDelete();

            $table->string('titre')->nullable();
            $table->string('fichier');

            $table->enum('statut', [
                'en_attente',
                'valide',
                'refuse'
            ])->default('en_attente');

            $table->boolean('is_public')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('corriges');
    }
};
