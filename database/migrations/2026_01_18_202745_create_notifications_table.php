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
        
        Schema::create('notifications', function (Blueprint $table) {
            $table->id();

            // Contenu
            $table->string('titre');
            $table->text('message');
            $table->enum('type', ['info', 'alerte', 'system'])->default('info');

            // Ciblage
            $table->foreignId('compte_utilisateur_id')
                  ->nullable()
                  ->constrained('compte_utilisateurs')
                  ->onDelete('cascade');

            $table->foreignId('role_id')
                  ->nullable()
                  ->constrained('roles')
                  ->onDelete('cascade');

            // Lecture
            $table->boolean('is_lu')->default(false);
            $table->timestamp('date_lecture')->nullable();

            $table->timestamps();
        });
    }
    

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('notifications');
    }
};
