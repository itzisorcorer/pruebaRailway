<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Membresia extends Model
{
        protected $fillable = [
        'id_usuario', 
        'tipo_pago',
        'fecha_inicio',
        'fecha_fin',
        'costo',
        'estado'
    ];
}
