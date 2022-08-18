<?php

namespace App\Http\Controllers\Educacion;

use App\Http\Controllers\Controller;
use App\Models\Educacion\Area;
use App\Models\Educacion\Importacion;
use App\Models\Educacion\NivelModalidad;
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
        /* $imp = Importacion::where('fuenteImportacion_id', '2')->where('estado', 'PR')->orderBy('fechaActualizacion', 'desc')
            ->select('id', 'fechaActualizacion')->take(1)->first(); */
        /* $fecha = date('d/m/Y', strtotime($imp->fechaActualizacion)); */

        return view('educacion.Plaza.DocentesPrincipal', compact('anios'));
    }

    public function nemuDocente($importacion_id, $anio)
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

    public function DocentesPrincipalHead(Request $rq)
    {
        $imp = $this->cargarultimoimportado($rq->anio, 0)->id;
        $info['opt1'] = PlazaRepositorio::listar_tipotrabajadores($imp, 1)->count();
        $info['opt2'] = PlazaRepositorio::listar_tipotrabajadores($imp, 2)->count();
        $info['opt3'] = PlazaRepositorio::listar_tipotrabajadores($imp, 3)->count();
        $info['opt4'] = PlazaRepositorio::listar_tipotrabajadores($imp, 4)->count();
        return response()->json(compact('info'));
    }

    public function DocentesPrincipalgra1(Request $rq)
    {
        $imp = $this->cargarultimoimportado($rq->anio, 0)->id;
        $info['v1'] = PlazaRepositorio::listar_plazasegununidaddegestioneducativa_grafica($imp);
        return response()->json(compact('info'));
    }

    public function DocentesPrincipalgra2(Request $rq)
    {
        $imp = $this->cargarultimoimportado($rq->anio, 0)->id;
        $info['v2'] = PlazaRepositorio::listar_plazaseguntipodeniveleducactivo_grafica($imp);
        return response()->json(compact('info'));
    }

    public function DocentesPrincipalgra3(Request $rq)
    {
        $imp = $this->cargarultimoimportado($rq->anio, 0)->id;
        $info['v3'] = PlazaRepositorio::listar_plazaseguntipotrabajador_grafica($imp);
        return response()->json(compact('info'));
    }

    public function DocentesPrincipalgra4(Request $rq)
    {
        $imp = $this->cargarultimoimportado($rq->anio, 0)->id;
        $info['v4'] = PlazaRepositorio::listar_plazadocenteseguntipodeniveleducactivo_grafica($imp);
        return response()->json(compact('info'));
    }

    public function DocentesPrincipalgra5(Request $rq)
    {
        $imp = $this->cargarultimoimportado($rq->anio, 0)->id;
        $info['v5'] = PlazaRepositorio::listar_plazadocentesegunsituacionlaboral_grafica($imp);
        return response()->json(compact('info'));
    }

    public function DocentesPrincipalgra6(Request $rq)
    {
        $imp = $this->cargarultimoimportado($rq->anio, 0)->id;
        $info['v6'] = PlazaRepositorio::listar_plazadocentesegunregimenlaboral_grafica($imp);
        return response()->json(compact('info'));
    }

    public function DocentesPrincipalgra7(Request $rq)
    {
        //$imp = $this->cargarultimoimportado($rq->anio, 0)->id;
        $info['v7'] = PlazaRepositorio::listar_plazassegunano_grafica();
        return response()->json(compact('info'));
    }

    public function DocentesPrincipalgra8(Request $rq)
    {
        $imp = $this->cargarultimoimportado($rq->anio, 0)->id;
        $info['v8'] = PlazaRepositorio::listar_plazassegunmes_grafica($imp, $rq->anio);
        return response()->json(compact('info'));
    }

    public function DocentesPrincipalgra9(Request $rq)
    {
        //$imp = $this->cargarultimoimportado($rq->anio, 0)->id;
        $info['v9'] = PlazaRepositorio::listar_plazadocentesegunano_grafica();
        return response()->json(compact('info'));
    }

    public function DocentesPrincipalgra10(Request $rq)
    {
        $imp = $this->cargarultimoimportado($rq->anio, 0)->id;
        $info['v10'] = PlazaRepositorio::listar_plazadocentesegunmes_grafica($imp, $rq->anio);
        return response()->json(compact('info'));
    }

    public function DocentesPrincipalDT1(Request $rq)
    {
        $imp = $this->cargarultimoimportado($rq->anio, 0);
        $info['fecha'] = date('d/m/Y', strtotime($imp->fechaActualizacion));
        $info['DT'] = PlazaRepositorio::listar_totalplazacontratadoynombradossegunugelyniveleducativo($imp->id);
        return response()->json(compact('info'));
    }

    public function DocentesPrincipalDT2(Request $rq)
    {
        $imp = $this->cargarultimoimportado($rq->anio, 0);
        $info['fecha'] = date('d/m/Y', strtotime($imp->fechaActualizacion));
        $info['DT'] = PlazaRepositorio::cargarresumendeplazatabla2($imp->id);
        return response()->json(compact('info'));
    }

    public function DocentesPrincipalDT3(Request $rq)
    {
        $imp = $this->cargarultimoimportado($rq->anio, 0);
        $info['fecha'] = date('d/m/Y', strtotime($imp->fechaActualizacion));
        $info['DT'] = PlazaRepositorio::cargarresumendeplazatabla3($imp->id);
        return response()->json(compact('info'));
    }

    public function DocentesPrincipalDT4(Request $rq)
    {
        $imp = $this->cargarultimoimportado($rq->anio, 0);
        $info['fecha'] = date('d/m/Y', strtotime($imp->fechaActualizacion));
        $info['DT'] = PlazaRepositorio::cargarresumendeplazatabla4($rq, $imp->id);
        return response()->json(compact('info'));
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
        else
            $importado = null;

        return $importado;
        //return response()->json(compact('importado'));
    }

    public function datoIndicadorPLaza(Request $request)
    {
        $dato['tt'] = PlazaRepositorio::listar_profesorestitulados($request->fecha, $request->nivel, $request->provincia, $request->distrito);
        $dato['tu'] = PlazaRepositorio::listar_profesorestituladougel($request->fecha, $request->nivel, 1);
        return response()->json(compact('dato'));
    }


    public function coberturaplaza()
    {
        /* $imp = $this->cargarultimoimportado($rq->anio, 0)->id;
        $info['opt1'] = PlazaRepositorio::listar_tipotrabajadores($imp, 1)->count();
        $info['opt2'] = PlazaRepositorio::listar_tipotrabajadores($imp, 2)->count();
        $info['opt3'] = PlazaRepositorio::listar_tipotrabajadores($imp, 3)->count();
        $info['opt4'] = PlazaRepositorio::listar_tipotrabajadores($imp, 4)->count();
        return response()->json(compact('info')); */

        /*  */

        /* anos */
        $anios = Importacion::select(DB::raw('YEAR(fechaActualizacion) as ano'))
            ->where('estado', 'PR')->where('fuenteImportacion_id', '2')
            ->orderBy('ano', 'desc')->distinct()->get();
        /* tipo modalidad */
        $tipo = NivelModalidad::select('tipo')->where(DB::raw('tipo is not null'), true)->groupBy('tipo')->get();
        /* nivel modalidad */
        //$nivel = NivelModalidad::select('id', 'nombre')->where('tipo', 'EBE')->get();
        /* ultimo reg subido */
        $imp = Importacion::select('id', 'fechaActualizacion as fecha')->where('estado', 'PR')->where('fuenteImportacion_id', '2')
            ->orderBy('fecha', 'desc')->take(1)->get();
        $importacion_id = $imp->first()->id;
        $fecha = date('d/m/Y', strtotime($imp->first()->fecha));
        //return [$anios, $tipo, $nivel, $imp, $fecha];
        return view("educacion.Plaza.CoberturaPlaza", compact('anios', 'tipo', 'importacion_id', 'fecha'));
    }
}
