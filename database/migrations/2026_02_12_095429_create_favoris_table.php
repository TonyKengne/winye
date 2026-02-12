<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('favoris', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('utilisateur_id');

            // Relation polymorphique
            $table->morphs('favorisable'); 
            // => favorisable_id
            // => favorisable_type

            $table->timestamps();

            $table->foreign('utilisateur_id')
                  ->references('id')
                  ->on('utilisateurs')
                  ->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('favoris');
    }
};

