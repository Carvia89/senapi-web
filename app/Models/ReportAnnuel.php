<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReportAnnuel extends Model
{
    use HasFactory;

    protected $fillable = [
        'montant_report',
        'annee',
        'description'
    ];
}
