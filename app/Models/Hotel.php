<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Hotel extends Model
{
    use HasFactory;

    protected $fillable = [
        'nom_hotel',
        'pays_hotel',
        'ville_hotel',
        'adresse_hotel',
        'num_tel_hotel',
        'image_hotel',
        'contrat_hotel',
        'type_hotel',
        'nbr_etoil_hotel',
        'prix_hotel',
        'user_id'
    ];
}
