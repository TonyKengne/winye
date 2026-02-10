<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Consultation extends Model
{
    use HasFactory;

    protected $fillable = [
        'document_id',
        'etudiant_id',
    ];

    /**
     * Relation vers le document consulté
     */
    public function document()
    {
        return $this->belongsTo(Document::class);
    }

    /**
     * Relation vers l'étudiant qui a consulté le document
     */
    public function etudiant()
    {
        return $this->belongsTo(CompteUtilisateur::class, 'etudiant_id');
    }

    /**
     * Accessor pour récupérer la date de consultation
     */
    public function getDateConsultationAttribute()
    {
        return $this->created_at;
    }
}
