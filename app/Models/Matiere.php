<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Matiere extends Model
{
     protected $fillable = [
        'code',
        'nom',
        'niveau_id',
        'semestre',
    ];

    /**
     * Une matière appartient à un seul niveau
     */
    public function niveau()
    {
        return $this->belongsTo(Niveau::class);
    }

    /**
     * Une matière est enseignée dans plusieurs filières
     */
    public function filieres()
    {
        return $this->belongsToMany(
            Filiere::class,
            'filiere_matiere'
        );
    }
    public function sujets()
    {
        return $this->hasMany(Sujet::class);
    }
    /**
     * Relation avec les documents
     */
    public function documents()
    { 
         return $this->hasManyThrough(Document::class, Sujet::class, 'matiere_id', 'sujet_id'); 
    }

}
    


