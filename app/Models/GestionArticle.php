<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GestionArticle extends Model
{
    use HasFactory;

    protected $fillable = [
        'designation_id',
        'unite_id',
        'stock_initial',
        'stock_minimal',
    ];

    public function article()
    {
        return $this->belongsTo(Article::class,
            'designation_id'
        );
    }

    public function unity()
    {
        return $this->belongsTo(UnitArticle::class,
            'unite_id'
        );
    }

}
