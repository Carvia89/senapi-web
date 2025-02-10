<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BonDepense extends Model
{
    use HasFactory;

    protected $fillable = [
        'num_bon',
        'type_bon',
        'beneficiaire_id',
        'date_emission',
        'direction_id',
        'etat_besoin_id',
        'imputation_id',
        'montant_bon',
        'motif',
        'num_enreg',
        'pour_acquit',
        'dossier_id',
        'etat',
        'num_chek',
        'date_acquit',
        'banque_id',
        'user_id'
    ];

    public function beneficiaire()
    {
        return $this->belongsTo(Beneficiaire::class, 'beneficiaire_id');
    }

    public function direction()
    {
        return $this->belongsTo(Direction::class, 'direction_id');
    }

    public function etatBesoin()
    {
        return $this->belongsTo(EtatBesoin::class, 'etat_besoin_id');
    }

    public function dossier()
    {
        return $this->belongsTo(Dossier::class, 'dossier_id');
    }

    public function banque()
    {
        return $this->belongsTo(Banque::class, 'banque_id');
    }

    public function utilisateur()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function imputCode()
    {
        return $this->belongsTo(Imputation::class, 'imputation_id');
    }


    public function paiementsAcomptes()
    {
        return $this->hasMany(PaiementAcompte::class, 'bon_depense_id');
    }

    public function depenseBons()
    {
        return $this->hasMany(DepenseBon::class, 'bon_depense_id');
    }

}
