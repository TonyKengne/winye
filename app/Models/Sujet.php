<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sujet extends Model
{
    use HasFactory;

    protected $fillable = [
        'matiere_id',
        'titre',
        'type',
        'session',
        'semestre',
        'annee_academique',
        'description',
        'fichier',
        'statut',
    ];
    

    /* =========================
       RELATIONS
    ========================= */

    public function matiere()
    {
        return $this->belongsTo(Matiere::class);
    }

    public function filieres()
    {
        return $this->belongsToMany(Filiere::class, 'filiere_sujet');
    }
    public function corriges()
    {
        return $this->hasMany(Corrige::class, 'sujet_id');
    }
    
    public function audits()
    {
        return $this->hasMany(AuditSujet::class);
    }

    public function auteur()
    {
        return $this->belongsTo(CompteUtilisateur::class, 'auteur_id');
    }
    public function documents()
    {
        return $this->hasMany(Document::class);
    }
    public function favoris()
{
    return $this->morphMany(Favori::class, 'favorisable');
}



}
    

