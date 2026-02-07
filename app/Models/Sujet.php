<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Sujet extends Model
{
    protected $table = 'sujet'; // ⚠️ pas "sujets" si ta table est bien au singulier
    public $timestamps = false;
    
    protected $fillable = [
        'annee',
        'semestre',
        'type_examen',
        'duree',
        'corrige_disponible',
        'coefficient',
        'matiere_id',
        'filliere_id',
        'qrcode',
    ];

    // Relations
    public function matiere()
    {
        return $this->belongsTo(Matiere::class);
    }

    public function filiere()
    {
        return $this->belongsTo(Filiere::class, 'filliere_id');
    }
}
