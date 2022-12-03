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
use App\Repositories\Presupuesto\GobiernosRegionalesRepositorio;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;

class GobiernosRegionalesController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /* nivel gobiernos */
    public function principal()
    {
        $anos = GobiernosRegionalesRepositorio::anios();
        $mensaje = "";
        return view('Presupuesto.GobiernosRegionales.Principal', compact('mensaje', 'anos'));
    }

    public function cargarmes(Request $rq)
    {
        $info = GobiernosRegionalesRepositorio::meses($rq->ano);
        return response()->json(compact('info'));
    }

    public function principaltabla01(Request $rq)
    {
        $body = GobiernosRegionalesRepositorio::tipos_gobiernosregionales($rq->get('ano'), $rq->get('mes'), $rq->get('tipo'));
        $foot = ['pia' => 0, 'pim' => 0, 'certificacion' => 0, 'compromiso' => 0, 'devengado' => 0, 'eje' => 0, 'saldo1' => 0, 'saldo2' => 0];
        foreach ($body as $key => $value) {
            $foot['pia'] += $value->pia;
            $foot['pim'] += $value->pim;
            $foot['certificacion'] += $value->certificacion;
            $foot['compromiso'] += $value->compromiso_anual;
            $foot['devengado'] += $value->devengado;
            $foot['eje'] += $value->eje;
            $foot['saldo1'] += $value->saldo1;
            $foot['saldo2'] += $value->saldo2;
        }
        $foot['eje'] = $foot['pim'] > 0 ? round(100 * $foot['devengado'] / $foot['pim'], 1) : 0;
        return view("Presupuesto.GobiernosRegionales.PrincipalTabla1", compact('body', 'foot'));
    }

    /* public function avancepresupuestalmapa1($importacion_id)
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
    } */

    /* public function avancepresupuestalgrafica3()
    {
        $mes = ['Ene', 'Feb', 'Mar', 'Abr', 'May', 'Jun', 'Jul', 'Ago', 'Set', 'Oct', 'Nov', 'Dic'];
        $array = BaseProyectosRepositorio::baseids_fecha_max(date('Y'));
        $base = BaseProyectosRepositorio::listado_ejecucion($array);

        $info['categoria'] = $mes;
        $info['series'] = [null, null, null, null, null, null, null, null, null, null, null, null];
        for ($i = 1; $i < 13; $i++) {
            $puesto = 1;
            foreach ($base as $key => $value) {
                if ($value->mes == $i) {
                    if ($value->dep == 25) {
                        //$info[] = ['name' => $mes[$i - 1], 'y' => $puesto];
                        $info['series'][$value->mes - 1] = $puesto;
                    }
                    $puesto++;
                }
            }
        }
        return response()->json(compact('info'));
    } */

    /* public function avancepresupuestalgrafica4()
    {
        $mes = ['Ene', 'Feb', 'Mar', 'Abr', 'May', 'Jun', 'Jul', 'Ago', 'Set', 'Oct', 'Nov', 'Dic'];
        $array = BaseSiafWebRepositorio::baseids_fecha_max(date('Y'));
        $base = BaseSiafWebRepositorio::suma_pim($array, 1);
        $info['categoria'] = $mes;
        $info['series'] = [null, null, null, null, null, null, null, null, null, null, null, null];
        foreach ($base as $key => $value) {
            $info['series'][$value->name - 1] = $value->y;
        }
        return response()->json(compact('info'));
    } */

    /* public function avancepresupuestalgrafica5()
    {
        $mes = ['Ene', 'Feb', 'Mar', 'Abr', 'May', 'Jun', 'Jul', 'Ago', 'Set', 'Oct', 'Nov', 'Dic'];
        $array = BaseSiafWebRepositorio::baseids_fecha_max(date('Y'));
        $info = BaseSiafWebRepositorio::suma_certificado($array, 1);
        $monto = 0;
        foreach ($info as $key => $value) {
            $value->name = $mes[$value->name - 1];
            $value->y -= $monto;
            $monto = $value->y + $monto;
            $value->y = round($value->y, 2);
            $value->color = ($value->y < 0 ? '#ef5350' : '#317eeb');
        }
        return response()->json(compact('info'));
    } */

    /* public function avancepresupuestalgrafica6()
    {
        $mes = ['Ene', 'Feb', 'Mar', 'Abr', 'May', 'Jun', 'Jul', 'Ago', 'Set', 'Oct', 'Nov', 'Dic'];
        $array = BaseSiafWebRepositorio::baseids_fecha_max(date('Y'));
        $info = BaseSiafWebRepositorio::suma_devengado($array, 1);
        $monto = 0;
        foreach ($info as $key => $value) {
            $value->name = $mes[$value->name - 1];
            $value->y -= $monto;
            $monto = $value->y + $monto;
            $value->y = round($value->y, 2);
            $value->color = ($value->y < 0 ? '#ef5350' : '#317eeb');
        }
        return response()->json(compact('info'));
    } */

    /* public function avancepresupuestalgrafica7()
    {
        $info['categoria'] = ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Setiembre', 'Octubre', 'Noviembre', 'Diciembre'];
        $array = BaseSiafWebRepositorio::baseids_fecha_max(date('Y'));
        $query = BaseSiafWebRepositorio::suma_xxxx($array, 1);
        $info['series'] = [];
        //$dx1 = [null, null, null, null, null, null, null, null, null, null, null, null];
        $dx2 = [null, null, null, null, null, null, null, null, null, null, null, null];
        $dx3 = [null, null, null, null, null, null, null, null, null, null, null, null];
        $dx4 = [null, null, null, null, null, null, null, null, null, null, null, null];
        $dx5 = [null, null, null, null, null, null, null, null, null, null, null, null];
        foreach ($query as $key => $value) {
            //$dx1[$key] = $value->y1; //pia
            $dx2[$key] = $value->y2; //pim
            $dx3[$key] = $value->y3; //devengado
            $dx4[$key] = $value->y4; //devengado
            $dx5[$key] = $value->y5; //devengado
        }
        //$info['series'][] = ['type' => 'column', 'yAxis' => 0, 'name' => 'PIM', 'color' => '#7C7D7D', 'data' => $dx1];
        $info['series'][] = ['type' => 'column', 'yAxis' => 0, 'name' => 'CERTIFICADO', 'color' => '#317eeb', 'data' => $dx2];
        $info['series'][] = ['type' => 'column', 'yAxis' => 0, 'name' => 'DEVENGADO', 'color' => '#ef5350', 'data' => $dx3];
        $info['series'][] = ['type' => 'spline', 'yAxis' => 1, 'name' => '%AVANCE CERT', 'tooltip' => ['valueSuffix' => ' %'], 'color' => '#317eeb', 'data' => $dx4];
        $info['series'][] = ['type' => 'spline', 'yAxis' => 1, 'name' => '%EJECUCIÓN',  'tooltip' => ['valueSuffix' => ' %'], 'color' => '#ef5350', 'data' => $dx5];
        return response()->json(compact('info'));
    } */
}
