<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Article extends Model
{
    use HasFactory;

    protected $fillable = [
        'designation',
        'categorie_id',
        'price',
    ];

    public function category()
    {
        return $this->belongsTo(CatgArticle::class,
            'categorie_id'
        );
    }

    public function fournisseurs()
    {
        return $this->belongsToMany(Fournisseur::class,
            'article_fournisseur',
            'article_id',
            'fournisseur_id'
        );
    }

    public function inventaire()
    {
        return $this->hasOne(Inventaire::class);
    }

    public function inStocks()
    {
        return $this->hasMany(InStock::class, 'article_id');
    }

    public function gestionArticle()
    {
        return $this->hasOne(GestionArticle::class, 'designation_id');
    }

    public function outStocks()
    {
        return $this->hasMany(OutStock::class, 'article_id');
    }

    // Dans le modèle Article
    public function getStockEntreDuringPeriod($dateDebut, $dateFin)
    {
        return InStock::where('article_id', $this->id)
                        ->whereBetween('date_entree', [$dateDebut, $dateFin])
                        ->get();
    }

    public function getStockSortieDuringPeriod($dateDebut, $dateFin)
    {
        return OutStock::where('article_id', $this->id)
                        ->whereBetween('date_sortie', [$dateDebut, $dateFin])
                        ->get();
    }
}
