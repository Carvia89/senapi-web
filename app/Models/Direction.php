<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Direction extends Model
{
    use HasFactory;

    protected $fillable = [
        'designation'
    ];

    public function divisions()
    {
        return $this->hasMany(Division::class);
    }

}
