<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Autores extends Model
{
    protected $fillable = [
        'nombre', 'descripcion' ,'imagen', 'telefono','correo', 'valoracion',
    ];

}
