<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Niveau extends Model
{

    protected $fillable = [
        'nom',
        
    ];


    //relation avec les matieres
    public function matieres()
{
    return $this->hasMany(Matiere::class);
}
}
