<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CorreoPersonales extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('correo_personales', function (Blueprint $table) {
            $table->increments('id');
            $table->string('correo_remitente');
            $table->string('correo_destinatario');
            $table->integer('Asunto')->nullable();
            $table->string('mensaje');
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
