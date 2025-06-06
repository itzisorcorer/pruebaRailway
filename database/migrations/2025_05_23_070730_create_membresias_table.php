<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('membresias', function (Blueprint $table) {
            $table->id(); // ← ¡Corrige el espacio extra que tenías en "$table ->id()"!
            $table->foreignId('id_usuario')->constrained('users')->onDelete('cascade');
            $table->enum('tipo_pago', ['Clase', 'Mensual']);
            $table->date('fecha_inicio');
            $table->date('fecha_fin')->nullable();
            $table->decimal('costo', 6, 2);
            $table->enum('estado', ['Activa', 'Vencida', 'Cancelada'])->default('Activa');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('membresias');
    }
};