<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Filiere extends Model
{

    protected $fillable = [
        'nom',
        'departement_id',
        'niveau_id',
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

    public function matieres()
    {
        return $this->belongsToMany(
            Matiere::class,
            'filiere_matiere'
        );
    }
    public function sujets()
    {
        return $this->belongsToMany(Sujet::class, 'filiere_sujet');
    }


}
