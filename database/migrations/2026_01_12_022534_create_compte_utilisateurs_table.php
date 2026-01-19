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
        Schema::create('compte_utilisateurs', function (Blueprint $table) {
            $table->id();
            $table->string('email')->unique();
            $table->string('password');
            $table->enum('statut', ['actif', 'inactif'])->default('actif');
            $table->foreignId('role_id')->constrained('roles')->onDelete('restrict');
            $table->string('reset_token')->nullable();
            $table->timestamp('reset_token_expire_at')->nullable();
            $table->timestamp('date_creation')->useCurrent();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('compte_utilisateurs');
    }
};
