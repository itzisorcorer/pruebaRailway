<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;
class MembresiaTest extends TestCase
{


public function test_creacion_exitosa_con_costo_valido()
{
    $user = User::find(7);
    $this->actingAs($user, 'sanctum');

    $response = $this->postJson('/api/membresias', [
        'id_usuario' => $user->id,
        'tipo_pago' => 'Clase',
        'fecha_inicio' => now()->toDateString(),
        'fecha_fin' => now()->addWeek()->toDateString(),
        'costo' => 21,
        'estado' => 'Activa',
    ]);

    $response->assertStatus(200); // o 200 según tu controlador
    
}


}
