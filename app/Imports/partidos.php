<?php

namespace App\Imports;

use App\Entities\Partido;
use Maatwebsite\Excel\Concerns\ToModel;

class partidos implements ToModel
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        if($row[0]!=="Anfitrión - Invitado")
        {
            // dd($row);
            // $goles="1 -1";
            $resultado=explode('(',$row[11]);
            // dd($resultado);
            $parte=count(explode(' - ',"1 - 1 - 2"));
            
            if (count(explode(' - ',$row[5]))<2) {
                # code...
                // dd($parte);
            $goles=\PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($row[5])->format('d-m');
            $cero=explode('-',$goles);
            if((int)$cero[0]<10 or (int)$cero[1]<10)
            {
                if((int)$cero[0]<10)
                {
                    $primer=substr($cero[0], 1);
                    // dd($primer);
                }
                else {
                    $primer=cero[0];
                }

                if((int)$cero[1]<10)
                {
                    $segundo=substr($cero[1], 1);
                    // dd($segundo);
                }
                else {
                    $segundo=cero[1];
                }
                $golesArreglado=$primer." - ".$segundo;
                $goles=$golesArreglado;
            }  
           
            }
            else {
                $goles=$row[5];
            }

            $exacto=explode(' - ', $goles);
            $real=explode(' - ', $resultado[0]);
            $prediccion="desAcierto";
            if(count($real)>1)
            {
                if($exacto[0]>$exacto[1] && $real[0]>$real[1])
                {
                    $prediccion="Acertada";
                }
                elseif ($exacto[0]<$exacto[1] && $real[0]<$real[1]) {
                    $prediccion="Acertada";
                }
                elseif ($exacto[0]==$exacto[1] && $real[0]==$real[1]) {
                    $prediccion="Acertada";
                }
            }
            
            return new Partido([
                //
                'liga' => $row[0],
                'ganaLocal' => $row[1],
                'empata' => $row[2],
                'ganaVisita' => $row[3],
                'prediccion' => $row[4],
                'resultadoExacto' => $goles,
                'golesExacto' => $row[6],
                'resultadoReal' => $resultado[0],
                'prediccionAcertada' => $prediccion
            ]);
        }
    }
}
