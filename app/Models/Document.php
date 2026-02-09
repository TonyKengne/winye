<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Document extends Model
{
    protected $table = 'document';
    
    protected $fillable = [
        'titre',
        'chemin_fichier',
        'type',
        'date_upload',
        'consultation',
        'valide',
        'enseignant_id',
        'description',
        'sujet_id',
    ];

    protected $casts = [
        'valide' => 'integer', // Dans votre DB c'est tinyint(1) mais peut être -1, 0, 1
        'consultation' => 'integer',
        'date_upload' => 'datetime',
    ];

    public $timestamps = false; // Votre table n'a pas created_at/updated_at

    /**
     * Relation avec le modèle Sujet
     */
    public function sujet(): BelongsTo
    {
        return $this->belongsTo(Sujet::class, 'sujet_id');
    }

    /**
     * Relation avec le modèle CompteUtilisateur (Enseignant)
     */
    public function enseignant(): BelongsTo
    {
        return $this->belongsTo(\App\Models\CompteUtilisateur::class, 'enseignant_id');
    }

    /**
     * Accessor pour obtenir la matière via le sujet
     */
    public function getMatiereAttribute()
    {
        return $this->sujet ? $this->sujet->matiere : null;
    }

    /**
     * Accessor pour obtenir la filière via le sujet
     */
    public function getFiliereAttribute()
    {
        return $this->sujet ? $this->sujet->filiere : null;
    }

    /**
     * Accessor pour mapper consultation vers vues
     */
    public function getVuesAttribute()
    {
        return $this->consultation;
    }

    /**
     * Scope pour les documents validés
     */
    public function scopeValide($query)
    {
        return $query->where('valide', 1);
    }

    /**
     * Scope pour les documents en attente
     */
    public function scopeEnAttente($query)
    {
        return $query->where('valide', 0);
    }

    /**
     * Scope pour les documents rejetés
     */
    public function scopeRejete($query)
    {
        return $query->where('valide', -1);
    }

    /**
     * Scope pour les documents d'un enseignant
     */
    public function scopeByEnseignant($query, $enseignantId)
    {
        return $query->where('enseignant_id', $enseignantId);
    }

    /**
     * Incrémenter le nombre de consultations
     */
    public function incrementConsultations()
    {
        $this->increment('consultation');
    }
}