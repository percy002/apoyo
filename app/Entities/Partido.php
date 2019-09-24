<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;

class Partido extends Model
{
    //
    protected $table="partidos";
    // protected $fillable = ['liga', 'local', 'visita','fechaHora','ganaLocal','empata','ganaVisita','prediccion','resultadoExacto','golesExacto','resultadoReal'];
    protected $fillable = ['liga','ganaLocal','empata','ganaVisita','prediccion','resultadoExacto','golesExacto','resultadoReal','prediccionAcertada'];
}
