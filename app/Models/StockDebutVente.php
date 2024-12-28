<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StockDebutVente extends Model
{
    use HasFactory;

    protected $fillable = [
        'option_id',
        'classe_id',
        'stock_debut'
    ];

    public function methodOption()
    {
        return $this->belongsTo(Option::class, 'option_id');
    }

    public function classe()
    {
        return $this->belongsTo(Kelasi::class, 'classe_id');
    }
}
