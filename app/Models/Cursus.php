<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cursus extends Model
{

    protected $table = 'cursuses';

    protected $fillable = [
        'nom',
        'campus_id',
    ];

    /**
     * Un cursus appartient à un campus
     */
    public function campus()
    {
        return $this->belongsTo(Campus::class);
    }

    /**
     * Un cursus possède plusieurs départements
     */
    public function departements()
    {
        return $this->hasMany(Departement::class);
    }

    /**
     * Un cursus possède plusieurs niveaux
     */
    public function niveaux()
    {
        return $this->hasMany(Niveau::class);
    }
}
