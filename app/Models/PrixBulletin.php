<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PrixBulletin extends Model
{
    use HasFactory;

    protected $fillable = [
        'prix',
        'description'
    ];
}
