<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InStock extends Model
{
    use HasFactory;

    protected $fillable = [
        'date_entree',
        'article_id',
        'unite_id',
        'quantite',
        'fournisseur_id',
        'num_facture',
        'ref_bon_CMD',
    ];

    public function article()
    {
        return $this->belongsTo(Article::class,
            'article_id'
        );
    }

    public function unity()
    {
        return $this->belongsTo(UnitArticle::class,
            'unite_id'
        );
    }

    public function fournisseurs()
    {
        return $this->belongsTo(Fournisseur::class,
            'fournisseur_id'
        );
    }

}
