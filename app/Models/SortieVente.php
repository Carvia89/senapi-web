<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SortieVente extends Model
{
    use HasFactory;

    protected $fillable = [
        'commande_vente_id',
        'qte_sortie',
        'date_sortie',
        'etat',
        'description'
    ];

    public function commandeVente()
    {
        return $this->belongsTo(CommandeVente::class, 'commande_vente_id');
    }

}
