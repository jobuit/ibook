<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Reservas extends Model
{
    protected $fillable = [
        'book_id', 'user_id', 'fecha_recogeran','fecha_entrega',
    ];
}

