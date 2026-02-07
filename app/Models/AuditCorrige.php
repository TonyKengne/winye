<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AuditCorrige extends Model
{
    protected $fillable = [
        'corrige_id',
        'valideur_id',
        'statut',
        'message',
    ];

    public function corrige()
    {
        return $this->belongsTo(Corrige::class);
    }

    public function valideur()
    {
        return $this->belongsTo(CompteUtilisateur::class, 'valideur_id');
    }
}

