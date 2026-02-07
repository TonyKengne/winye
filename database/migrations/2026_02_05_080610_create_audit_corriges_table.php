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
        Schema::create('audit_corriges', function (Blueprint $table) {
        $table->id();
        $table->foreignId('corrige_id')->constrained()->cascadeOnDelete();
        $table->foreignId('valideur_id')->constrained('compte_utilisateurs');
        $table->enum('statut', ['valide', 'refuse']);
        $table->string('message')->nullable();
        $table->timestamps();
    });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('audit_corriges');
    }
};
