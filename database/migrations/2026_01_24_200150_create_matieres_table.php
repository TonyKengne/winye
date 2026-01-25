<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('matieres', function (Blueprint $table) {
            $table->id();
            $table->string('code')->unique(); // saisi manuellement
            $table->string('nom');
            $table->unsignedBigInteger('niveau_id');
            $table->unsignedTinyInteger('semestre'); // 1 ou 2
            $table->timestamps();

            $table->foreign('niveau_id')
                  ->references('id')
                  ->on('niveaux')
                  ->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('matieres');
    }
};
