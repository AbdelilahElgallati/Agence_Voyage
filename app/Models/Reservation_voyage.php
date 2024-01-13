<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reservation_voyage extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'nombre_personnes',
        'prix',
        'status',
        'user_id',
        'voyage_id'
    ];
}
