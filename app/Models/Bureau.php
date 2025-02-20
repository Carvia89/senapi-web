<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bureau extends Model
{
    use HasFactory;

    protected $fillable = [
        'designation',
        'division_id'
    ];

    public function division()
    {
        return $this->belongsTo(Division::class);
    }

    public function beneficiaires()
    {
        return $this->hasMany(Beneficiaire::class);
    }

    // Relation avec EtatBesoin
    public function etatBesoins()
    {
        return $this->hasMany(EtatBesoin::class);
    }

/*
    public function users()
    {
        return $this->hasMany(User::class, 'bureau_id');
    }
*/
}
