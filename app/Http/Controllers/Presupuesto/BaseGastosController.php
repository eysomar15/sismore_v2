<?php

namespace App\Http\Controllers\Presupuesto;

use App\Exports\BaseGastosExport;
use App\Http\Controllers\Controller;
use App\Models\Presupuesto\TipoGobierno;
use App\Repositories\Presupuesto\BaseGastosRepositorio;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class BaseGastosController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /* nivel gobiernos */
    public function nivelgobiernos()
    {
        $gobs = TipoGobierno::where('id', '!=', 4)->orderBy('pos', 'asc')->get();
        $mensaje = "";
        return view('Presupuesto.BaseGastos.NivelGobiernos', compact('mensaje', 'gobs'));
    }

    public function cargarsector(Request $rq)
    {
        $sectors = BaseGastosRepositorio::cargarsector($rq->get('gobierno'));
        return response()->json(compact('sectors'));
    }

    public function cargarue(Request $rq)
    {
        $ues = BaseGastosRepositorio::cargarue($rq->get('gobierno'), $rq->get('sector'));
        return response()->json(compact('ues'));
    }

    public function nivelgobiernosgrafica01(Request $rq)
    {
        $base = BaseGastosRepositorio::pim_anio_categoriagasto($rq->get('gobierno'), $rq->get('sector'), $rq->get('ue'));
        $puntos['subtitulo'] = 'Pim por Año según Categoria Gasto';
        $puntos['categoria'] = [];
        $puntos['series'] = [];
        $dx1 = [];
        $dx2 = [];
        $dx3 = [];
        $vs1 = 0;
        $vs2 = 0;
        $vs3 = 0;
        foreach ($base as $key => $ba) {
            $puntos['categoria'][] = $ba->ano;
            $dx1[] = $ba->pim1;
            $dx2[] = $ba->pim2;
            $dx3[] = $ba->pim3;
            $vs1 += $ba->pim1;
            $vs2 += $ba->pim2;
            $vs3 += $ba->pim3;
        }
        if ($vs1 > 0)
            $puntos['series'][] = ['name' => 'GASTO CORRIENTE', 'color' => '#ef5350',  'data' => $dx1];
        if ($vs2 > 0)
            $puntos['series'][] = ['name' => 'GASTO DE CAPITAL', 'color' => '#317eeb',  'data' => $dx2];
        if ($vs3 > 0)
            $puntos['series'][] = ['name' => 'SERVICIO DE LA DEUDA', 'color' => '#7e57c2',  'data' => $dx3];
        //return $data;
        return response()->json(compact('puntos'));
    }

    public function nivelgobiernosgrafica02(Request $rq)
    {
        $data = BaseGastosRepositorio::pim_anio_categoriapresupuestal($rq->get('gobierno'), $rq->get('sector'), $rq->get('ue'));
        $puntos['subtitulo'] = 'Pim por Año según Categoria Presupuestal';
        $puntos['categoria'] = [];
        $puntos['series'] = [];
        $dx1 = [];
        $dx2 = [];
        $dx3 = [];
        foreach ($data as $key => $ba) {
            $puntos['categoria'][] = $ba->ano;
            $dx1[] = $ba->pim1;
            $dx2[] = $ba->pim2;
            $dx3[] = $ba->pim3;
        }
        $puntos['series'][] = ['name' => 'ACCIONES CENTRALES', 'color' => '#7e57c2',  'data' => $dx1];
        $puntos['series'][] = ['name' => 'APNOP', 'color' => '#317eeb',  'data' => $dx2];
        $puntos['series'][] = ['name' => 'PROGRAMA PRESUPUESTAL', 'color' => '#ef5350',  'data' => $dx3];
        return response()->json(compact('puntos'));
    }

    public function nivelgobiernostabla01(Request $rq)
    {
        $body = BaseGastosRepositorio::pim_anio_fuentefimanciamiento($rq->get('gobierno'), $rq->get('sector'), $rq->get('ue'));
        $foot = ['pim_2014' => 0, 'pim_2015' => 0, 'pim_2016' => 0, 'pim_2017' => 0, 'pim_2018' => 0, 'pim_2019' => 0, 'pim_2020' => 0, 'pim_2021' => 0, 'pim_2022' => 0];
        foreach ($body as $key => $value) {
            $foot['pim_2014'] += $value->pim_2014;
            $foot['pim_2015'] += $value->pim_2015;
            $foot['pim_2016'] += $value->pim_2016;
            $foot['pim_2017'] += $value->pim_2017;
            $foot['pim_2018'] += $value->pim_2018;
            $foot['pim_2019'] += $value->pim_2019;
            $foot['pim_2020'] += $value->pim_2020;
            $foot['pim_2021'] += $value->pim_2021;
            $foot['pim_2022'] += $value->pim_2022;
        }
        return view("Presupuesto.BaseGastos.NivelGobiernosTabla1", compact('body', 'foot'));
    }

    public function nivelgobiernostabla02(Request $rq)
    {
        $body = BaseGastosRepositorio::pim_anio_generica($rq->get('gobierno'), $rq->get('sector'), $rq->get('ue'));
        $foot = ['pim_2014' => 0, 'pim_2015' => 0, 'pim_2016' => 0, 'pim_2017' => 0, 'pim_2018' => 0, 'pim_2019' => 0, 'pim_2020' => 0, 'pim_2021' => 0, 'pim_2022' => 0];
        foreach ($body as $key => $value) {
            $foot['pim_2014'] += $value->pim_2014;
            $foot['pim_2015'] += $value->pim_2015;
            $foot['pim_2016'] += $value->pim_2016;
            $foot['pim_2017'] += $value->pim_2017;
            $foot['pim_2018'] += $value->pim_2018;
            $foot['pim_2019'] += $value->pim_2019;
            $foot['pim_2020'] += $value->pim_2020;
            $foot['pim_2021'] += $value->pim_2021;
            $foot['pim_2022'] += $value->pim_2022;
        }
        return view("Presupuesto.BaseGastos.NivelGobiernosTabla2", compact('body', 'foot'));
    }
    /* fin nivel gobiernos */


    public function download()
    {
        $name = 'tabla ' . date('Y-m-d') . '.xlsx';
        return Excel::download(new BaseGastosExport(1), $name);
    }
}
