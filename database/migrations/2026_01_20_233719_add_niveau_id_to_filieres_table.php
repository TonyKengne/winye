<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('filieres', function (Blueprint $table) {
            
            $table->unsignedBigInteger('niveau_id')->nullable()->after('departement_id');

            $table->foreign('niveau_id')->references('id')->on('niveaux')->onDelete('set null');
        });
    }

    public function down(): void
    {
        Schema::table('filieres', function (Blueprint $table) {
            if (Schema::hasColumn('filieres', 'niveau_id')) {
                $table->dropForeign(['niveau_id']);
                $table->dropColumn('niveau_id');
            }
        });
    }
};
