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
        return $this->belongsTo(Division::class,
            'division_id'
        );
    }

    public function users()
    {
        return $this->hasMany(User::class, 'bureau_id');
    }
}
