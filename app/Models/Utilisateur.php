<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Utilisateur extends Model
{
    protected $table = 'utilisateurs';

    protected $fillable = [
        'compte_utilisateur_id',
        'nom',
        'prenom',
        'matricule',
        'date_naissance',
        'telephone',
        'mode',
        'date_debut_premium',
        'date_fin_premium',
        'photo_profil',
        'filiere_id'
        
    ];

    protected $casts = [
        'date_naissance' => 'date',
        'date_debut_premium' => 'date',
        'date_fin_premium' => 'date',
    ];

    public function compte()
    {
        return $this->belongsTo(CompteUtilisateur::class, 'compte_utilisateur_id');
    }
}
