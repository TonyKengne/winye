<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    protected $table = 'notifications';

    protected $fillable = [
        'titre',
        'message',
        'type',
        'compte_utilisateur_id',
        'role_id',
        'is_lu',
        'date_lecture',
    ];

    protected $casts = [
        'is_lu' => 'boolean',
        'date_lecture' => 'datetime',
    ];

    /**
     * Notification liée à un compte utilisateur
     */
    public function compteUtilisateur()
    {
        return $this->belongsTo(CompteUtilisateur::class);
    }

    /**
     * Notification liée à un rôle
     */
    public function role()
    {
        return $this->belongsTo(Role::class);
    }
}
