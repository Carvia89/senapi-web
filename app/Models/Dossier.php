<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Dossier extends Model
{
    use HasFactory;

    protected $fillable = [
        'designation',
        'description'
    ];

    // Relation avec EtatBesoin
    public function etatBesoins()
    {
        return $this->hasMany(EtatBesoin::class);
    }

}
