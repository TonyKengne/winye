<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Consultation extends Model
{
    protected $table = 'consultations';
    public $timestamps = false; // pas de created_at/updated_at
    protected $fillable = ['document_id', 'etudiant_id', 'date_consultation'];

    // Relations
    public function document()
    {
        return $this->belongsTo(Document::class);
    }

    public function etudiant()
    {
        return $this->belongsTo(Utilisateur::class, 'etudiant_id');
    }
}
