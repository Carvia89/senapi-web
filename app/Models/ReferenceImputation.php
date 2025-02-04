<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReferenceImputation extends Model
{
    use HasFactory;

    protected $fillable = [
        'imputation_id',
        'designation',
        'description'
    ];

    public function imputation()
    {
        return $this->belongsTo(Imputation::class, 'imputation_id');
    }
}

