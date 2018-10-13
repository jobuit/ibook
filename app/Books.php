<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Books extends Model
{
    protected $fillable = [
        'autor_id', 'titulo', 'descripcion' ,'tema', 'imagen','valoracion', 'cantidad',
    ];

}
