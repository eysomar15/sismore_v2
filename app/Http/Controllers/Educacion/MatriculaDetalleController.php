<?php

namespace App\Http\Controllers\Educacion;

use App\Http\Controllers\Controller;
use App\Models\Educacion\Area;
use App\Models\Educacion\NivelModalidad;
use App\Models\Educacion\TipoGestion;
use App\Models\Educacion\Ugel;
use App\Models\Parametro\Anio;
use App\Repositories\Educacion\ImportacionRepositorio;
use App\Repositories\Educacion\MatriculaDetalleRepositorio;
use App\Repositories\Educacion\MatriculaRepositorio;
//use App\Repositories\Educacion\MatriculaDetalleRepositorio;
use Illuminate\Http\Request;

use Exception;
use Illuminate\Support\Facades\DB;
use PhpParser\Node\Expr\FuncCall;

class MatriculaDetalleController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function avance()
    {
        /* anos */
        $anios = MatriculaRepositorio::matriculas_anio();
        /* gestion */
        $gestions = [["id" => 2, "nombre" => "Pública"], ["id" => 3, "nombre" => "Privada"]];
        /* area geografica */
        $areas = Area::select('id', 'nombre')->get();
        return view("educacion.MatriculaDetalle.MatriculaAvance", compact('anios', 'gestions', 'areas'));
    }

    public function cargartabla0(Request $rq)
    {
        $ano = $rq->ano;
        $gestion = $rq->gestion;
        $area = $rq->area;

        $optgestion = $gestion == 0 ? "" : " and v8.id=$gestion ";
        $optarea = $area == 0 ? "" : " and v9.id=$area ";

        $error['ano'] = $ano;
        $error['gestion'] = $gestion;
        $error['area'] = $area;


        $anios = Anio::orderBy('anio', 'desc')->get();
        $anonro = 0;
        $anoA = 0;
        foreach ($anios as $key => $value) {
            if ($value->id == $ano) $anonro = $value->anio - 1;
            if ($value->anio == $anonro) $anoA = $value->id;
        }
        $error['anios'] = $anios;
        $error['anonro'] = $anonro;
        $error['anoA'] = $anoA;


        $fechas = DB::table(DB::raw("(
            select mes, max(fecha) fecha from (
                select 	
                    distinct
                    v3.fechaActualizacion fecha,
                    year(v3.fechaActualizacion) ano,
                    month(v3.fechaActualizacion) mes,
                    day(v3.fechaActualizacion) dia
                from edu_matricula_detalle as v1 
                inner join edu_matricula as v2 on v2.id=v1.matricula_id
                inner join par_importacion as v3 on v3.id=v2.importacion_id
                inner join par_anio as v4 on v4.id=v2.anio_id
                where v3.estado='PR' and v2.anio_id=$ano
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
        where v3.estado='PR' and v5.tipo in ('EBR','EBE') and v2.anio_id=$anoA and month(v3.fechaActualizacion)=12 $optgestion $optarea
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
            where v3.estado='PR' and v5.tipo in ('EBR','EBE') and v2.anio_id=$ano and v3.fechaActualizacion in ($fx) $optgestion $optarea
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

    public function cargartabla1(Request $rq)
    {
        $ano = $rq->ano;
        $gestion = $rq->gestion;
        $area = $rq->area;

        $optgestion = $gestion == 0 ? "" : " and v8.id=$gestion ";
        $optarea = $area == 0 ? "" : " and v9.id=$area ";

        $error['ano'] = $ano;
        $error['gestion'] = $gestion;
        $error['area'] = $area;


        $anios = Anio::orderBy('anio', 'desc')->get();
        $anonro = 0;
        $anoA = 0;
        foreach ($anios as $key => $value) {
            if ($value->id == $ano) $anonro = $value->anio - 1;
            if ($value->anio == $anonro) $anoA = $value->id;
        }
        $error['anios'] = $anios;
        $error['anonro'] = $anonro;
        $error['anoA'] = $anoA;


        $fechas = DB::table(DB::raw("(
            select mes, max(fecha) fecha from (
                select 	
                    distinct
                    v3.fechaActualizacion fecha,
                    year(v3.fechaActualizacion) ano,
                    month(v3.fechaActualizacion) mes,
                    day(v3.fechaActualizacion) dia
                from edu_matricula_detalle as v1 
                inner join edu_matricula as v2 on v2.id=v1.matricula_id
                inner join par_importacion as v3 on v3.id=v2.importacion_id
                inner join par_anio as v4 on v4.id=v2.anio_id
                where v3.estado='PR' and v2.anio_id=$ano
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

        $baseA = DB::table(DB::raw("(
        select
            v5.id, 
            v5.tipo,
            v5.nombre nivel,
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
        where v3.estado='PR' and v5.tipo in ('EBR','EBE') and v2.anio_id=$anoA and month(v3.fechaActualizacion)=12 $optgestion $optarea
        group by id,tipo,nivel        
            ) as xx"))->get();
        if (count($baseA) == 0) {
            $baseA = NivelModalidad::whereIn('tipo', ['EBR', 'EBE'])->select('id', 'tipo', DB::raw('0 as dic'))->get();
        }
        $error['baseA'] = $baseA;


        $base = DB::table(DB::raw("(
            select
                v5.id, 
                v5.tipo, 
                v5.nombre nivel,
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
            where v3.estado='PR' and v5.tipo in ('EBR','EBE') and v2.anio_id=$ano and v3.fechaActualizacion in ($fx) $optgestion $optarea
            group by id,tipo,nivel
            ) as xx"))->get();



        $foot = ['meta' => 0, 'ene' => 0, 'feb' => 0, 'mar' => 0, 'abr' => 0, 'may' => 0, 'jun' => 0, 'jul' => 0, 'ago' => 0, 'set' => 0, 'oct' => 0, 'nov' => 0, 'dic' => 0, 'total' => 0, 'avance' => 0,];

        foreach ($base as $reg => $bb) {
            $bb->treg = ($anoF != 1 ? $bb->ene : 0) + ($anoF != 2 ? $bb->feb : 0) + ($anoF != 3 ? $bb->mar : 0) + ($anoF != 4 ? $bb->abr : 0) +  ($anoF != 5 ? $bb->may : 0) +  ($anoF != 6 ? $bb->jun : 0) +  ($anoF != 7 ? $bb->jul : 0) +  ($anoF != 8 ? $bb->ago : 0) + ($anoF != 9 ? $bb->set : 0) + ($anoF != 10 ? $bb->oct : 0) +  ($anoF != 11 ? $bb->nov : 0) + ($anoF != 12 ? $bb->dic : 0);

            foreach ($baseA as $key2 => $bA) {
                if ($bA->id == $bb->id)
                    $bb->tregA = $bA->dic;
                //else                    $bb->tregA = 0;
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

        $headA = DB::table(DB::raw("(
            select
                v5.tipo,
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
            where v3.estado='PR' and v5.tipo in ('EBR','EBE') and v2.anio_id=$anoA and month(v3.fechaActualizacion)=12 $optgestion $optarea
            group by tipo        
                ) as xx"))->get();
        if (count($headA) == 0) {
            $headA = NivelModalidad::whereIn('tipo', ['EBR', 'EBE'])->distinct()->select('tipo', DB::raw('0 as dic'))->get();
        }
        $error['headA'] = $headA;

        $head = DB::table(DB::raw("(
            select
                v5.tipo, 
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
            where v3.estado='PR' and v5.tipo in ('EBR','EBE') and v2.anio_id=$ano and v3.fechaActualizacion in ($fx) $optgestion $optarea
            group by tipo
            ) as xx"))->get();

        foreach ($head as $reg => $bb) {
            $bb->treg = ($anoF != 1 ? $bb->ene : 0) + ($anoF != 2 ? $bb->feb : 0) + ($anoF != 3 ? $bb->mar : 0) + ($anoF != 4 ? $bb->abr : 0) +  ($anoF != 5 ? $bb->may : 0) +  ($anoF != 6 ? $bb->jun : 0) +  ($anoF != 7 ? $bb->jul : 0) +  ($anoF != 8 ? $bb->ago : 0) + ($anoF != 9 ? $bb->set : 0) + ($anoF != 10 ? $bb->oct : 0) +  ($anoF != 11 ? $bb->nov : 0) + ($anoF != 12 ? $bb->dic : 0);
            foreach ($headA as $key2 => $bA) {

                if ($bA->tipo == $bb->tipo)
                    $bb->tregA = $bA->dic;
                //else 
            }
            $bb->avance = $bb->tregA > 0 ? $bb->treg / $bb->tregA : 1;
        }

        $error['head'] = $head;

        //return $error;
        return view("educacion.MatriculaDetalle.MatriculaAvancetabla1", compact('rq', 'head', 'base', 'anoI', 'anoF', 'foot'));
    }

    public function cargarpresupuestoxxx()
    {
        return view("educacion.MatriculaDetalle.presupuestoxxx");
    }
}
