<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ApproFourniture extends Model
{
    use HasFactory;

    protected $fillable = [
        'fournisseur_id',
        'date_entree',
        'description',
        'option_id',
        'classe_id',
        'qte_recue'
    ];

    public function fournisseur()
    {
        return $this->belongsTo(Fournisseur::class, 'fournisseur_id');
    }

    public function methodOption()
    {
        return $this->belongsTo(Option::class, 'option_id');
    }

    public function classe()
    {
        return $this->belongsTo(Kelasi::class, 'classe_id');
    }
}
