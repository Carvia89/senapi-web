<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DepenseSansBon extends Model
{
    use HasFactory;

    protected $fillable = [
        'date_depense',
        'reference_imputation_id',
        'libelle',
        'montant_depense',
        'user_id',
        'dossier_id'
    ];


    public function referImput()
    {
        return $this->belongsTo(ReferenceImputation::class, 'reference_imputation_id');
    }

    public function utilisateur()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function dossier()
    {
        return $this->belongsTo(Dossier::class, 'dossier_id');
    }
}
