<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Chambre extends Model
{
    use HasFactory;

    protected $fillable = [
        'type',
        'description',
        'image',
        'occupation_maximale',
        'type_lit',
        'taille',
        'prix_chambre',
        'user_id_chambre',
        'hotel_id',
        'status'
    ];
}
