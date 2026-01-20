<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Filiere extends Model
{
use HasFactory;

    protected $fillable = [
        'nom',
        'departement_id',
    ];

    /**
     * Une filière appartient à un département
     */
    public function departement()
    {
        return $this->belongsTo(Departement::class);
    }
    public function utilisateurs()
    {
        return $this->hasMany(Utilisateur::class);
    }

    //relation avec les matieres
    public function matieres()
    {
        return $this->belongsToMany(Matiere::class, 'filiere_matiere')
                    ->withPivot('niveau_id')
                    ->withTimestamps();
    }

}
