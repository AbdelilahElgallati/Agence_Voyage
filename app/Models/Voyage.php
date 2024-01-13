<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Voyage extends Model
{
    use HasFactory;

    protected $fillable = [
        'pays_voyage',
        'ville_voyage',
        'date_debut_voyage',
        'date_fin_voyage',
        'nbr_personne_voyage',
        'numero_tel_voyage',
        'type_hibergement',
        'image_voyage',
        'prix_voyage',
        'user_id',
        'nbr_place_reste_voyage',
        'status'
    ];
}
