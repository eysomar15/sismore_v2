<?php

namespace App\Http\Controllers\Presupuesto;

use App\Exports\BaseGastosExport;
use App\Http\Controllers\Controller;
use App\Models\Educacion\Importacion;
use App\Models\Presupuesto\BaseProyectos;
use App\Models\Presupuesto\BaseSiafWeb;
use App\Models\Presupuesto\TipoGobierno;
use App\Repositories\Presupuesto\BaseGastosRepositorio;
use App\Repositories\Presupuesto\BaseProyectosRepositorio;
use App\Repositories\Presupuesto\BaseSiafWebRepositorio;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class BaseProyectosController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /* nivel gobiernos */
    public function avancepresupuestal()
    {
        $impSW = Importacion::where('fuenteimportacion_id', '24')->where('estado', 'PR')->orderBy('fechaActualizacion', 'desc')->first();
        $baseSW = BaseSiafWeb::where('importacion_id', $impSW->id)->first();
        $anio = $baseSW->anio;
        $opt1 = BaseSiafWebRepositorio::pia_pim_certificado_devengado($baseSW->id);
        //return $opt1;
        $card1['pim'] = $opt1->pia;
        $card1['eje'] = $opt1->eje_pia;
        $card2['pim'] = $opt1->pim;
        $card2['eje'] = $opt1->eje_pim;
        $card3['pim'] = $opt1->cer;
        $card3['eje'] = $opt1->eje_cer;
        $card4['pim'] = $opt1->dev;
        $card4['eje'] = $opt1->eje_dev;

        $impP = Importacion::where('fuenteimportacion_id', '25')->where('estado', 'PR')->orderBy('fechaActualizacion', 'desc')->first();
        $baseP = BaseProyectos::where('importacion_id', $impP->id)->first();
        //$opt2 = BaseProyectosRepositorio::listar_regiones($baseP->id);
        //return $opt2;

        return view('presupuesto.BaseProyectos.AvancePresupuestal', compact('card1', 'card2', 'card3', 'card4', 'impSW', 'anio', 'baseP'));
    }
    public function avancepresupuestalmapa1($importacion_id)
    {
        $datax = [
            465 => 'pe-145',
            440 => 'pe-am',
            441 => 'pe-an',
            442 => 'pe-ap',
            443 => 'pe-ar',
            444 => 'pe-ay',
            445 => 'pe-cj',
            464 => 'pe-3341',
            446 => 'pe-cs',
            447 => 'pe-hv',
            448 => 'pe-hc',
            449 => 'pe-ic',
            450 => 'pe-ju',
            451 => 'pe-ll',
            452 => 'pe-lb',
            463 => 'pe-lr',
            453 => 'pe-lo',
            454 => 'pe-md',
            455 => 'pe-mq',
            456 => 'pe-pa',
            457 => 'pe-pi',
            458 => 'pe-cl',
            459 => 'pe-sm',
            460 => 'pe-ta',
            461 => 'pe-tu',
            462 => 'pe-uc',
        ];

        $data = [];
        $info = BaseProyectosRepositorio::listar_regiones($importacion_id);
        foreach ($info as $key => $value1) {
            $hc_key = $datax[$value1->codigo];
            $data[] = [$hc_key, $key + 1];
            if ($value1->codigo == 462)
                $value1->color = '#ef5350';
        }
        return response()->json(compact('info', 'data'));
    }

    public function avancepresupuestalgrafica3()
    {
        $mes = ['Ene', 'Feb', 'Mar', 'Abr', 'May', 'Jun', 'Jul', 'Ago', 'Set', 'Oct', 'Nov', 'Dic'];
        $array = BaseProyectosRepositorio::baseids_fecha_max(date('Y'));
        $info = BaseProyectosRepositorio::suma_ejecucion($array);
        foreach ($info as $key => $value) {
            $value->name = $mes[$value->name - 1];
        }
        return response()->json(compact('info'));
    }
}
