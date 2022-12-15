<?php

namespace App\Http\Controllers\Presupuesto;

use App\Exports\BaseGastosExport;
use App\Http\Controllers\Controller;
use App\Models\Educacion\Importacion;
use App\Models\Presupuesto\BaseSiafWeb;
use App\Models\Presupuesto\CategoriaGasto;
use App\Models\Presupuesto\FuenteFinanciamiento;
use App\Models\Presupuesto\Funcion;
use App\Models\Presupuesto\GenericaGasto;
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
        $ano = BaseSiafWeb::select(DB::raw('distinct anio'))
            ->join('par_importacion as v2', 'v2.id', '=', 'pres_base_siafweb.importacion_id')->where('v2.estado', 'PR')
            ->orderBy('anio', 'desc')->get();
        $articulo = ProductoProyecto::all();
        $categoria = CategoriaGasto::all();

        return view('Presupuesto.BaseSiafWeb.Reporte1', compact('ano', 'articulo',  'categoria'));
    }

    public function reporte1tabla01(Request $rq)
    {
        $body = BaseSiafWebRepositorio::listar_unidadejecutora_anio_acticulo_funcion_categoria($rq->get('anio'), $rq->get('articulo'), $rq->get('categoria'));
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

    public function reporte2()
    {
        $ano = BaseSiafWeb::select(DB::raw('distinct anio'))
            ->join('par_importacion as v2', 'v2.id', '=', 'pres_base_siafweb.importacion_id')
            ->orderBy('anio', 'desc')->get();
        $articulo = ProductoProyecto::all();
        $ue = UnidadEjecutora::select('pres_unidadejecutora.id', 'pres_unidadejecutora.abreviatura as nombre')
            ->join('pres_pliego as v2', 'v2.id', '=', 'pres_unidadejecutora.pliego_id')
            ->join('pres_sector as v3', 'v3.id', '=', 'v2.sector_id')
            ->join('pres_tipo_gobierno as v4', 'v4.id', '=', 'v3.tipogobierno_id')
            ->where('v4.id', 3)
            ->get();

        return view('Presupuesto.BaseSiafWeb.Reporte2', compact('ano', 'articulo',  'ue'));
    }

    public function reporte2tabla01(Request $rq)
    {
        $body = BaseSiafWebRepositorio::listar_categoria_anio_acticulo_ue_categoria($rq->get('anio'), $rq->get('articulo'), $rq->get('ue'));
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
        return view("Presupuesto.BaseSiafWeb.Reporte2Tabla1", compact('body', 'foot'));
    }

    public function reporte3()
    {
        $ano = BaseSiafWeb::select(DB::raw('distinct anio'))
            ->join('par_importacion as v2', 'v2.id', '=', 'pres_base_siafweb.importacion_id')
            ->orderBy('anio', 'desc')->get();
        $articulo = ProductoProyecto::all();
        $ue = UnidadEjecutora::select('pres_unidadejecutora.id', 'pres_unidadejecutora.abreviatura as nombre')
            ->join('pres_pliego as v2', 'v2.id', '=', 'pres_unidadejecutora.pliego_id')
            ->join('pres_sector as v3', 'v3.id', '=', 'v2.sector_id')
            ->join('pres_tipo_gobierno as v4', 'v4.id', '=', 'v3.tipogobierno_id')
            ->where('v4.id', 3)
            ->get();

        return view('Presupuesto.BaseSiafWeb.Reporte3', compact('ano', 'articulo',  'ue'));
    }

    public function reporte3tabla01(Request $rq)
    {
        $body = BaseSiafWebRepositorio::listar_productoproyecto_anio_acticulo_ue_categoria($rq->get('anio'), $rq->get('articulo'), $rq->get('ue'));
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
        return view("Presupuesto.BaseSiafWeb.Reporte3Tabla1", compact('body', 'foot'));
    }

    public function reporte4()
    {
        $ano = BaseSiafWeb::select(DB::raw('distinct anio'))
            ->join('par_importacion as v2', 'v2.id', '=', 'pres_base_siafweb.importacion_id')->where('v2.estado', 'PR')
            ->orderBy('anio', 'desc')->get();
        $articulo = ProductoProyecto::all();
        $ue = UnidadEjecutora::select('pres_unidadejecutora.id', 'pres_unidadejecutora.abreviatura as nombre')
            ->join('pres_pliego as v2', 'v2.id', '=', 'pres_unidadejecutora.pliego_id')
            ->join('pres_sector as v3', 'v3.id', '=', 'v2.sector_id')
            ->join('pres_tipo_gobierno as v4', 'v4.id', '=', 'v3.tipogobierno_id')
            ->where('v4.id', 3)
            ->get();

        return view('Presupuesto.BaseSiafWeb.Reporte4', compact('ano', 'articulo',  'ue'));
    }

    public function reporte4tabla01(Request $rq)
    {
        $body = BaseSiafWebRepositorio::listar_funcion_anio_acticulo_ue_categoria($rq->get('anio'), $rq->get('articulo'), $rq->get('ue'));
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
        return view("Presupuesto.BaseSiafWeb.Reporte4Tabla1", compact('body', 'foot'));
    }

    public function reporte5()
    {
        $ano = BaseSiafWeb::select(DB::raw('distinct anio'))
            ->join('par_importacion as v2', 'v2.id', '=', 'pres_base_siafweb.importacion_id')->where('v2.estado', 'PR')
            ->orderBy('anio', 'desc')->get();
        $articulo = ProductoProyecto::all();
        $ue = UnidadEjecutora::select('pres_unidadejecutora.id', 'pres_unidadejecutora.abreviatura as nombre')
            ->join('pres_pliego as v2', 'v2.id', '=', 'pres_unidadejecutora.pliego_id')
            ->join('pres_sector as v3', 'v3.id', '=', 'v2.sector_id')
            ->join('pres_tipo_gobierno as v4', 'v4.id', '=', 'v3.tipogobierno_id')
            ->where('v4.id', 3)
            ->get();
        return view('Presupuesto.BaseSiafWeb.Reporte5', compact('ano', 'articulo',  'ue'));
    }

    public function reporte5tabla01(Request $rq)
    {
        $body = BaseSiafWebRepositorio::listar_fuentefinanciamiento_anio_acticulo_ue_categoria($rq->get('anio'), $rq->get('articulo'), $rq->get('ue'));
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
        return view("Presupuesto.BaseSiafWeb.Reporte5Tabla1", compact('body', 'foot'));
    }

    public function reporte6()
    {
        $ano = BaseSiafWeb::select(DB::raw('distinct anio'))
            ->join('par_importacion as v2', 'v2.id', '=', 'pres_base_siafweb.importacion_id')->where('v2.estado', 'PR')
            ->orderBy('anio', 'desc')->get();
        $articulo = ProductoProyecto::all();
        $ue = UnidadEjecutora::select('pres_unidadejecutora.id', 'pres_unidadejecutora.abreviatura as nombre')
            ->join('pres_pliego as v2', 'v2.id', '=', 'pres_unidadejecutora.pliego_id')
            ->join('pres_sector as v3', 'v3.id', '=', 'v2.sector_id')
            ->join('pres_tipo_gobierno as v4', 'v4.id', '=', 'v3.tipogobierno_id')
            ->where('v4.id', 3)
            ->get();

        return view('Presupuesto.BaseSiafWeb.Reporte6', compact('ano', 'articulo', 'ue'));
    }

    public function reporte6tabla01(Request $rq)
    {
        $data = BaseSiafWebRepositorio::listar_generica_anio_acticulo_ue_categoria($rq->get('anio'), $rq->get('articulo'), $rq->get('ue'));
        $body = $data['body'];
        $head = $data['head'];
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
        return view("Presupuesto.BaseSiafWeb.Reporte6Tabla1", compact('head', 'body', 'foot'));
    }

    public function reporte7()
    {
        $ano = BaseSiafWeb::select(DB::raw('distinct anio'))
            ->join('par_importacion as v2', 'v2.id', '=', 'pres_base_siafweb.importacion_id')
            ->orderBy('anio', 'desc')->get();
        $articulo = ProductoProyecto::all();
        $ue = UnidadEjecutora::select('pres_unidadejecutora.id', 'pres_unidadejecutora.abreviatura as nombre')
            ->join('pres_pliego as v2', 'v2.id', '=', 'pres_unidadejecutora.pliego_id')
            ->join('pres_sector as v3', 'v3.id', '=', 'v2.sector_id')
            ->join('pres_tipo_gobierno as v4', 'v4.id', '=', 'v3.tipogobierno_id')
            ->where('v4.id', 3)
            ->get();
        $ff = FuenteFinanciamiento::all();
        $gg = GenericaGasto::all();

        return view('Presupuesto.BaseSiafWeb.Reporte7', compact('ano', 'articulo', 'ue', 'ff', 'gg'));
    }

    public function reporte7tabla01(Request $rq)
    {
        $body = BaseSiafWebRepositorio::listar_subgenerica_anio_acticulo_ue_categoria($rq->get('anio'), $rq->get('articulo'), $rq->get('ue'),$rq->get('ff'), $rq->get('generica'), $rq->get('sg'));
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
        return view("Presupuesto.BaseSiafWeb.Reporte7Tabla1", compact('body', 'foot'));
    }
}
