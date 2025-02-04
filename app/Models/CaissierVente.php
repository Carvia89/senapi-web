<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CaissierVente extends Model
{
    use HasFactory;

    protected $fillable = [
        'commande_vente_id',
        'user_id',
        'montant_fact',
        'montant_paye',
        'description'
    ];

    public function commandeVente()
    {
        return $this->belongsTo(CommandeVente::class, 'commande_vente_id');
    }
}
