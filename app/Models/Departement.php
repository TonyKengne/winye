<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Departement extends Model
{

    protected $fillable = [
        'nom',
        'cursus_id',
    ];

    /**
     * Un département appartient à un cursus
     */
    public function cursus()
    {
        return $this->belongsTo(Cursus::class);
    }

    /**
     * Un département possède plusieurs filières
     */
    public function filieres()
    {
        return $this->hasMany(Filiere::class);
    }
}
