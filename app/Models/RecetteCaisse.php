<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RecetteCaisse extends Model
{
    use HasFactory;

    protected $fillable = [
        'libelle',
        'date_recette',
        'montant_recu',
        'user_id',
        'dossier_id',
        'reference_imputation_id'
    ];

    public function utilisateur()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function dossier()
    {
        return $this->belongsTo(Dossier::class, 'dossier_id');
    }

    public function refeImputation()
    {
        return $this->belongsTo(ReferenceImputation::class, 'reference_imputation_id');
    }
}
