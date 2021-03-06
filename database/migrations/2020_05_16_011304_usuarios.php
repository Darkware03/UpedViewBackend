<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Usuarios extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('usuarios', function (Blueprint $table) {
            $table->increments('id');
            /*$table->string('imagen')->nullable();*/
            $table->string('nombre');
            $table->string('correo')->unique();
            $table->string('password');
            $table->integer('telefono');
            $table->integer('area')->nullable();
            $table->string('fechaDeNacimiento');
            $table->string('sexo');
            $table->integer('estado');
            $table->integer('codigoEmpleado');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
