<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Niveau extends Model
{
       use HasFactory;

    protected $fillable = [
        'nom',
        'cursus_id',
    ];

    /**
     * Un niveau appartient à un cursus
     */
    public function cursus()
    {
        return $this->belongsTo(Cursus::class);
    }
    //relation avec les matieres
    public function matieres()
    {
        return $this->belongsToMany(Matiere::class, 'filiere_matiere')
                    ->withPivot('filiere_id')
                    ->withTimestamps();
    }

}
