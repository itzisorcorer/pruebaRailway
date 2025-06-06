<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Crypt; // ¡Importante!
use Illuminate\Contracts\Database\Eloquent\Casts\Attribute;

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
     /**
     * Interactúa con el atributo costo.
     * Encripta al guardar y desencripta al leer.
     */
    public function setCostoAttribute($value)
    {
        $this->attributes['costo'] = !is_null($value) ? Crypt::encryptString($value) : null;
    }
     /**
     * Accessor para el atributo 'costo'.
     * Desencripta el valor cuando lo lees desde el modelo.
     * Se ejecuta cuando haces: echo $membresia->costo;
     */
    public function getCostoAttribute($value)
    {
        try {
            return !is_null($value) ? Crypt::decryptString($value) : null;
        } catch (\Illuminate\Contracts\Encryption\DecryptException $e) {
            // Esto previene un error si el dato ya existente no está encriptado.
            return $value;
        }
    }

}
