<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ClientVente extends Model
{
    use HasFactory;

    protected $fillable = [
        'designation',
        'adresse',
        'telephone',
        'description'
    ];
}
