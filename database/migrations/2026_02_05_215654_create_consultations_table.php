<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('consultations', function (Blueprint $table) {
            $table->id();

            // Relations propres avec Laravel
            $table->foreignId('document_id')
                  ->constrained('documents')
                  ->cascadeOnDelete();

            $table->foreignId('etudiant_id')
                  ->constrained('utilisateurs')
                  ->cascadeOnDelete();

            // Date automatique
            $table->timestamps(); // created_at = date_consultation

            // Empêcher qu’un étudiant compte 2 vues en même temps
            $table->unique(['document_id', 'etudiant_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('consultations');
    }
};
