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
        return $this->belongsToMany(Matiere::class, 'filiere_matiere')
                    ->withPivot('filiere_id')
                    ->withTimestamps();
    }

}
