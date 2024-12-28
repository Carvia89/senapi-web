<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EntreeFourniture extends Model
{
    use HasFactory;

    protected $fillable = [
        'fournisseur_id',
        'classe_id',
        'option_id',
        'quantiteRecu',
        'date_entree',
        'description',
        'reception'
    ];

    public function fournisseur()
    {
        return $this->belongsTo(Fournisseur::class,
            'fournisseur_id'
        );
    }

    public function classe()
    {
        return $this->belongsTo(Kelasi::class,
            'classe_id'
        );
    }

    public function methodOption()
    {
        return $this->belongsTo(Option::class,
            'option_id'
        );
    }
}
