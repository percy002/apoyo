<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
// use Maatwebsite\Excel\Facades\Excel;
use Excel;
use App\Imports\partidos;
use App\Entities\Partido;
use app;
class prediccion3Controller extends Controller
{
    //
    public function arreglar()
    {
        $partidos=Partido::all();
        // $partidos=  Partido::where('resultadoExacto','1 - 1')->where('resultadoReal','1 - 1')->get();
        // print $partidos->resultadoExacto;
        // print $partidos->count()."<br/>";
        foreach ($partidos as $partid) {
            // print $partid->resultadoExacto;
            # code...
            $exacto=explode(' - ', $partid->resultadoExacto);
            $real=explode(' - ', $partid->resultadoReal);
            if(count($real)>1)
            {
                if($exacto[0]>$exacto[1] && $real[0]>$real[1])
                {
                    $modificacion=Partido::find($partid->id);
                    $modificacion->prediccionAcertada="local acertada";
                    $modificacion->save();
                    // print "local".$exacto[0]."<br/>";
                    print "empates llenados"."<br/>";
                }
                elseif ($exacto[0]<$exacto[1] && $real[0]<$real[1]) {
                    $modificacion=Partido::find($partid->id);
                    $modificacion->prediccionAcertada="visita acertada";
                    $modificacion->save();
                    print "empates llenados"."<br/>";
                }
                elseif ($exacto[0]==$exacto[1] && $real[0]==$real[1]) {
                    
                    $modificacion=Partido::find($partid->id);
                    $modificacion->prediccionAcertada="empate acertada";
                    $modificacion->save();
                    print $partid->prediccionAcertada."<br/>";
                }
                else {
                    $modificacion=Partido::find($partid->id);
                    $modificacion->prediccionAcertada="Desacertada";
                    $modificacion->save();
                }
            }
            else {
                $modificacion=Partido::find($partid->id);
                    $modificacion->prediccionAcertada="Desacertada";
                    $modificacion->save();
            }
        }
        return redirect()->route('todos');
    }
    function index()
    {
        return view('importar');
    }

    public function importarExcel(Request $request)
    {
        $file=$request->file('file');

        Excel::import(new partidos,$file);

        
        // $partidos=  Partido::where('resultadoExacto','1 - 1')->where('resultadoReal','1 - 1')->get();

        
        
        return redirect()->route('todos');
        
        
    }
}
