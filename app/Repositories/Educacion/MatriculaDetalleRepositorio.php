<?php

namespace App\Repositories\Educacion;

use App\Models\Educacion\Matricula;
use App\Models\Educacion\MatriculaAnual;
use Illuminate\Support\Facades\DB;

class MatriculaDetalleRepositorio
{
    public static function count_matriculados($matricula)
    {
        $query = DB::table('edu_matricula_detalle as v1')
            ->where('v1.matricula_id', $matricula)
            ->select(DB::raw('SUM(v1.total_estudiantes) as conteo'))
            ->first();
        return $query->conteo;
    }
    public static function estudiantes_matriculadosEBR_EBE_anual()
    {
        $query = DB::table(DB::raw(
            "(select year(v3.fechaActualizacion) as anio,month(v3.fechaActualizacion) as mes,sum(v1.total_estudiantes) as conteo from edu_matricula_detalle as v1 
        inner join edu_matricula as v2 on v2.id=v1.matricula_id
        inner join par_importacion as v3 on v3.id=v2.importacion_id
        inner join edu_institucioneducativa as v4 on v4.id=v1.institucioneducativa_id
        inner join edu_nivelmodalidad as v5 on v5.id=v4.NivelModalidad_id 
        where v3.estado='PR' and v5.tipo in ('EBR','EBE') 
        group by anio,mes
        order by anio,mes desc) as tb"
        ))
            ->select('anio as name', 'conteo as y', 'mes')
            ->get();
        $gra = [];
        $vista = '[';
        foreach ($query as $key => $value) {
            $value->name = strval($value->name);
            if ($key == 0) {
                $gra[] = ['name' => $value->name, 'y' => (int)$value->y];
                $vista .= "{'name':$value->name, 'y':$value->y},";
            } else {
                $grabar = true;
                foreach ($gra as $value2) {
                    if ($value->name == $value2['name']) {
                        $grabar = false;
                    }
                }
                if ($grabar) {
                    $gra[] = ['name' => $value->name, 'y' => (int) $value->y];
                    $vista .= "{'name':$value->name, 'y':$value->y},";
                }
            }
        }
        $vista .= ']';


