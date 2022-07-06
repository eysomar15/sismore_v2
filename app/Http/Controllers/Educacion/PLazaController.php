<?php

namespace App\Http\Controllers\Educacion;

use App\Http\Controllers\Controller;
use App\Models\Educacion\PLaza;
use App\Models\Parametro\Anio;
use App\Repositories\Educacion\PlazaRepositorio;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PLazaController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function DocentesPrincipal()
    {
        $anios = PLazaRepositorio::listar_anios();
        return view('educacion.Plaza.DocentesPrincipal', compact('anios'));
    }

    public function cargardistritos($provincia)
    {
        $distritos = PlazaRepositorio::listar_distrito($provincia);
        return response()->json(compact('distritos'));
    }

    public function cargarmes($anio)
    {
        $meses = PlazaRepositorio::listar_meses($anio);
        return response()->json(compact('meses'));
    }

    public function cargarultimoimportado($anio, $mes)
    {
        $importados = PlazaRepositorio::listar_importados($anio, $mes);
        if (count($importados) > 0)
            $importado = $importados->first();
        else $importado = null;

        return response()->json(compact('importado'));
    }

    public function datoIndicadorPLaza(Request $request)
    {
        $dato['tt'] = PlazaRepositorio::listar_profesorestitulados($request->fecha, $request->nivel, $request->provincia, $request->distrito);
        $dato['tu'] = PlazaRepositorio::listar_profesorestituladougel($request->fecha, $request->nivel, 1);
        return response()->json(compact('dato'));
    }

    public function menuDocentes($importacion_id, $anio)
    {
        //$info['v1'] = PlazaRepositorio::listar_docentesporniveleducativo_grafica($importacion_id);
        //$info['v2'] = PlazaRepositorio::listar_docentesyauxiliaresporugel_grafica($importacion_id);
        //$info['v3'] = PlazaRepositorio::listar_trabajadoresadministrativosporugel_grafica($importacion_id);
        //$info['v4'] = PlazaRepositorio::listar_trabajadorespecporugel_grafica($importacion_id);
        $info['opt1'] = PlazaRepositorio::listar_tipotrabajadores($importacion_id, 1)->count();
        $info['opt2'] = PlazaRepositorio::listar_tipotrabajadores($importacion_id, 2)->count();
        $info['opt3'] = PlazaRepositorio::listar_tipotrabajadores($importacion_id, 3)->count();
        $info['opt4'] = PlazaRepositorio::listar_tipotrabajadores($importacion_id, 4)->count();
        $info['v1'] = PlazaRepositorio::listar_plazasegununidaddegestioneducativa_grafica($importacion_id);
        $info['v2'] = PlazaRepositorio::listar_plazaseguntipodeniveleducactivo_grafica($importacion_id);
        $info['v3'] = PlazaRepositorio::listar_plazaseguntipotrabajador_grafica($importacion_id);
        $info['v4'] = PlazaRepositorio::listar_plazadocenteseguntipodeniveleducactivo_grafica($importacion_id);
        $info['v5'] = PlazaRepositorio::listar_plazadocentesegunsituacionlaboral_grafica($importacion_id);
        $info['v6'] = PlazaRepositorio::listar_plazadocentesegunregimenlaboral_grafica($importacion_id);
        $info['v7'] = PlazaRepositorio::listar_plazadocentesegunano_grafica();
        $info['v8'] = PlazaRepositorio::listar_plazadocentesegunmes_grafica($importacion_id, $anio);
        $info['DT'] = PlazaRepositorio::listar_totalplazacontratadoynombradossegunugelyniveleducativo($importacion_id);
        return response()->json(compact('info'));
    }
}
