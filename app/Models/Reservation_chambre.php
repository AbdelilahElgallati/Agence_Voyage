<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reservation_chambre extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'date_debut',
        'date_fin',
        'nbr_personne',
        'prix',
        'status',
        'posteur_id',
        'user_id',
        'chambre_id'
    ];

}
