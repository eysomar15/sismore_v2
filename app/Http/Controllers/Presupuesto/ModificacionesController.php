<?php

namespace App\Http\Controllers\Presupuesto;

use App\Exports\BaseGastosExport;
use App\Http\Controllers\Controller;
use App\Models\Educacion\Importacion;
use App\Models\Presupuesto\BaseModificacionDetalle;
use App\Models\Presupuesto\BaseProyectos;
use App\Models\Presupuesto\BaseSiafWeb;
use App\Models\Presupuesto\ProductoProyecto;
use App\Models\Presupuesto\TipoGobierno;
use App\Models\Presupuesto\TipoModificacion;
use App\Models\Presupuesto\TipoTransaccion;
use App\Repositories\Presupuesto\BaseGastosRepositorio;
use App\Repositories\Presupuesto\BaseProyectosRepositorio;
use App\Repositories\Presupuesto\BaseSiafWebRepositorio;
use App\Repositories\Presupuesto\GobiernosRegionalesRepositorio;
use App\Repositories\Presupuesto\ModificacionesRepositorio;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;

class ModificacionesController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /* nivel gobiernos */
    public function principal()
    {
        $opt1 = ModificacionesRepositorio::anios();
        $opt3 = ProductoProyecto::all();
        $opt4 = TipoModificacion::orderBy('codigo', 'asc')->get();
        $opt5 = BaseModificacionDetalle::select(DB::raw('distinct dispositivo_legal'))
            ->where('dispositivo_legal', '!=', '')
            ->orderBy('dispositivo_legal', 'asc')->get();
        $opt6 = TipoTransaccion::select('v2.id', DB::raw('concat(pres_tipotransaccion.codigo,".",v2.codigo,".",v2.nombre) as nombre'))
            ->join('pres_generica_gastos as v2', 'v2.tipotransaccion_id', '=', 'pres_tipotransaccion.id')
            ->get();
        $mensaje = "";
        return view('Presupuesto.Modificaciones.Principal', compact('mensaje', 'opt1', 'opt3', 'opt4', 'opt5', 'opt6'));
    }

    public function cargarmes(Request $rq)
    {
        $info = ModificacionesRepositorio::meses($rq->ano);
        return response()->json(compact('info'));
        //return $mes;
    }

    public function principaltabla01(Request $rq)
    {
        $body = ModificacionesRepositorio::listar_modificaciones($rq->get('ano'), $rq->get('mes'), $rq->get('productoproyecto'), $rq->get('tipomodificacion'), $rq->get('dispositivototal'), $rq->get('generica'));
        //return $body;
        /* $foot = ['pia' => 0, 'pim' => 0, 'certificacion' => 0, 'compromiso' => 0, 'devengado' => 0, 'eje' => 0, 'saldo1' => 0, 'saldo2' => 0];
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
        $foot['eje'] = round(100 * $foot['devengado'] / $foot['pim'], 1); */
        return view("Presupuesto.Modificaciones.PrincipalTabla1", compact('body'));
    }
}
