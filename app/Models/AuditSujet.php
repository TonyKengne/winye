<?php

// app/Models/AuditSujet.php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AuditSujet extends Model
{
    protected $table = 'audit_sujets';
    protected $fillable = ['sujet_id', 'auteur_id', 'valideur_id', 'statut', 'message'];

    public function sujet()
    {
        return $this->belongsTo(Sujet::class);
    }

    public function auteur()
    {
        return $this->belongsTo(CompteUtilisateur::class, 'auteur_id');
    }

    public function valideur()
    {
        return $this->belongsTo(CompteUtilisateur::class, 'valideur_id');
    }
}

