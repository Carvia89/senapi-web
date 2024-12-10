<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Division extends Model
{
    use HasFactory;

    protected $fillable =[
        'designation',
        'direction_id'
    ];

    public function direction()
    {
        return $this->belongsTo(Direction::class,
        'direction_id',
        );
    }
}
