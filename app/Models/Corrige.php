<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Corrige extends Model
{
    use HasFactory;

    /**
     * Champs autorisés en écriture
     */
    protected $fillable = [
        'sujet_id',
        'titre',
        'fichier',
        'statut',
        'is_public',
    ];

    /**
     * Valeurs possibles du statut
     */
    public const STATUT_EN_ATTENTE = 'en_attente';
    public const STATUT_VALIDE     = 'valide';
    public const STATUT_REFUSE     = 'refuse';

    /**
     * 
     * Relation : un corrigé appartient à un sujet
     */
    public function sujet()
    {
        return $this->belongsTo(Sujet::class);
    }

    /**
     * Helper : savoir si le corrigé est validé
     */
    public function isValide(): bool
    {
        return $this->statut === self::STATUT_VALIDE;
    }

    /**
     * Helper : savoir si le corrigé est public
     */
    public function isPublic(): bool
    {
        return (bool) $this->is_public;
    }
    public function audits()
    {
        return $this->hasMany(AuditCorrige::class);
    }
    public function documents()
    {
        return $this->hasMany(Document::class);
    }
    


}
