<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FicheStock extends Model
{
    use HasFactory;

    protected $table = 'fiche_stocks';

    protected $fillable = [
        'article_id',
        'date_entree',
        'stock_initial',
        'stock_entree',
        'stock_total',
        'date_sortie',
        'stock_sortie',
        'stock_actuel',
        'fournisseur_id',
        'bureau_id',
    ];

    public function article()
    {
        return $this->belongsTo(Article::class,
            'article_id'
        );
    }

    public function bureau()
    {
        return $this->belongsTo(Bureau::class,
            'bureau_id'
        );
    }

    public function fournisseur()
    {
        return $this->belongsTo(Fournisseur::class,
            'fournisseur_id'
        );
    }
}
