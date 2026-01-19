<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    protected $table='roles';
    protected $fillable =[
        'libelle'
    ];

    public function comptes()
    {
        return $this->hasMany(CompteUtilisateur::class);
    }
    public function notifications()
{
    return $this->hasMany(Notification::class);
}

}
