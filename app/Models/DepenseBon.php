<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DepenseBon extends Model
{
    use HasFactory;

    protected $fillable = [
        'bon_depense_id',
        'reference_imputation_id',
        'user_id',
        'date_depense'
    ];

    public function bonDepense()
    {
        return $this->belongsTo(BonDepense::class, 'bon_depense_id');
    }

    public function referImput()
    {
        return $this->belongsTo(ReferenceImputation::class, 'reference_imputation_id');
    }

    public function utilisateur()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