        return $vista;
    }

    public static function estudiantes_matriculados_segungenero()
    {
        $query = DB::table(DB::raw(
            "(select 
            year(v3.fechaActualizacion) as anio,
            month(v3.fechaActualizacion) as mes,
            day(v3.fechaActualizacion) as dia,
            sum(v1.tres_anios_mujer+v1.cuatro_anios_mujer+v1.cinco_anios_mujer+
                v1.primero_mujer+v1.segundo_mujer+v1.tercero_mujer+v1.cuarto_mujer+v1.cinco_anios_mujer+v1.sexto_mujer+
                v1.cero_anios_mujer+v1.un_anio_mujer+v1.dos_anios_mujer+v1.mas_cinco_anios_mujer) as mujeres,
            sum(v1.tres_anios_hombre+v1.cuatro_anios_hombre+v1.cinco_anios_hombre+
                v1.primero_hombre+v1.segundo_hombre+v1.tercero_hombre+v1.cuarto_hombre+v1.cinco_anios_hombre+v1.sexto_hombre+
                v1.cero_anios_hombre+v1.un_anio_hombre+v1.dos_anios_hombre+v1.mas_cinco_anios_hombre) as varones
        from edu_matricula_detalle v1 
        inner join edu_matricula as v2 on v2.id=v1.matricula_id
        inner join par_importacion as v3 on v3.id=v2.importacion_id 
        where v3.estado='PR' 
        group by anio,mes,dia 
        order by anio desc,mes desc,dia desc) as tb"
        ))
            ->get()->first();
        $vista = "[{'name':'MASCULINO','y':$query->varones},";
        $vista .= "{'name':'FEMENINO','y':$query->mujeres}]";
        return ['pts' => $vista, 'anio' => $query->anio];
    }

    public static function estudiantes_matriculados_seguntipogestion()
    {
        $query = DB::table(DB::raw(
            "(select
            year(v3.fechaActualizacion) as anio,
            month(v3.fechaActualizacion) as mes,
            day(v3.fechaActualizacion) as dia,
            sum(IF(v6.id!=3,v1.tres_anios_mujer+v1.cuatro_anios_mujer+v1.cinco_anios_mujer+
                v1.primero_mujer+v1.segundo_mujer+v1.tercero_mujer+v1.cuarto_mujer+v1.cinco_anios_mujer+v1.sexto_mujer+
                v1.cero_anios_mujer+v1.un_anio_mujer+v1.dos_anios_mujer+v1.mas_cinco_anios_mujer+
                v1.tres_anios_hombre+v1.cuatro_anios_hombre+v1.cinco_anios_hombre+
                v1.primero_hombre+v1.segundo_hombre+v1.tercero_hombre+v1.cuarto_hombre+v1.cinco_anios_hombre+v1.sexto_hombre+
                v1.cero_anios_hombre+v1.un_anio_hombre+v1.dos_anios_hombre+v1.mas_cinco_anios_hombre,0)) as publico,
            sum(IF(v6.id=3,v1.tres_anios_mujer+v1.cuatro_anios_mujer+v1.cinco_anios_mujer+
                v1.primero_mujer+v1.segundo_mujer+v1.tercero_mujer+v1.cuarto_mujer+v1.cinco_anios_mujer+v1.sexto_mujer+
                v1.cero_anios_mujer+v1.un_anio_mujer+v1.dos_anios_mujer+v1.mas_cinco_anios_mujer+
                v1.tres_anios_hombre+v1.cuatro_anios_hombre+v1.cinco_anios_hombre+
                v1.primero_hombre+v1.segundo_hombre+v1.tercero_hombre+v1.cuarto_hombre+v1.cinco_anios_hombre+v1.sexto_hombre+
                v1.cero_anios_hombre+v1.un_anio_hombre+v1.dos_anios_hombre+v1.mas_cinco_anios_hombre,0)) as privado		
        from edu_matricula_detalle v1 
        inner join edu_matricula as v2 on v2.id=v1.matricula_id
        inner join par_importacion as v3 on v3.id=v2.importacion_id 
        inner join edu_institucioneducativa as v4 on v4.id=v1.institucioneducativa_id 
        inner join edu_tipogestion as v5 on v5.id=v4.TipoGestion_id 
        inner join edu_tipogestion as v6 on v6.id=v5.dependencia 
        where v3.estado='PR' 
        group by anio,mes,dia
        order by anio desc,mes desc,dia desc  ) as tb"
        ))
            ->get()->first();
        $vista = "[{'name':'Publico','y':$query->publico},";
        $vista .= "{'name':'Privado','y':$query->privado}]";
        return ['pts' => $vista, 'anio' => $query->anio];
    }

    public static function estudiantes_matriculados_segunareageografica()
    {
        $query = DB::table('edu_matricula_detalle as v1')
            ->join('edu_matricula as v2', 'v2.id', '=', 'v1.matricula_id')
            ->join('par_importacion as v3', 'v3.id', '=', 'v2.importacion_id')
            ->join('edu_institucioneducativa as v4', 'v4.id', '=', 'v1.institucioneducativa_id')
            ->join('edu_area as v5', 'v5.id', '=', 'v4.Area_id')
            ->select(
                DB::raw('year(v3.fechaActualizacion) as anio'),
                DB::raw('month(v3.fechaActualizacion) as mes'),
                DB::raw('day(v3.fechaActualizacion) as dia'),
                DB::raw('sum(IF(v5.id=1,v1.tres_anios_mujer+v1.cuatro_anios_mujer+v1.cinco_anios_mujer+
                v1.primero_mujer+v1.segundo_mujer+v1.tercero_mujer+v1.cuarto_mujer+v1.cinco_anios_mujer+v1.sexto_mujer+
                v1.cero_anios_mujer+v1.un_anio_mujer+v1.dos_anios_mujer+v1.mas_cinco_anios_mujer+
                v1.tres_anios_hombre+v1.cuatro_anios_hombre+v1.cinco_anios_hombre+
                v1.primero_hombre+v1.segundo_hombre+v1.tercero_hombre+v1.cuarto_hombre+v1.cinco_anios_hombre+v1.sexto_hombre+
                v1.cero_anios_hombre+v1.un_anio_hombre+v1.dos_anios_hombre+v1.mas_cinco_anios_hombre,0)) as rural'),
                DB::raw('sum(IF(v5.id=2,v1.tres_anios_mujer+v1.cuatro_anios_mujer+v1.cinco_anios_mujer+
                v1.primero_mujer+v1.segundo_mujer+v1.tercero_mujer+v1.cuarto_mujer+v1.cinco_anios_mujer+v1.sexto_mujer+
                v1.cero_anios_mujer+v1.un_anio_mujer+v1.dos_anios_mujer+v1.mas_cinco_anios_mujer+
                v1.tres_anios_hombre+v1.cuatro_anios_hombre+v1.cinco_anios_hombre+
                v1.primero_hombre+v1.segundo_hombre+v1.tercero_hombre+v1.cuarto_hombre+v1.cinco_anios_hombre+v1.sexto_hombre+
                v1.cero_anios_hombre+v1.un_anio_hombre+v1.dos_anios_hombre+v1.mas_cinco_anios_hombre,0)) as urbana')
            )
            ->where('v3.estado', 'PR')
            ->groupBy('anio', 'mes', 'dia')
            ->orderBy('anio', 'desc')->orderBy('mes', 'desc')->orderBy('dia', 'desc')
            ->get()->first();

        $vista = "[{'name':'Rural', 'y':$query->rural},";
        $vista .= "{'name':'Urbana', 'y':$query->urbana}]";
        return ['pts' => $vista, 'anio' => $query->anio];
    }

    public static function estudiantes_matriculados_segunaugel()
    {
        $fechaMax = DB::table('edu_matricula_detalle as v1')
            ->join('edu_matricula as v2', 'v2.id', '=', 'v1.matricula_id')
            ->join('par_importacion as v3', 'v3.id', '=', 'v2.importacion_id')
            ->join('edu_institucioneducativa as v4', 'v4.id', '=', 'v1.institucioneducativa_id')
            ->join('edu_ugel as v5', 'v5.id', '=', 'v4.Ugel_id')
            ->select(DB::raw('max(v3.fechaActualizacion) as fecha'))
            ->where('v3.estado', 'PR')
            ->get()->first()->fecha;
        if ($fechaMax) {
            $query = DB::table('edu_matricula_detalle as v1')
                ->join('edu_matricula as v2', 'v2.id', '=', 'v1.matricula_id')
                ->join('par_importacion as v3', 'v3.id', '=', 'v2.importacion_id')
                ->join('edu_institucioneducativa as v4', 'v4.id', '=', 'v1.institucioneducativa_id')
                ->join('edu_ugel as v5', 'v5.id', '=', 'v4.Ugel_id')
                ->select(
                    DB::raw('v5.nombre as ugel'),
                    DB::raw('sum(v1.tres_anios_mujer+v1.cuatro_anios_mujer+v1.cinco_anios_mujer+
                v1.primero_mujer+v1.segundo_mujer+v1.tercero_mujer+v1.cuarto_mujer+v1.cinco_anios_mujer+v1.sexto_mujer+
                v1.cero_anios_mujer+v1.un_anio_mujer+v1.dos_anios_mujer+v1.mas_cinco_anios_mujer+
                v1.tres_anios_hombre+v1.cuatro_anios_hombre+v1.cinco_anios_hombre+
                v1.primero_hombre+v1.segundo_hombre+v1.tercero_hombre+v1.cuarto_hombre+v1.cinco_anios_hombre+v1.sexto_hombre+
                v1.cero_anios_hombre+v1.un_anio_hombre+v1.dos_anios_hombre+v1.mas_cinco_anios_hombre) as conteo')
                )
                ->where('v3.estado', 'PR')
                ->where('v3.fechaActualizacion', $fechaMax)
                ->groupBy('ugel')
                ->orderBy('conteo', 'desc')
                ->get();

            $vista = "[";
            foreach ($query as $key => $val) {
                $vista .= "{'name':'$val->ugel', 'y':$val->conteo},";
            }
            $vista .= "]";
            $data['pts'] = $vista;
            $data['anio'] = date('Y', strtotime($fechaMax));
            return $data;
        }
        return [];
    }

    public static function listar_estudiantesNivelProvinciaDistrito()
    {
        $fechaMax = DB::table('edu_matricula_detalle as v1')
            ->join('edu_matricula as v2', 'v2.id', '=', 'v1.matricula_id')
            ->join('par_importacion as v3', 'v3.id', '=', 'v2.importacion_id')
            ->select(DB::raw('max(v3.fechaActualizacion) as fecha'))
            ->where('v3.estado', 'PR')
            ->get()->first()->fecha;
        if ($fechaMax) {
            $foot = DB::table('edu_matricula_detalle as v1')
                ->join('edu_matricula as v2', 'v2.id', '=', 'v1.matricula_id')
                ->join('par_importacion as v3', 'v3.id', '=', 'v2.importacion_id')
                ->join('edu_institucioneducativa as v4', 'v4.id', '=', 'v1.institucioneducativa_id')
                ->join('edu_nivelmodalidad as v5', 'v5.id', '=', 'v4.NivelModalidad_id')
                ->join('par_centropoblado as v6', 'v6.id', '=', 'v4.CentroPoblado_id')
                ->join('par_ubigeo as v7', 'v7.id', '=', 'v6.Ubigeo_id')
                ->join('par_ubigeo as v8', 'v8.id', '=', 'v7.dependencia')
                ->select(
                    DB::raw('sum(if(v5.id in (10,11,13),
                    v1.tres_anios_hombre+v1.cuatro_anios_hombre+v1.cinco_anios_hombre+
                    v1.primero_hombre+v1.segundo_hombre+v1.tercero_hombre+v1.cuarto_hombre+v1.cinco_anios_hombre+v1.sexto_hombre+
                    v1.cero_anios_hombre+v1.un_anio_hombre+v1.dos_anios_hombre+v1.mas_cinco_anios_hombre,0)) as hebe'),
                    DB::raw('sum(if(v5.id in (10,11,13),
                    v1.tres_anios_mujer+v1.cuatro_anios_mujer+v1.cinco_anios_mujer+
                    v1.primero_mujer+v1.segundo_mujer+v1.tercero_mujer+v1.cuarto_mujer+v1.cinco_anios_mujer+v1.sexto_mujer+
                    v1.cero_anios_mujer+v1.un_anio_mujer+v1.dos_anios_mujer+v1.mas_cinco_anios_mujer,0)) as mebe'),
                    DB::raw('sum(if(v5.id in (1,2,14),
                    v1.tres_anios_hombre+v1.cuatro_anios_hombre+v1.cinco_anios_hombre+
                    v1.primero_hombre+v1.segundo_hombre+v1.tercero_hombre+v1.cuarto_hombre+v1.cinco_anios_hombre+v1.sexto_hombre+
                    v1.cero_anios_hombre+v1.un_anio_hombre+v1.dos_anios_hombre+v1.mas_cinco_anios_hombre,0)) as hini'),
                    DB::raw('sum(if(v5.id in (1,2,14),
                    v1.tres_anios_mujer+v1.cuatro_anios_mujer+v1.cinco_anios_mujer+
                    v1.primero_mujer+v1.segundo_mujer+v1.tercero_mujer+v1.cuarto_mujer+v1.cinco_anios_mujer+v1.sexto_mujer+
                    v1.cero_anios_mujer+v1.un_anio_mujer+v1.dos_anios_mujer+v1.mas_cinco_anios_mujer,0)) as mini'),
                    DB::raw('sum(if(v5.id in (7),
                    v1.tres_anios_hombre+v1.cuatro_anios_hombre+v1.cinco_anios_hombre+
                    v1.primero_hombre+v1.segundo_hombre+v1.tercero_hombre+v1.cuarto_hombre+v1.cinco_anios_hombre+v1.sexto_hombre+
                    v1.cero_anios_hombre+v1.un_anio_hombre+v1.dos_anios_hombre+v1.mas_cinco_anios_hombre,0)) as hpri'),
                    DB::raw('sum(if(v5.id in (7),
                    v1.tres_anios_mujer+v1.cuatro_anios_mujer+v1.cinco_anios_mujer+
                    v1.primero_mujer+v1.segundo_mujer+v1.tercero_mujer+v1.cuarto_mujer+v1.cinco_anios_mujer+v1.sexto_mujer+
                    v1.cero_anios_mujer+v1.un_anio_mujer+v1.dos_anios_mujer+v1.mas_cinco_anios_mujer,0)) as mpri'),
                    DB::raw('sum(if(v5.id in (8),
                    v1.tres_anios_hombre+v1.cuatro_anios_hombre+v1.cinco_anios_hombre+
                    v1.primero_hombre+v1.segundo_hombre+v1.tercero_hombre+v1.cuarto_hombre+v1.cinco_anios_hombre+v1.sexto_hombre+
                    v1.cero_anios_hombre+v1.un_anio_hombre+v1.dos_anios_hombre+v1.mas_cinco_anios_hombre,0)) as hsec'),
                    DB::raw('sum(if(v5.id in (8),
                    v1.tres_anios_mujer+v1.cuatro_anios_mujer+v1.cinco_anios_mujer+
                    v1.primero_mujer+v1.segundo_mujer+v1.tercero_mujer+v1.cuarto_mujer+v1.cinco_anios_mujer+v1.sexto_mujer+
                    v1.cero_anios_mujer+v1.un_anio_mujer+v1.dos_anios_mujer+v1.mas_cinco_anios_mujer,0)) as msec')
                )
                ->where('v3.estado', 'PR')->where('v3.fechaActualizacion', $fechaMax)
                ->get()->first();
            $body = DB::table('edu_matricula_detalle as v1')
                ->join('edu_matricula as v2', 'v2.id', '=', 'v1.matricula_id')
                ->join('par_importacion as v3', 'v3.id', '=', 'v2.importacion_id')
                ->join('edu_institucioneducativa as v4', 'v4.id', '=', 'v1.institucioneducativa_id')
                ->join('edu_nivelmodalidad as v5', 'v5.id', '=', 'v4.NivelModalidad_id')
                ->join('par_centropoblado as v6', 'v6.id', '=', 'v4.CentroPoblado_id')
                ->join('par_ubigeo as v7', 'v7.id', '=', 'v6.Ubigeo_id')
                ->join('par_ubigeo as v8', 'v8.id', '=', 'v7.dependencia')
                ->select(
                    DB::raw('v8.nombre as provincia'),
                    DB::raw('v7.nombre as distrito'),
                    DB::raw('sum(if(v5.id in (10,11,13),
                    v1.tres_anios_hombre+v1.cuatro_anios_hombre+v1.cinco_anios_hombre+
                    v1.primero_hombre+v1.segundo_hombre+v1.tercero_hombre+v1.cuarto_hombre+v1.cinco_anios_hombre+v1.sexto_hombre+
                    v1.cero_anios_hombre+v1.un_anio_hombre+v1.dos_anios_hombre+v1.mas_cinco_anios_hombre,0)) as hebe'),
                    DB::raw('sum(if(v5.id in (10,11,13),
                    v1.tres_anios_mujer+v1.cuatro_anios_mujer+v1.cinco_anios_mujer+
                    v1.primero_mujer+v1.segundo_mujer+v1.tercero_mujer+v1.cuarto_mujer+v1.cinco_anios_mujer+v1.sexto_mujer+
                    v1.cero_anios_mujer+v1.un_anio_mujer+v1.dos_anios_mujer+v1.mas_cinco_anios_mujer,0)) as mebe'),
                    DB::raw('sum(if(v5.id in (1,2,14),
                    v1.tres_anios_hombre+v1.cuatro_anios_hombre+v1.cinco_anios_hombre+
                    v1.primero_hombre+v1.segundo_hombre+v1.tercero_hombre+v1.cuarto_hombre+v1.cinco_anios_hombre+v1.sexto_hombre+
                    v1.cero_anios_hombre+v1.un_anio_hombre+v1.dos_anios_hombre+v1.mas_cinco_anios_hombre,0)) as hini'),
                    DB::raw('sum(if(v5.id in (1,2,14),
                    v1.tres_anios_mujer+v1.cuatro_anios_mujer+v1.cinco_anios_mujer+
                    v1.primero_mujer+v1.segundo_mujer+v1.tercero_mujer+v1.cuarto_mujer+v1.cinco_anios_mujer+v1.sexto_mujer+
                    v1.cero_anios_mujer+v1.un_anio_mujer+v1.dos_anios_mujer+v1.mas_cinco_anios_mujer,0)) as mini'),
                    DB::raw('sum(if(v5.id in (7),
                    v1.tres_anios_hombre+v1.cuatro_anios_hombre+v1.cinco_anios_hombre+
                    v1.primero_hombre+v1.segundo_hombre+v1.tercero_hombre+v1.cuarto_hombre+v1.cinco_anios_hombre+v1.sexto_hombre+
                    v1.cero_anios_hombre+v1.un_anio_hombre+v1.dos_anios_hombre+v1.mas_cinco_anios_hombre,0)) as hpri'),
                    DB::raw('sum(if(v5.id in (7),
                    v1.tres_anios_mujer+v1.cuatro_anios_mujer+v1.cinco_anios_mujer+
                    v1.primero_mujer+v1.segundo_mujer+v1.tercero_mujer+v1.cuarto_mujer+v1.cinco_anios_mujer+v1.sexto_mujer+
                    v1.cero_anios_mujer+v1.un_anio_mujer+v1.dos_anios_mujer+v1.mas_cinco_anios_mujer,0)) as mpri'),
                    DB::raw('sum(if(v5.id in (8),
                    v1.tres_anios_hombre+v1.cuatro_anios_hombre+v1.cinco_anios_hombre+
                    v1.primero_hombre+v1.segundo_hombre+v1.tercero_hombre+v1.cuarto_hombre+v1.cinco_anios_hombre+v1.sexto_hombre+
                    v1.cero_anios_hombre+v1.un_anio_hombre+v1.dos_anios_hombre+v1.mas_cinco_anios_hombre,0)) as hsec'),
                    DB::raw('sum(if(v5.id in (8),
                    v1.tres_anios_mujer+v1.cuatro_anios_mujer+v1.cinco_anios_mujer+
                    v1.primero_mujer+v1.segundo_mujer+v1.tercero_mujer+v1.cuarto_mujer+v1.cinco_anios_mujer+v1.sexto_mujer+
                    v1.cero_anios_mujer+v1.un_anio_mujer+v1.dos_anios_mujer+v1.mas_cinco_anios_mujer,0)) as msec'),
                    DB::raw('sum(
                        v1.tres_anios_hombre+v1.cuatro_anios_hombre+v1.cinco_anios_hombre+
                        v1.primero_hombre+v1.segundo_hombre+v1.tercero_hombre+v1.cuarto_hombre+v1.cinco_anios_hombre+v1.sexto_hombre+
                        v1.cero_anios_hombre+v1.un_anio_hombre+v1.dos_anios_hombre+v1.mas_cinco_anios_hombre) as htot'),
                        DB::raw('sum(
                        v1.tres_anios_mujer+v1.cuatro_anios_mujer+v1.cinco_anios_mujer+
                        v1.primero_mujer+v1.segundo_mujer+v1.tercero_mujer+v1.cuarto_mujer+v1.cinco_anios_mujer+v1.sexto_mujer+
                        v1.cero_anios_mujer+v1.un_anio_mujer+v1.dos_anios_mujer+v1.mas_cinco_anios_mujer) as mtot')
                )
                ->where('v3.estado', 'PR')->where('v3.fechaActualizacion', $fechaMax)
                ->groupBy('provincia', 'distrito')
                ->orderBy('provincia', 'asc')->orderBy('distrito', 'asc')
                ->get();
            $head = DB::table('edu_matricula_detalle as v1')
                ->join('edu_matricula as v2', 'v2.id', '=', 'v1.matricula_id')
                ->join('par_importacion as v3', 'v3.id', '=', 'v2.importacion_id')
                ->join('edu_institucioneducativa as v4', 'v4.id', '=', 'v1.institucioneducativa_id')
                ->join('edu_nivelmodalidad as v5', 'v5.id', '=', 'v4.NivelModalidad_id')
                ->join('par_centropoblado as v6', 'v6.id', '=', 'v4.CentroPoblado_id')
                ->join('par_ubigeo as v7', 'v7.id', '=', 'v6.Ubigeo_id')
                ->join('par_ubigeo as v8', 'v8.id', '=', 'v7.dependencia')
                ->select(
                    DB::raw('v8.nombre as provincia'),
                    DB::raw('sum(if(v5.id in (10,11,13),
                    v1.tres_anios_hombre+v1.cuatro_anios_hombre+v1.cinco_anios_hombre+
                    v1.primero_hombre+v1.segundo_hombre+v1.tercero_hombre+v1.cuarto_hombre+v1.cinco_anios_hombre+v1.sexto_hombre+
                    v1.cero_anios_hombre+v1.un_anio_hombre+v1.dos_anios_hombre+v1.mas_cinco_anios_hombre,0)) as hebe'),
                    DB::raw('sum(if(v5.id in (10,11,13),
                    v1.tres_anios_mujer+v1.cuatro_anios_mujer+v1.cinco_anios_mujer+
                    v1.primero_mujer+v1.segundo_mujer+v1.tercero_mujer+v1.cuarto_mujer+v1.cinco_anios_mujer+v1.sexto_mujer+
                    v1.cero_anios_mujer+v1.un_anio_mujer+v1.dos_anios_mujer+v1.mas_cinco_anios_mujer,0)) as mebe'),
                    DB::raw('sum(if(v5.id in (1,2,14),
                    v1.tres_anios_hombre+v1.cuatro_anios_hombre+v1.cinco_anios_hombre+
                    v1.primero_hombre+v1.segundo_hombre+v1.tercero_hombre+v1.cuarto_hombre+v1.cinco_anios_hombre+v1.sexto_hombre+
                    v1.cero_anios_hombre+v1.un_anio_hombre+v1.dos_anios_hombre+v1.mas_cinco_anios_hombre,0)) as hini'),
                    DB::raw('sum(if(v5.id in (1,2,14),
                    v1.tres_anios_mujer+v1.cuatro_anios_mujer+v1.cinco_anios_mujer+
                    v1.primero_mujer+v1.segundo_mujer+v1.tercero_mujer+v1.cuarto_mujer+v1.cinco_anios_mujer+v1.sexto_mujer+
                    v1.cero_anios_mujer+v1.un_anio_mujer+v1.dos_anios_mujer+v1.mas_cinco_anios_mujer,0)) as mini'),
                    DB::raw('sum(if(v5.id in (7),
                    v1.tres_anios_hombre+v1.cuatro_anios_hombre+v1.cinco_anios_hombre+
                    v1.primero_hombre+v1.segundo_hombre+v1.tercero_hombre+v1.cuarto_hombre+v1.cinco_anios_hombre+v1.sexto_hombre+
                    v1.cero_anios_hombre+v1.un_anio_hombre+v1.dos_anios_hombre+v1.mas_cinco_anios_hombre,0)) as hpri'),
                    DB::raw('sum(if(v5.id in (7),
                    v1.tres_anios_mujer+v1.cuatro_anios_mujer+v1.cinco_anios_mujer+
                    v1.primero_mujer+v1.segundo_mujer+v1.tercero_mujer+v1.cuarto_mujer+v1.cinco_anios_mujer+v1.sexto_mujer+
                    v1.cero_anios_mujer+v1.un_anio_mujer+v1.dos_anios_mujer+v1.mas_cinco_anios_mujer,0)) as mpri'),
                    DB::raw('sum(if(v5.id in (8),
                    v1.tres_anios_hombre+v1.cuatro_anios_hombre+v1.cinco_anios_hombre+
                    v1.primero_hombre+v1.segundo_hombre+v1.tercero_hombre+v1.cuarto_hombre+v1.cinco_anios_hombre+v1.sexto_hombre+
                    v1.cero_anios_hombre+v1.un_anio_hombre+v1.dos_anios_hombre+v1.mas_cinco_anios_hombre,0)) as hsec'),
                    DB::raw('sum(if(v5.id in (8),
                    v1.tres_anios_mujer+v1.cuatro_anios_mujer+v1.cinco_anios_mujer+
                    v1.primero_mujer+v1.segundo_mujer+v1.tercero_mujer+v1.cuarto_mujer+v1.cinco_anios_mujer+v1.sexto_mujer+
                    v1.cero_anios_mujer+v1.un_anio_mujer+v1.dos_anios_mujer+v1.mas_cinco_anios_mujer,0)) as msec'),
                    DB::raw('sum(
                    v1.tres_anios_hombre+v1.cuatro_anios_hombre+v1.cinco_anios_hombre+
                    v1.primero_hombre+v1.segundo_hombre+v1.tercero_hombre+v1.cuarto_hombre+v1.cinco_anios_hombre+v1.sexto_hombre+
                    v1.cero_anios_hombre+v1.un_anio_hombre+v1.dos_anios_hombre+v1.mas_cinco_anios_hombre) as htot'),
                    DB::raw('sum(
                    v1.tres_anios_mujer+v1.cuatro_anios_mujer+v1.cinco_anios_mujer+
                    v1.primero_mujer+v1.segundo_mujer+v1.tercero_mujer+v1.cuarto_mujer+v1.cinco_anios_mujer+v1.sexto_mujer+
                    v1.cero_anios_mujer+v1.un_anio_mujer+v1.dos_anios_mujer+v1.mas_cinco_anios_mujer) as mtot')
                )
                ->where('v3.estado', 'PR')->where('v3.fechaActualizacion', $fechaMax)
                ->groupBy('provincia')
                ->orderBy('provincia', 'asc')
                ->get();


            return ['head' => $head, 'body' => $body, 'foot' => $foot];
        }
        return [];
    }
}
