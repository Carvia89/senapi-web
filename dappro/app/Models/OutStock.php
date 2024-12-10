<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OutStock extends Model
{
    use HasFactory;

    protected $fillable = [
        'bureau_id',
        'article_id',
        'quantiteLivree',
        'reception',
        'date_sortie'
    ];

    public function bureau()
    {
        return $this->belongsTo(Bureau::class,
            'bureau_id'
        );
    }

    public function article()
    {
        return $this->belongsTo(Article::class,
            'article_id'
        );
    }
}
