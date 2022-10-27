<?php

namespace App\Http\Controllers\Presupuesto;

use App\Http\Controllers\Controller;
use App\Models\Educacion\Importacion;
use App\Models\Presupuesto\TipoGobierno;
use App\Repositories\Presupuesto\BaseGastosRepositorio;
use App\Repositories\Presupuesto\BaseIngresosRepositorio;
use Illuminate\Http\Request;

class BaseIngresosController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /* IngresoPresupuestal */
    public function ingresopresupuestal()
    {
        $impG = Importacion::where('fuenteimportacion_id', '13')->where('estado', 'PR')->orderBy('fechaActualizacion', 'desc')->first();
        $impI = Importacion::where('fuenteimportacion_id', '15')->where('estado', 'PR')->orderBy('fechaActualizacion', 'desc')->first();

        $opt1 = BaseGastosRepositorio::total_pim($impG->id);
        $card1['pim'] = $opt1->pim;
        $card1['eje'] = $opt1->eje;

        $opt1 = BaseGastosRepositorio::pim_tipogobierno($impG->id);
        $card2['pim'] = $opt1[1]->pim;
        $card2['eje'] = $opt1[1]->eje;
        $card3['pim'] = $opt1[2]->pim;
        $card3['eje'] = $opt1[2]->eje;
        $card4['pim'] = $opt1[0]->pim;
        $card4['eje'] = $opt1[0]->eje;

        return view('Presupuesto.BaseIngresos.IngresoPresupuesto', compact('card1', 'card2', 'card3', 'card4', 'impG', 'impI'));
    }

    public function ingresopresupuestalgrafica1(Request $rq)
    {
        $info = BaseIngresosRepositorio::pim_tipogobierno($rq->get('importacion_id'));
        return response()->json(compact('info'));
    }

    public function ingresopresupuestalgrafica2(Request $rq)
    {
        $info = BaseIngresosRepositorio::pim_pia_devengado_tipogobierno($rq->get('importacion_id'));
        $data['categoria'] = ['GOBIERNO NACIONAL', 'GOBIERNOS REGIONALES', 'GOBIERNOS LOCALES'];
        $data['series'] = [];
        $dx1 = [];
        $dx2 = [];
        $dx3 = [];
        foreach ($info as $key => $value) {
            //$dx1[] = $value->y1; //pia
            $dx2[] = $value->y2; //pim
            $dx3[] = round($value->y3, 2); //devengado
        }
        //$data['series'][] = ['name' => 'PIA', 'color' => '#7C7D7D', 'data' => $dx1];
        $data['series'][] = ['name' => 'PIM', 'color' => '#317eeb', 'data' => $dx2];
        $data['series'][] = ['name' => 'DEVENGADO', 'color' => '#ef5350', 'data' => $dx3];
        return response()->json(compact('data'));
    }

    public function ingresopresupuestalgrafica3()
    {
        $info = BaseIngresosRepositorio::pim_anios_tipogobierno();
        $data['categoria'] = [];
        $data['series'] = [];
        $dx1 = [];
        $dx2 = [];
        $dx3 = [];
        foreach ($info as $key => $ba) {
            $data['categoria'][] = $ba->ano;
            $dx1[] = $ba->pim1;
            $dx2[] = $ba->pim2;
            $dx3[] = $ba->pim3;
        }
        $data['series'][] = ['name' => 'GOBIERNO NACIONAL', 'color' => '#7e57c2',  'data' => $dx1];
        $data['series'][] = ['name' => 'GOBIERNOS REGIONALES', 'color' => '#317eeb',  'data' => $dx2];
        $data['series'][] = ['name' => 'GOBIERNOS LOCALES', 'color' => '#ef5350', 'data' => $dx3];
        return response()->json(compact('data'));
    }

    /* fin IngresoPresupuestal */
}
