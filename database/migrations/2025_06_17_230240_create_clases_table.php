<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('clases', function (Blueprint $table) {
            $table->id(); 
            $table->string('nombre', 100);
            $table->text('descripcion')->nullable();
            $table->unsignedSmallInteger('cupo_maximo');
            
            $table->enum('dias_disponibles', [
                'Lunes',
                'Martes',
                'Miércoles',
                'Jueves',
                'Viernes',
                'Sábado',
                'Domingo',
            ]);
            
            $table->time('hora_inicio');
            $table->time('hora_fin');
            
            $table->timestamps(); 
        });
    }

    public function down()
    {
        Schema::dropIfExists('clases');
    }
};