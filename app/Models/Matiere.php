<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Matiere extends Model
{
    protected $table = 'matiere'; // adapte si ton nom est différent
    protected $fillable = ['nom', 'code', 'description'];
}

