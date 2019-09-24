<?php

namespace App\Http\Controllers;

use Goutte\Client;
use Illuminate\Http\Request;
use Symfony\Component\DomCrawler\Crawler;
use App\Entities\Partido;
use app;

use Carbon\Carbon;

class prediccion2Controller extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function nueva()
    {
        $client = new Client();
            $crawler = $client->request('GET', 'https://www.forebet.com/es/predicciones-de-futbol/predicciones-1x2/'."2019-08-25");
            $juegos=array();
            $button = $crawler->filter('.schema > #mrows')->eq(0); // and click it
            // $form = $button->selectButton('onclick="ltodrows("1x2","2019-08-25")"')->form();
            // dd($button);
            $crawler->filter('.schema > tr.tr_0,tr.tr_1 ')->each(function (Crawler $node) use (&$juegos){
                if(count($node->filter('.homeTeam')->first())>0 && count($node->filter('.forepr')->first())>0){
    
                    $juego=[];
                    $juego['liga']=$node->filter('.shortTag')->first()->text();
                    $juego['local']=$node->filter('.homeTeam')->first()->text();
                    $juego['visita']=$node->filter('.awayTeam')->first()->text();
                    // $juego['fechaHora']= $date = Carbon::createFromFormat('Y/m/d H:m:s', $node->filter('.date_bah')->first()->text().":00");
                    $juego['fechaHora']=(Carbon::createFromFormat('d/m/Y H:i:s', $node->filter('.date_bah')->first()->text().":00"))->toDateTimeString();
                    // print $juego['fechaHora']." - ".$node->filter('.date_bah')->first()->text().":00"."<br/>";
                    $juego['ganaLocal']=$node->filter('td')->eq(1)->text();
                    $juego['empata']=$node->filter('td')->eq(2)->text();
                    $juego['ganaVisita']=$node->filter('td')->eq(3)->text();
                    $juego['prediccion']=$node->filter('.forepr')->first()->text();
                    $juego['resultadoExacto']=$node->filter('td.tabonly')->eq(0)->text();
                    $juego['golesExacto']=$node->filter('td.tabonly')->eq(1)->text();
                    $juego['resultadoReal']=$node->filter('.l_scr')->first()->text();
                    // print $liga." ** ".$local." vs ".$visita." ** ".$fechaHora." - ".$prediccion." ***** ".
                    // $resultadoExacto." ** ".$golesExacto." ** ".$resultadorReal."<br/>";
                    // if(count($juegos)==54)
                    //  dd($juegos);
                    $juegos[]=$juego;
                    // $datosJuego=$node->filter('td > div');
                    // // $liga=$datosJuego->filter('.shortTag')->first()->text();
                    // print $datosJuego->text()."<br/>";
                    // print $node->attr('class')."<br/>";
                    
                }
            });
        dd($juegos);

    }
    public function todos()
    {
        $partidos=Partido::all();
        // $partidos=  Partido::where('resultadoExacto','1 - 1')->where('resultadoReal','1 - 1')->get();

        
        return view('prediccion',compact('partidos'));
    }
    public function acertados()
    {
        $partidos=Partido::where('prediccionAcertada','<>','Desacertada')->get();
        // $partidos=  Partido::where('resultadoExacto','1 - 1')->where('resultadoReal','1 - 1')->get();

        // dd($partidos);
        return view('prediccion',compact('partidos'));
    }
    public function index()
    {

        return view('index');
    }
    public function index3()
    {
        $partidos=Partido::all();
        // $partidos=  Partido::where('resultadoExacto','1 - 1')->where('resultadoReal','1 - 1')->get();
        // print $partidos->resultadoExacto;
        print $partidos->count()."<br/>";
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
                    $modificacion->prediccionAcertada="No Acertado";
                    $modificacion->save();
                }
            }
            else {
                $modificacion=Partido::find($partid->id);
                    $modificacion->prediccionAcertada="No Acertado";
                    $modificacion->save();
            }
        }
        return view('index');
    }
    public function index2()
    {
        //
        $fechaIni=Carbon::createFromFormat('Y-m-d', '2019-07-25');
        $fechafin=Carbon::createFromFormat('Y-m-d', '2019-08-26')->toDateString();

        // while ($fechaIni->toDateString() !== $fechafin) {
        //     # code...
        //     print $fechaIni->toDateString()."<br/>";
        //     $fechaIni->addDays(1);
        // }
        while ($fechaIni->toDateString() !== $fechafin) {
            // print $fechaIni->toDateString()."<br/>";
            $client = new Client();
            $crawler = $client->request('GET', 'https://www.forebet.com/es/predicciones-de-futbol/predicciones-1x2/'.$fechaIni->toDateString());
            print ('https://www.forebet.com/es/predicciones-de-futbol/predicciones-1x2/'.$fechaIni->toDateString()."<br/>");
            $juegos=array();
            
            $crawler->filter('.schema > tr.tr_0,tr.tr_1 ')->each(function (Crawler $node) use (&$juegos){
                if(count($node->filter('.homeTeam')->first())>0 && count($node->filter('.forepr')->first())>0){
    
                    $juego=[];
                    $juego['liga']=$node->filter('.shortTag')->first()->text();
                    $juego['local']=$node->filter('.homeTeam')->first()->text();
                    $juego['visita']=$node->filter('.awayTeam')->first()->text();
                    // $juego['fechaHora']= $date = Carbon::createFromFormat('Y/m/d H:m:s', $node->filter('.date_bah')->first()->text().":00");
                    $juego['fechaHora']=Carbon::createFromFormat('d/m/Y H:i:s', $node->filter('.date_bah')->first()->text().":00");
                    
                    $juego['ganaLocal']=$node->filter('td')->eq(1)->text();
                    $juego['empata']=$node->filter('td')->eq(2)->text();
                    $juego['ganaVisita']=$node->filter('td')->eq(3)->text();
                    $juego['prediccion']=$node->filter('.forepr')->first()->text();
                    $juego['resultadoExacto']=$node->filter('td.tabonly')->eq(0)->text();
                    $juego['golesExacto']=$node->filter('td.tabonly')->eq(1)->text();
                    $juego['resultadoReal']=$node->filter('.l_scr')->first()->text();
                    // print $liga." ** ".$local." vs ".$visita." ** ".$fechaHora." - ".$prediccion." ***** ".
                    // $resultadoExacto." ** ".$golesExacto." ** ".$resultadorReal."<br/>";
                    // if(count($juegos)==54)
                    //  dd($juegos);
                    $juegos[]=$juego;
                    // $datosJuego=$node->filter('td > div');
                    // // $liga=$datosJuego->filter('.shortTag')->first()->text();
                    // print $datosJuego->text()."<br/>";
                    // print $node->attr('class')."<br/>";
                    $partido=new Partido($juego);
                    $partido->save();
                }
            });
            $fechaIni->addDays(1);
        }

        // $client = new Client();
        //     $crawler = $client->request('GET', 'https://www.forebet.com/es/predicciones-de-futbol/predicciones-1x2/'."2019-08-25");
        //     $juegos=array();
            
        //     $crawler->filter('.schema > tr.tr_0,tr.tr_1 ')->each(function (Crawler $node) use (&$juegos){
        //         if(count($node->filter('.homeTeam')->first())>0 && count($node->filter('.forepr')->first())>0){
    
        //             $juego=[];
        //             $juego['liga']=$node->filter('.shortTag')->first()->text();
        //             $juego['local']=$node->filter('.homeTeam')->first()->text();
        //             $juego['visita']=$node->filter('.awayTeam')->first()->text();
        //             // $juego['fechaHora']= $date = Carbon::createFromFormat('Y/m/d H:m:s', $node->filter('.date_bah')->first()->text().":00");
        //             $juego['fechaHora']=(Carbon::createFromFormat('d/m/Y H:i:s', $node->filter('.date_bah')->first()->text().":00"))->toDateTimeString();
        //             print $juego['fechaHora']." - ".$node->filter('.date_bah')->first()->text().":00"."<br/>";
        //             $juego['ganaLocal']=$node->filter('td')->eq(1)->text();
        //             $juego['empata']=$node->filter('td')->eq(2)->text();
        //             $juego['ganaVisita']=$node->filter('td')->eq(3)->text();
        //             $juego['prediccion']=$node->filter('.forepr')->first()->text();
        //             $juego['resultadoExacto']=$node->filter('td.tabonly')->eq(0)->text();
        //             $juego['golesExacto']=$node->filter('td.tabonly')->eq(1)->text();
        //             $juego['resultadoReal']=$node->filter('.l_scr')->first()->text();
        //             // print $liga." ** ".$local." vs ".$visita." ** ".$fechaHora." - ".$prediccion." ***** ".
        //             // $resultadoExacto." ** ".$golesExacto." ** ".$resultadorReal."<br/>";
        //             // if(count($juegos)==54)
        //             //  dd($juegos);
        //             $juegos[]=$juego;
        //             // $datosJuego=$node->filter('td > div');
        //             // // $liga=$datosJuego->filter('.shortTag')->first()->text();
        //             // print $datosJuego->text()."<br/>";
        //             // print $node->attr('class')."<br/>";
        //             $partido=new Partido($juego);
        //             $partido->save();
            //     }
            // });
        // dd($juegos);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
