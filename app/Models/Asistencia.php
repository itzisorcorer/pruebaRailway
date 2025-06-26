<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class Asistencia extends Model
{
    use HasFactory, HasApiTokens, Notifiable;

    protected $table = 'asistencias';
    protected $primaryKey = 'id_asistencia';

    protected $fillable = [
        'id_usuario',
        'id_clase',
        'asistio'
    ];

    // Relación con usuario
    public function usuario()
    {
        return $this->belongsTo(User::class, 'id_usuario');
    }

    // Relación con clase
    public function clase()
    {
        return $this->belongsTo(Clases::class, 'id_clase');
    }
}