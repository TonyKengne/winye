<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Document extends Model
{
    use HasFactory;

    protected $fillable = [
        'sujet_id',
        'corrige_id',
        'nom',
        'fichier',
        'type',
        'nb_vues',
        'valide',
        'auteur_id',
    ];

    protected $casts = [
        'nb_vues' => 'integer',
    ];

    public function sujet()
    {
        return $this->belongsTo(Sujet::class);
    }

    public function corrige()
    {
        return $this->belongsTo(Corrige::class);
    }

    // Auteur du document
    public function auteur()
    {
        return $this->belongsTo(CompteUtilisateur::class, 'auteur_id');
    }

    // Consultations (vues)
    public function consultations()
    {
        return $this->hasMany(Consultation::class);
    }

    public function incrementerVues()
    {
        $this->increment('nb_vues');
    }
}
