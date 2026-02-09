<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Filliere extends Model
{
    protected $table = 'filliere';
    
    protected $fillable = [
        'nom',
        'code',
        'description',
        'niveau',
    ];

    public $timestamps = true;

    /**
     * Relation avec les matières
     */
    public function matieres(): HasMany
    {
        return $this->hasMany(Matiere::class, 'filliere_id');
    }

    /**
     * Relation avec les documents
     */
    public function documents(): HasMany
    {
        return $this->hasMany(Document::class, 'filiere_id');
    }

    /**
     * Relation avec les sujets
     */
    public function sujets(): HasMany
    {
        return $this->hasMany(Sujet::class, 'filliere_id');
    }
}