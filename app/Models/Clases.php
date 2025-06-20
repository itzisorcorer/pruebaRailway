<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Notifications\Notifiable; 
use Laravel\Sanctum\HasApiTokens;


class Clases extends Model
{
    use HasFactory, Notifiable, HasApiTokens;

    protected $fillable = [
        'nombre',
        'descripcion',
        'cupo_maximo',
        'dias_disponibles',
        'hora_inicio',
        'hora_fin'
    ];

    // Conversiones automáticas (opcional)
    protected $casts = [
        'hora_inicio' => 'datetime:H:i',
        'hora_fin' => 'datetime:H:i',
    ];

    // Scope para filtrar por día
    public function scopePorDia($query, $dia)
    {
        return $query->where('dias_disponibles', $dia);
    }
}