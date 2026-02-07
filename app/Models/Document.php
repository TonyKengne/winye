<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Document extends Model
{
    protected $table = 'document';
    public $timestamps = false;

    protected $fillable = [
        'titre','annee','semestre','type_examen','duree','coefficient',
        'matiere_id','filliere_id','enseignant_id','chemin_fichier','valide','date_upload'
    ];

    public function matiere()
    {
        return $this->belongsTo(Matiere::class, 'matiere_id');
    }

    public function enseignant()
    {
        return $this->belongsTo(CompteUtilisateur::class, 'enseignant_id');
    }

    public function filiere()  
    {
        return $this->belongsTo(Filliere::class, 'filliere_id');
    }
}

