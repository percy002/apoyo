<?php

namespace App\Http\Controllers;

use Goutte\Client;
use Illuminate\Http\Request;
use Symfony\Component\DomCrawler\Crawler;

class prediccionController extends Controller
{
    //
    public function index()
    {
        $client = new Client();
        $crawler = $client->request('GET', 'https://www.forebet.com/es/predicciones-de-futbol/predicciones-1x2/2019-08-03');
        $crawler->filter('.schema > tr ')->each(function (Crawler $apuesta) {
            // if(ctype_upper($node->text()[0]))
            //  $apuesta->filter;
            $liga = $apuesta->filter('.shortTag')->first()->text();
            // $liga=$apuesta->filter('span.shortTag')->text();
            // $equipos=$apuesta->filter('.homeTeam')->text();

            print $liga."<br/><br/><br/>";
            // $node->text();
        });

        
    }
}
