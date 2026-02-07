<?php

namespace App\Models;

//use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;

class CompteUtilisateur extends Authenticatable
{
    protected $table = 'compte_utilisateurs';

    protected $fillable = [
        'email',
        'password',
        'statut',
        'role_id',
        'reset_token',
        'reset_token_expire_at',
        'date_creation'
    ];

    protected $hidden = [
        'password',
        'reset_token'
    ];

    protected $casts = [
        'reset_token_expire_at' => 'datetime',
        'date_creation' => 'datetime'
    ];

    public function role()
    {
        return $this->belongsTo(Role::class);
    }
    public function utilisateur() 
    {
         return $this->hasOne(Utilisateur::class, 'compte_utilisateur_id');
    }
    // public function utilisateur()
    // {
    //     return $this->hasOne(Utilisateur::class);
    // }
    public function notifications()
{
    return $this->hasMany(Notification::class);
}

}
