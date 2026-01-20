<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Campus extends Model
{
    protected $table = 'campuses';

    protected $fillable = [
        'nom',
        'photo_campus',
    ];

    /**
     * Un campus possède plusieurs cursus
     */
    public function cursus()
    {
        return $this->hasMany(Cursus::class);
    }
}
