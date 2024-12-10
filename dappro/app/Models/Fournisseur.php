<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Fournisseur extends Model
{
    protected $table = 'fournisseurs';

    protected $fillable = [
        'nom',
        'description'
    ];

    public function articles()
    {
        return $this->belongsToMany(Article::class,
            'article_fournisseurs',
            'fournisseur_id',
            'article_id'
        );
    }
}
