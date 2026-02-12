<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Favori extends Model
{
    use HasFactory;

    protected $fillable = [
        'utilisateur_id', 
        'favorisable_type',
        'favorisable_id',
    ];

    // Favori appartient à un utilisateur
    public function utilisateur()
    {
        return $this->belongsTo(Utilisateur::class, 'utilisateur_id'); 
    }

    // Relation polymorphe
    public function favorisable()
    {
        return $this->morphTo();
    }
}
