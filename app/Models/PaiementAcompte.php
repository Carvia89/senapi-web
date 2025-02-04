<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PaiementAcompte extends Model
{
    use HasFactory;

    protected $fillable = [
        'bon_depense_id',
        'beneficiaire',
        'date_paiement',
        'montant_acompte'
    ];

    public function bonDepense()
    {
        return $this->belongsTo(BonDepense::class, 'bon_depense_id');
    }
}
