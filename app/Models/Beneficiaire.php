<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Beneficiaire extends Model
{
    use HasFactory;

    protected $fillable = [
        'nom',
        'bureau_id',
        'description'
    ];

    public function bureau()
    {
        return $this->belongsTo(Bureau::class, 'bureau_id');
    }
}
