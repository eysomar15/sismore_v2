<?php

namespace App\Http\Controllers\Presupuesto;

use App\Exports\BaseGastosExport;
use App\Http\Controllers\Controller;
use App\Models\Educacion\Importacion;
use App\Models\Presupuesto\BaseSiafWeb;
use App\Models\Presupuesto\CategoriaGasto;
use App\Models\Presupuesto\Funcion;
use App\Models\Presupuesto\ProductoProyecto;
use App\Models\Presupuesto\TipoGobierno;
use App\Models\Presupuesto\UnidadEjecutora;
use App\Repositories\Presupuesto\BaseGastosRepositorio;
use App\Repositories\Presupuesto\BaseSiafWebRepositorio;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;

class BaseSiafWebController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function reporte1()
    {
        /* $impG = Importacion::where('fuenteimportacion_id', '13')->where('estado', 'PR')->orderBy('fechaActualizacion', 'desc')->first();
        $bgs = BaseSiafWeb::where('importacion_id', $impG->id)->first();
        $impI = Importacion::where('fuenteimportacion_id', '15')->where('estado', 'PR')->orderBy('fechaActualizacion', 'desc')->first(); */
        $ano = BaseSiafWeb::select(DB::raw('distinct anio'))
            ->join('par_importacion as v2', 'v2.id', '=', 'pres_base_siafweb.importacion_id')
            ->orderBy('anio', 'desc')->get();
        $articulo = ProductoProyecto::all();
        $funcion = Funcion::all();
        $categoria = CategoriaGasto::all();
        $ue = UnidadEjecutora::all();

        return view('Presupuesto.BaseSiafWeb.Reporte1', compact('ano', 'articulo', 'funcion', 'categoria', 'ue'));
    }

    public function reporte1tabla01(Request $rq)
    {
        $body = BaseSiafWebRepositorio::listar_unidadejecutora_anio_acticulo_funcion_categoria($rq->get('anio'), $rq->get('articulo'), $rq->get('funcion'), $rq->get('categoria'));
        $foot = ['pia' => 0, 'pim' => 0, 'cert' => 0, 'dev' => 0, 'eje' => 0, 'saldo1' => 0, 'saldo2' => 0,];
        foreach ($body as $key => $value) {
            $foot['pia'] += $value->pia;
            $foot['pim'] += $value->pim;
            $foot['cert'] += $value->cert;
            $foot['dev'] += $value->dev;
            $foot['saldo1'] += $value->saldo1;
            $foot['saldo2'] += $value->saldo2;
        }
        $foot['eje'] = $foot['pim'] > 0 ? number_format(100 * $foot['dev'] / $foot['pim'], 1) : 0;
        return view("Presupuesto.BaseSiafWeb.Reporte1Tabla1", compact('body', 'foot'));
    }

    public function reporte1tabla02(Request $rq)
    {
        $body = BaseSiafWebRepositorio::listar_fuentefinanciamiento_anio_acticulo_ue_categoria($rq->get('anio'), $rq->get('articulo'), $rq->get('ue'), $rq->get('categoria'));
        $foot = ['pia' => 0, 'pim' => 0, 'cert' => 0, 'dev' => 0, 'eje' => 0, 'saldo1' => 0, 'saldo2' => 0,];
        foreach ($body as $key => $value) {
            $foot['pia'] += $value->pia;
            $foot['pim'] += $value->pim;
            $foot['cert'] += $value->cert;
            $foot['dev'] += $value->dev;
            $foot['saldo1'] += $value->saldo1;
            $foot['saldo2'] += $value->saldo2;
        }
        $foot['eje'] = $foot['pim'] > 0 ? number_format(100 * $foot['dev'] / $foot['pim'], 1) : 0;
        return view("Presupuesto.BaseSiafWeb.Reporte1Tabla2", compact('body', 'foot'));
    }

    public function reporte1tabla03(Request $rq)
    {
        $body = BaseSiafWebRepositorio::listar_generica_anio_acticulo_ue_categoria($rq->get('anio'), $rq->get('articulo'), $rq->get('ue'), $rq->get('categoria'));
        $foot = ['pia' => 0, 'pim' => 0, 'cert' => 0, 'dev' => 0, 'eje' => 0, 'saldo1' => 0, 'saldo2' => 0,];
        foreach ($body as $key => $value) {
            $foot['pia'] += $value->pia;
            $foot['pim'] += $value->pim;
            $foot['cert'] += $value->cert;
            $foot['dev'] += $value->dev;
            $foot['saldo1'] += $value->saldo1;
            $foot['saldo2'] += $value->saldo2;
        }
        $foot['eje'] = $foot['pim'] > 0 ? number_format(100 * $foot['dev'] / $foot['pim'], 1) : 0;
        return view("Presupuesto.BaseSiafWeb.Reporte1Tabla3", compact('body', 'foot'));
    }

    public function reporte1tabla04(Request $rq)
    {
        $body = BaseSiafWebRepositorio::listar_funcion_anio_acticulo_ue_categoria($rq->get('anio'), $rq->get('articulo'), $rq->get('ue'), $rq->get('categoria'));
        $foot = ['pia' => 0, 'pim' => 0, 'cert' => 0, 'dev' => 0, 'eje' => 0, 'saldo1' => 0, 'saldo2' => 0,];
        foreach ($body as $key => $value) {
            $foot['pia'] += $value->pia;
            $foot['pim'] += $value->pim;
            $foot['cert'] += $value->cert;
            $foot['dev'] += $value->dev;
            $foot['saldo1'] += $value->saldo1;
            $foot['saldo2'] += $value->saldo2;
        }
        $foot['eje'] = $foot['pim'] > 0 ? number_format(100 * $foot['dev'] / $foot['pim'], 1) : 0;
        return view("Presupuesto.BaseSiafWeb.Reporte1Tabla4", compact('body', 'foot'));
    }
}
