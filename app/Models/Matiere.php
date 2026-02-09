<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Matiere extends Model
{
    protected $table = 'matiere';
    
    protected $fillable = [
        'nom',
        'code',
        'description',
        'coefficient',
        'filliere_id',
    ];

    protected $casts = [
        'coefficient' => 'decimal:2',
    ];

    public $timestamps = true;

    /**
     * Relation avec le modèle FilLiere
     */
    public function filiere(): BelongsTo
    {
        return $this->belongsTo(FilLiere::class, 'filliere_id');
    }
    
    /**
     * Relation avec les sujets
     */
    public function sujets()
    { 
        return $this->hasMany(Sujet::class, 'matiere_id'); 
    }
    
    /**
     * Relation avec les documents
     */
    public function documents()
    { 
         return $this->hasManyThrough(Document::class, Sujet::class, 'matiere_id', 'sujet_id'); 
    }

}