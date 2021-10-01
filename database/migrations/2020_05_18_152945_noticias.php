<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Noticias extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::create('noticias', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('id_usuario');
            $table->string('imagen',100);
            $table->string('titulo',50);
            $table->string('noticia_texto',1500);
            $table->integer('categoria');
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
