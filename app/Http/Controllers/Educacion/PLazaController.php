<?php

namespace App\Http\Controllers\Educacion;

use App\Http\Controllers\Controller;
use App\Models\Educacion\Area;
use App\Models\Educacion\Importacion;
use App\Models\Educacion\NivelModalidad;
use App\Models\Educacion\PLaza;
use App\Models\Educacion\Ugel;
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
        /* anios */
        $anios = PLazaRepositorio::listar_anios();
        /* ugels */
        $ugels = Ugel::select('id', 'nombre', 'codigo')->where('codigo', 'like', '25%')->get();

        return view('educacion.Plaza.DocentesPrincipal', compact('anios', 'ugels'));
    }

    public function nemuDocente($importacion_id, $anio)
    {
        //$info['v1'] = PlazaRepositorio::listar_docentesporniveleducativo_grafica($importacion_id);
        //$info['v2'] = PlazaRepositorio::listar_docentesyauxiliaresporugel_grafica($importacion_id);
        //$info['v3'] = PlazaRepositorio::listar_trabajadoresadministrativosporugel_grafica($importacion_id);
        //$info['v4'] = PlazaRepositorio::listar_trabajadorespecporugel_grafica($importacion_id);
        /* $info['opt1'] = PlazaRepositorio::listar_tipotrabajadores($importacion_id, 1)->count();
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
        return response()->json(compact('info')); */
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
        $info['v1'] = PlazaRepositorio::listar_plazasegununidaddegestioneducativa_grafica($imp, $rq->ugel);
        return response()->json(compact('info'));
    }

    public function DocentesPrincipalgra2(Request $rq)
    {
        $imp = $this->cargarultimoimportado($rq->anio, 0)->id;
        $info['v2'] = PlazaRepositorio::listar_plazaseguntipodeniveleducactivo_grafica($imp, $rq->ugel);
        return response()->json(compact('info'));
    }

    public function DocentesPrincipalgra3(Request $rq)
    {
        $imp = $this->cargarultimoimportado($rq->anio, 0)->id;
        $info['v3'] = PlazaRepositorio::listar_plazaseguntipotrabajador_grafica($imp, $rq->ugel);
        return response()->json(compact('info'));
    }

    public function DocentesPrincipalgra4(Request $rq)
    {
        $imp = $this->cargarultimoimportado($rq->anio, 0)->id;
        $info['v4'] = PlazaRepositorio::listar_plazadocenteseguntipodeniveleducactivo_grafica($imp, $rq->ugel);
        return response()->json(compact('info'));
    }

    public function DocentesPrincipalgra5(Request $rq)
    {
        $imp = $this->cargarultimoimportado($rq->anio, 0)->id;
        $info['v5'] = PlazaRepositorio::listar_plazadocentesegunsituacionlaboral_grafica($imp, $rq->ugel);
        return response()->json(compact('info'));
    }

    public function DocentesPrincipalgra6(Request $rq)
    {
        $imp = $this->cargarultimoimportado($rq->anio, 0)->id;
        $info['v6'] = PlazaRepositorio::listar_plazadocentesegunregimenlaboral_grafica($imp, $rq->ugel);
        return response()->json(compact('info'));
    }

    public function DocentesPrincipalgra7(Request $rq)
    {
        //$imp = $this->cargarultimoimportado($rq->anio, 0)->id;
        $info['v7'] = PlazaRepositorio::listar_plazassegunano_grafica($rq->ugel);
        return response()->json(compact('info'));
    }

    public function DocentesPrincipalgra8(Request $rq)
    {
        $imp = $this->cargarultimoimportado($rq->anio, 0)->id;
        $info['v8'] = PlazaRepositorio::listar_plazassegunmes_grafica($imp, $rq->anio, $rq->ugel);
        return response()->json(compact('info'));
    }

    public function DocentesPrincipalgra9(Request $rq)
    {
        //$imp = $this->cargarultimoimportado($rq->anio, 0)->id;
        $info['v9'] = PlazaRepositorio::listar_plazadocentesegunano_grafica($rq->ugel);
        return response()->json(compact('info'));
    }

    public function DocentesPrincipalgra10(Request $rq)
    {
        $imp = $this->cargarultimoimportado($rq->anio, 0)->id;
        $info['v10'] = PlazaRepositorio::listar_plazadocentesegunmes_grafica($imp, $rq->anio, $rq->ugel);
        return response()->json(compact('info'));
    }

    public function DocentesPrincipalDT1(Request $rq)
    {
        $imp = $this->cargarultimoimportado($rq->anio, 0);
        $info['fecha'] = date('d/m/Y', strtotime($imp->fechaActualizacion));
        $info['DT'] = PlazaRepositorio::listar_totalplazacontratadoynombradossegunugelyniveleducativo($imp->id, $rq->ugel);
        return response()->json(compact('info'));
    }

    public function DocentesPrincipalDT2(Request $rq)
    {
        $imp = $this->cargarultimoimportado($rq->anio, 0);
        $info['fecha'] = date('d/m/Y', strtotime($imp->fechaActualizacion));
        $info['DT'] = PlazaRepositorio::cargarresumendeplazatabla2($imp->id, $rq->ugel);
        return response()->json(compact('info'));
    }

    public function DocentesPrincipalDT3(Request $rq)
    {
        $imp = $this->cargarultimoimportado($rq->anio, 0);
        $info['fecha'] = date('d/m/Y', strtotime($imp->fechaActualizacion));
        $info['DT'] = PlazaRepositorio::cargarresumendeplazatabla3($imp->id, $rq->ugel);
        return response()->json(compact('info'));
    }

    public function DocentesPrincipalDT4(Request $rq)
    {
        $imp = $this->cargarultimoimportado($rq->anio, 0);
        $info['fecha'] = date('d/m/Y', strtotime($imp->fechaActualizacion));
        $info['DT'] = PlazaRepositorio::cargarresumendeplazatabla4($rq, $imp->id, $rq->ugel);
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
        /* anos */
        $anios = Importacion::select(DB::raw('YEAR(fechaActualizacion) as ano'))
            ->where('estado', 'PR')->where('fuenteImportacion_id', '2')
            ->orderBy('ano', 'desc')->distinct()->get();
        /* tipo modalidad */
        $tipo = NivelModalidad::select('tipo')->where(DB::raw('tipo is not null'), true)->groupBy('tipo')->get();
        /* ugels */
        $ugels = Ugel::select('id', 'nombre', 'codigo')->where('codigo', 'like', '25%')->get();
        /* ultimo reg subido */
        $imp = Importacion::select('id', 'fechaActualizacion as fecha')->where('estado', 'PR')->where('fuenteImportacion_id', '2')
            ->orderBy('fecha', 'desc')->take(1)->get();
        $importacion_id = $imp->first()->id;
        $fecha = date('d/m/Y', strtotime($imp->first()->fecha));
        //return [$anios, $tipo, $nivel, $imp, $fecha];
        return view("educacion.Plaza.CoberturaPlaza", compact('anios', 'tipo', 'ugels', 'importacion_id', 'fecha'));
    }
    public function cargarcoberturaplazatabla1(Request $rq)
    {
        $ano = (int)$rq->ano;
        $tipo = $rq->tipo;
        $nivel = $rq->nivel;

        $opttipo = ($tipo == 0 ? "" : ($tipo == 3 ? " and v8.id=$tipo " : " and v8.id!=3 "));
        $optnivel = $nivel == 0 ? "" : " and v9.id=$nivel ";

        $error['ano'] = $ano;
        $error['tipo'] = $tipo;
        $error['nivel'] = $nivel;


        //$anios = ['2022', '2021', '2020'];
        $anoA = 0;
        $anoA = $ano - 1;
        //$error['anios'] = $anios;
        $error['anoA'] = $anoA;


        $fechas = DB::table(DB::raw("(
            select mes, max(fecha) fecha from (
                select
                    distinct
                    v3.fechaActualizacion fecha,
                    year(v3.fechaActualizacion) ano,
                    month(v3.fechaActualizacion) mes,
                    day(v3.fechaActualizacion) dia
                from edu_plaza as v1
                inner join par_importacion as v3 on v3.id=v1.importacion_id
                where v3.estado='PR' and YEAR(v3.fechaActualizacion)=$ano
                order by fecha desc
            ) as xx
            group by mes
            order by mes asc
                ) as xx"))->get();

        $error['fechas'] = $fechas;

        $fx = '';
        $anoI = 0;
        $anoF = 0;
        foreach ($fechas as $key => $value) {
            if ($key < count($fechas) - 1)
                $fx .= "'$value->fecha',";
            else
                $fx .= "'$value->fecha'";
            if ($key == 0) $anoI = $value->mes;
            if ($key == (count($fechas) - 1)) $anoF = $value->mes + 1;
        }

        $error['fx'] = $fx;
        $error['anoI'] = $anoI;
        $error['anoF'] = $anoF;


        return $error;


        $baseA = DB::table(DB::raw("(
        select
            v6.nombre ugel,
            sum(IF(month(v3.fechaActualizacion)=12,IF((v1.total_hombres+v1.total_mujeres)=0,v1.total_estudiantes,v1.total_hombres+v1.total_mujeres),0)) dic
        from edu_matricula_detalle as v1
        inner join edu_matricula as v2 on v2.id=v1.matricula_id
        inner join par_importacion as v3 on v3.id=v2.importacion_id
        inner join edu_institucioneducativa as v4 on v4.id=v1.institucioneducativa_id
        inner join edu_nivelmodalidad as v5 on v5.id=v4.NivelModalidad_id
        inner join edu_ugel as v6 on v6.id=v4.Ugel_id
        inner join edu_tipogestion as v7 on v7.id=v4.TipoGestion_id
        inner join edu_tipogestion as v8 on v8.id=v7.dependencia
        inner join edu_area as v9 on v9.id=v4.Area_id
        where v3.estado='PR' and v5.tipo in ('EBR','EBE') and v2.anio_id=$anoA and month(v3.fechaActualizacion)=12 $opttipo $optnivel
        group by ugel
        order by ugel asc
            ) as xx"))->get();
        if (count($baseA) == 0) {
            $baseA = Ugel::where('dependencia', '2')->select('nombre as ugel', DB::raw('0 as dic'))->get();
        }
        $error['baseA'] = $baseA;


        $base = DB::table(DB::raw("(
            select
                v6.id,
                v6.nombre ugel,
                sum(IF(month(v3.fechaActualizacion)= 1,IF((v1.total_hombres+v1.total_mujeres)=0,v1.total_estudiantes,v1.total_hombres+v1.total_mujeres),0)) ene,
                sum(IF(month(v3.fechaActualizacion)= 2,IF((v1.total_hombres+v1.total_mujeres)=0,v1.total_estudiantes,v1.total_hombres+v1.total_mujeres),0)) -
                sum(IF(month(v3.fechaActualizacion)= 1,IF((v1.total_hombres+v1.total_mujeres)=0,v1.total_estudiantes,v1.total_hombres+v1.total_mujeres),0)) feb,
                sum(IF(month(v3.fechaActualizacion)= 3,IF((v1.total_hombres+v1.total_mujeres)=0,v1.total_estudiantes,v1.total_hombres+v1.total_mujeres),0)) -
                sum(IF(month(v3.fechaActualizacion)= 2,IF((v1.total_hombres+v1.total_mujeres)=0,v1.total_estudiantes,v1.total_hombres+v1.total_mujeres),0)) mar,
                sum(IF(month(v3.fechaActualizacion)= 4,IF((v1.total_hombres+v1.total_mujeres)=0,v1.total_estudiantes,v1.total_hombres+v1.total_mujeres),0)) -
                sum(IF(month(v3.fechaActualizacion)= 3,IF((v1.total_hombres+v1.total_mujeres)=0,v1.total_estudiantes,v1.total_hombres+v1.total_mujeres),0)) abr,
                sum(IF(month(v3.fechaActualizacion)= 5,IF((v1.total_hombres+v1.total_mujeres)=0,v1.total_estudiantes,v1.total_hombres+v1.total_mujeres),0)) -
                sum(IF(month(v3.fechaActualizacion)= 4,IF((v1.total_hombres+v1.total_mujeres)=0,v1.total_estudiantes,v1.total_hombres+v1.total_mujeres),0)) may,
                sum(IF(month(v3.fechaActualizacion)= 6,IF((v1.total_hombres+v1.total_mujeres)=0,v1.total_estudiantes,v1.total_hombres+v1.total_mujeres),0)) -
                sum(IF(month(v3.fechaActualizacion)= 5,IF((v1.total_hombres+v1.total_mujeres)=0,v1.total_estudiantes,v1.total_hombres+v1.total_mujeres),0)) jun,
                sum(IF(month(v3.fechaActualizacion)= 7,IF((v1.total_hombres+v1.total_mujeres)=0,v1.total_estudiantes,v1.total_hombres+v1.total_mujeres),0)) -
                sum(IF(month(v3.fechaActualizacion)= 6,IF((v1.total_hombres+v1.total_mujeres)=0,v1.total_estudiantes,v1.total_hombres+v1.total_mujeres),0)) jul,
                sum(IF(month(v3.fechaActualizacion)= 8,IF((v1.total_hombres+v1.total_mujeres)=0,v1.total_estudiantes,v1.total_hombres+v1.total_mujeres),0)) -
                sum(IF(month(v3.fechaActualizacion)= 7,IF((v1.total_hombres+v1.total_mujeres)=0,v1.total_estudiantes,v1.total_hombres+v1.total_mujeres),0)) ago,
                sum(IF(month(v3.fechaActualizacion)= 9,IF((v1.total_hombres+v1.total_mujeres)=0,v1.total_estudiantes,v1.total_hombres+v1.total_mujeres),0)) -
                sum(IF(month(v3.fechaActualizacion)= 8,IF((v1.total_hombres+v1.total_mujeres)=0,v1.total_estudiantes,v1.total_hombres+v1.total_mujeres),0)) `set`,
                sum(IF(month(v3.fechaActualizacion)=10,IF((v1.total_hombres+v1.total_mujeres)=0,v1.total_estudiantes,v1.total_hombres+v1.total_mujeres),0)) -
                sum(IF(month(v3.fechaActualizacion)= 9,IF((v1.total_hombres+v1.total_mujeres)=0,v1.total_estudiantes,v1.total_hombres+v1.total_mujeres),0)) oct,
                sum(IF(month(v3.fechaActualizacion)=11,IF((v1.total_hombres+v1.total_mujeres)=0,v1.total_estudiantes,v1.total_hombres+v1.total_mujeres),0)) -
                sum(IF(month(v3.fechaActualizacion)=10,IF((v1.total_hombres+v1.total_mujeres)=0,v1.total_estudiantes,v1.total_hombres+v1.total_mujeres),0)) nov,
                sum(IF(month(v3.fechaActualizacion)=12,IF((v1.total_hombres+v1.total_mujeres)=0,v1.total_estudiantes,v1.total_hombres+v1.total_mujeres),0)) -
                sum(IF(month(v3.fechaActualizacion)=11,IF((v1.total_hombres+v1.total_mujeres)=0,v1.total_estudiantes,v1.total_hombres+v1.total_mujeres),0)) dic,
                sum(IF((v1.total_hombres+v1.total_mujeres)=0,v1.total_estudiantes,v1.total_hombres+v1.total_mujeres)) total
            from edu_matricula_detalle as v1
            inner join edu_matricula as v2 on v2.id=v1.matricula_id
            inner join par_importacion as v3 on v3.id=v2.importacion_id
            inner join edu_institucioneducativa as v4 on v4.id=v1.institucioneducativa_id
            inner join edu_nivelmodalidad as v5 on v5.id=v4.NivelModalidad_id
            inner join edu_ugel as v6 on v6.id=v4.Ugel_id
            inner join edu_tipogestion as v7 on v7.id=v4.TipoGestion_id
            inner join edu_tipogestion as v8 on v8.id=v7.dependencia
            inner join edu_area as v9 on v9.id=v4.Area_id
            where v3.estado='PR' and v5.tipo in ('EBR','EBE') and v2.anio_id=$ano and v3.fechaActualizacion in ($fx) $opttipo $optnivel
            group by id,ugel
            order by ugel asc
            ) as xx"))->get();

        $foot = ['meta' => 0, 'ene' => 0, 'feb' => 0, 'mar' => 0, 'abr' => 0, 'may' => 0, 'jun' => 0, 'jul' => 0, 'ago' => 0, 'set' => 0, 'oct' => 0, 'nov' => 0, 'dic' => 0, 'total' => 0, 'avance' => 0,];

        foreach ($base as $reg => $bb) {
            $bb->treg = ($anoF != 1 ? $bb->ene : 0) + ($anoF != 2 ? $bb->feb : 0) + ($anoF != 3 ? $bb->mar : 0) + ($anoF != 4 ? $bb->abr : 0) +  ($anoF != 5 ? $bb->may : 0) +  ($anoF != 6 ? $bb->jun : 0) +  ($anoF != 7 ? $bb->jul : 0) +  ($anoF != 8 ? $bb->ago : 0) + ($anoF != 9 ? $bb->set : 0) + ($anoF != 10 ? $bb->oct : 0) +  ($anoF != 11 ? $bb->nov : 0) + ($anoF != 12 ? $bb->dic : 0);

            foreach ($baseA as $key2 => $bA) {
                if ($bA->ugel == $bb->ugel)
                    $bb->tregA = $bA->dic;
            }
            $bb->avance = $bb->tregA > 0 ? $bb->treg / $bb->tregA : 1;

            $foot['meta'] += $bb->tregA;
            $foot['ene'] += $bb->ene;
            $foot['feb'] += $bb->feb;
            $foot['mar'] += $bb->mar;
            $foot['abr'] += $bb->abr;
            $foot['may'] += $bb->may;
            $foot['jun'] += $bb->jun;
            $foot['jul'] += $bb->jul;
            $foot['ago'] += $bb->ago;
            $foot['set'] += $bb->set;
            $foot['oct'] += $bb->oct;
            $foot['nov'] += $bb->nov;
            $foot['dic'] += $bb->dic;
            $foot['total'] += $bb->treg;
        }
        $foot['avance'] = $foot['meta'] > 0 ? $foot['total'] / $foot['meta'] : 1;
        $error['base'] = $base;



        //return $error;
        return view("educacion.MatriculaDetalle.MatriculaAvancetabla0", compact('rq', 'base', 'anoI', 'anoF', 'foot'));
    }
}
