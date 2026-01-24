<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class NiveauSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Supprime les anciens niveaux si existants
        DB::table('niveaux')->truncate();

        // Création des niveaux 1 à 7
        for ($i = 1; $i <= 7; $i++) {
            DB::table('niveaux')->insert([
                'nom' => "Niveau $i",
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
