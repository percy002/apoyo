<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePartidosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('partidos', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('liga', 50);
            $table->string('local', 50);
            $table->string('visita', 50);
            $table->dateTime('fechaHora');
            $table->string('ganaLocal', 50);
            $table->string('empata', 50);
            $table->string('ganaVisita', 50);
            $table->string('prediccion', 50);
            $table->string('resultadoExacto', 50);
            $table->string('golesExacto', 50);
            $table->string('resultadoReal', 50);
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
        Schema::dropIfExists('partidos');
    }
}
