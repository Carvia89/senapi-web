<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SortieFourniture extends Model
{
    use HasFactory;

    protected $fillable = [
        'commande_vente_id',
        'qte_livree',
        'date_sortie',
        'destination'
    ];

    public function commandeVente()
    {
        return $this->belongsTo(CommandeVente::class, 'commande_vente_id');
    }
}
