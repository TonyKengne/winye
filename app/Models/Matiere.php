<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Matiere extends Model
{
     protected $fillable = ['code', 'nom'];

    // Une matière peut appartenir à plusieurs filières
    public function filieres()
    {
        return $this->belongsToMany(Filiere::class, 'filiere_matiere')
                    ->withPivot('niveau_id')
                    ->withTimestamps();
    }
}
