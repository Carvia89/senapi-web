<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ServiceBudgetVisa extends Model
{
    use HasFactory;

    protected $fillable = [
        'bon_depense_id',
        'user_id',
    ];

    public function numBon()
    {
        return $this->belongsTo(BonDepense::class, 'bon_depense_id');
    }

    public function utilisateur()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
/*
    public function imputation()
    {
        return $this->belongsTo(Imputation::class, 'imputation_id');
    }
    */
}
