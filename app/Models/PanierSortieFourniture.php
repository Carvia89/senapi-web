<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PanierSortieFourniture extends Model
{
    use HasFactory;

    protected $fillable = [
        'commande_vente_id',
        'libelle',
        'client_id',
        'option_id',
        'classe_id',
        'qte_cmdee',
        'date_cmd',
        'type_cmd',
        'category_cmd',
        'qte_livree',
        'date_sortie'
    ];

    public function methodOption()
    {
        return $this->belongsTo(Option::class, 'option_id');
    }

    public function classe()
    {
        return $this->belongsTo(Kelasi::class, 'classe_id');
    }

    public function client()
    {
        return $this->belongsTo(ClientVente::class, 'client_id');
    }

    public function commandeVente()
    {
        return $this->belongsTo(CommandeVente::class, 'commande_vente_id');
    }
}
