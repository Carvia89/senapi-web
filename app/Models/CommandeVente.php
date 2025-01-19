<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CommandeVente extends Model
{
    use HasFactory;

    protected $fillable = [
        'num_cmd',
        'libelle',
        'client_id',
        'option_id',
        'classe_id',
        'qte_cmdee',
        'date_cmd',
        'type_cmd',
        'category_cmd',
        'etat'
    ];

    public function client()
    {
        return $this->belongsTo(ClientVente::class, 'client_id');
    }

    public function methodOption()
    {
        return $this->belongsTo(Option::class, 'option_id');
    }

    public function classe()
    {
        return $this->belongsTo(Kelasi::class, 'classe_id');
    }

    public function PaniersortieFournitures()
    {
        return $this->hasMany(PanierSortieFourniture::class, 'commande_vente_id');
    }

    public function sortieFournitures()
    {
        return $this->hasMany(SortieFourniture::class, 'commande_vente_id');
    }

    public function sortieVentes()
    {
        return $this->hasMany(SortieVente::class, 'commande_vente_id');
    }
}
