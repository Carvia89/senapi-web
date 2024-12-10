<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Inventaire extends Model
{
    use HasFactory;

    protected $table = 'inventaires';

    protected $fillable = [
        'article_id',
        'unite_id',
        'stock_initial',
        'stock_entree',
        'stock_sortie',
        'stock_actuel',
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



}
