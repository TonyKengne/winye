<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Sujet extends Model
{
    protected $table = 'sujet';
    
    protected $fillable = [
        'nom',
        'description',
        'annee',
        'semestre',
        'type_examen',
        'duree',
        'coefficient',
        'matiere_id',
        'filliere_id',
        'corrige_disponible',
        'qrcode',
    ];

    protected $casts = [
        'corrige_disponible' => 'boolean',
        'coefficient' => 'decimal:2',
    ];

    public $timestamps = false; // Pas de timestamps dans votre table

    /**
     * Relation avec le modèle Matiere
     */
    public function matiere(): BelongsTo
    {
        return $this->belongsTo(Matiere::class, 'matiere_id');
    }

    /**
     * Relation avec le modèle FilLiere
     */
    public function filiere(): BelongsTo
    {
        return $this->belongsTo(FilLiere::class, 'filliere_id');
    }

    /**
     * Relation avec les documents
     */
    public function documents(): HasMany
    {
        return $this->hasMany(Document::class, 'sujet_id');
    }

    /**
     * Scope pour les sujets avec corrigé
     */
    public function scopeAvecCorrige($query)
    {
        return $query->where('corrige_disponible', true);
    }

    /**
     * Scope pour les sujets sans corrigé
     */
    public function scopeSansCorrige($query)
    {
        return $query->where('corrige_disponible', false);
    }
}