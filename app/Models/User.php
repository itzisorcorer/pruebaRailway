<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable, HasApiTokens;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */

     /**
     * Valores posibles: 
     * - 'A' => Administrador
     * - 'T' => Técnico
     * - 'D' => Departamento
     */
    protected $fillable = [
        'name',
        'apellido',
        'email',
        'password',
        'telefono',
        'fecha_nacimiento',
        'id_cuenta_principal',
        'tipo_usuario'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */

    protected function casts(): array
    {
        return [
            'fecha_nacimiento' => 'date',
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'tipo_usuario' => 'string',

        ];
    }
    //relacion con la cuenta principal:
    public function cuentaPrincipal() 
    {
        return $this->belongsTo(User::class, 'id_cuenta_principal');
    }



    //relacion con los dependiente:
    public function dependientes()
    {
        return $this->hasMany(User::class, 'id_cuenta_principal');
    }




}
