<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EtatBesoin extends Model
{
    use HasFactory;

    protected $fillable = [
        'bureau_id',
        'dossier_id',
        'description',
        'etat',
        'date_reception',
        'user_id',
        'montant',
        'fichier'   // Ce champ va stocker le chemin du fichier PDF
    ];

    public function bureau()
    {
        return $this->belongsTo(Bureau::class, 'bureau_id');
    }

    public function dossier()
    {
        return $this->belongsTo(Dossier::class, 'dossier_id');
    }

    public function utilisateur()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
