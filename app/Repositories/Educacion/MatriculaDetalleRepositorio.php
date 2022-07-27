<?php

namespace App\Repositories\Educacion;

use App\Models\Educacion\Importacion;
use App\Models\Educacion\Matricula;
use App\Models\Educacion\MatriculaAnual;
use Illuminate\Support\Facades\DB;

class MatriculaDetalleRepositorio
{
    public static function count_matriculados($matricula)
    {
        $query = DB::table('edu_matricula_detalle as v1')
            ->where('v1.matricula_id', $matricula)
            ->select(DB::raw('SUM(IF((v1.total_hombres+v1.total_mujeres)=0,v1.total_estudiantes,v1.total_hombres+v1.total_mujeres)) as conteo'))
            ->first();
        return $query->conteo;
    }

    public static function estudiantes_matriculadosEBR_EBE_anual()
    {
        $impfechas = Importacion::select(
            DB::raw("year(fechaActualizacion) as ano"),
            DB::raw("max(fechaActualizacion) as fecha")
        )
            ->where('estado', 'PR')->where('fuenteImportacion_id', "8")
            ->groupBy('ano')
            ->get();
        $fechas = [];
        foreach ($impfechas as $key => $value) {
            $fechas[] = $value->fecha;
        }
        $impfechas = Importacion::select(
            DB::raw("year(fechaActualizacion) as ano"),
            'id',
            DB::raw("fechaActualizacion as fecha")
        )
            ->where('estado', 'PR')->where('fuenteImportacion_id', "8")->whereIn('fechaActualizacion', $fechas)
            ->orderBy('ano', 'asc')
            ->get();
        $ids = '';
        foreach ($impfechas as $key => $value) {
            if ($key < count($impfechas) - 1)
                $ids .= $value->id . ',';
            else $ids .= $value->id;
        }

        $query = DB::table(DB::raw(
            "(
            select 
                year(v3.fechaActualizacion) as anio,
                SUM(IF((v1.total_hombres+v1.total_mujeres)=0,v1.total_estudiantes,v1.total_hombres+v1.total_mujeres)) as conteo 
            from edu_matricula_detalle as v1 
            inner join edu_matricula as v2 on v2.id=v1.matricula_id
            inner join par_importacion as v3 on v3.id=v2.importacion_id
            inner join edu_institucioneducativa as v4 on v4.id=v1.institucioneducativa_id
            inner join edu_nivelmodalidad as v5 on v5.id=v4.NivelModalidad_id 
            where v3.estado='PR' and v5.tipo in ('EBR','EBE') and v3.id in ($ids) 
            group by anio
            order by anio asc
            ) as tb"
        ))
            ->select('anio as name', 'conteo as y')
            ->get();
        foreach ($query as $key => $value) {
            $value->y = (int)$value->y;
        }
        return $query;
    }

    public static function estudiantes_matriculados_segungenero()
    {
        $imp = Importacion::select('id', 'fechaActualizacion as fecha')->where('estado', 'PR')->where('fuenteImportacion_id', '8')->orderBy('fecha', 'desc')->take(1)->get();
        $id = $imp->first()->id;
        $query = DB::table('edu_matricula_detalle as v1')
            ->join('edu_matricula as v2', 'v2.id', '=', 'v1.matricula_id')
            ->join('par_importacion as v3', 'v3.id', '=', 'v2.importacion_id')
            ->join('edu_institucioneducativa as v4', 'v4.id', '=', 'v1.institucioneducativa_id')
            ->select(
                DB::raw('sum(v1.total_hombres) as hy'),
                DB::raw('sum(v1.total_mujeres) as my'),
                //DB::raw('sum(IF((v1.total_hombres+v1.total_mujeres)=0,v1.total_estudiantes,0)) as xy'),
                DB::raw('FORMAT(sum(v1.total_hombres),0) as hyx'),
                DB::raw('FORMAT(sum(v1.total_mujeres),0) as myx'),
                //DB::raw('FORMAT(sum(IF((v1.total_hombres+v1.total_mujeres)=0,v1.total_estudiantes,0)),0) as xyx'),
            )
            ->where('v3.estado', 'PR')->where('v3.id', $id)
            ->get();

        return [
            ["name" => "FEMENINO", "y" => (int)$query->first()->my, "yx" => $query->first()->myx],
            ["name" => "MASCULINO", "y" => (int)$query->first()->hy, "yx" => $query->first()->hyx],
            /* ["name" => "NO DEFINIDO", "y" => (int)$query->first()->xy, "yx" => $query->first()->xyx], */
        ];
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
        return [['name' => 'Pública', 'y' => (int)$query->publico], ['name' => 'Privado', 'y' => (int)$query->privado]];
        /* $vista = "[{'name':'Publico','y':$query->publico},";
        $vista .= "{'name':'Privado','y':$query->privado}]";
        return ['pts' => $vista, 'anio' => $query->anio]; */
    }

    public static function estudiantes_matriculados_segunareageografica()
    {
        $imp = Importacion::select('id', 'fechaActualizacion as fecha')->where('estado', 'PR')->where('fuenteImportacion_id', '8')->orderBy('fecha', 'desc')->take(1)->get();
        $id = $imp->first()->id;
        $query = DB::table('edu_matricula_detalle as v1')
            ->join('edu_matricula as v2', 'v2.id', '=', 'v1.matricula_id')
            ->join('par_importacion as v3', 'v3.id', '=', 'v2.importacion_id')
            ->join('edu_institucioneducativa as v4', 'v4.id', '=', 'v1.institucioneducativa_id')
            ->join('edu_area as v5', 'v5.id', '=', 'v4.Area_id')
            ->select(
                DB::raw('v5.nombre as name'),
                DB::raw('sum(IF((v1.total_hombres+v1.total_mujeres)=0,v1.total_estudiantes ,v1.total_hombres+v1.total_mujeres)) as y'),
                DB::raw('FORMAT(sum(IF((v1.total_hombres+v1.total_mujeres)=0,v1.total_estudiantes ,v1.total_hombres+v1.total_mujeres)),0) as yx'),
            )
            ->where('v3.estado', 'PR')->where('v3.id', $id)
            ->groupBy('name')
            ->get();
        foreach ($query as $key => $value) {
            $value->y = (int)$value->y;
        }
        return $query;
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

    public static function listar_estudiantesMatriculadosDeEducacionBasicaPorUgel()
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
                ->join('edu_ugel as v6', 'v6.id', '=', 'v4.Ugel_id')
                ->join('edu_tipogestion as v7', 'v7.id', '=', 'v4.TipoGestion_id')
                ->join('edu_tipogestion as v8', 'v8.id', '=', 'v7.dependencia')
                ->select(
                    DB::raw("SUM(IF(v5.tipo='EBE',IF(v8.nombre!='Privada',IF((v1.total_hombres+v1.total_mujeres)=0,v1.total_estudiantes,v1.total_hombres+v1.total_mujeres),0),0)) pu_e"),
                    DB::raw("SUM(IF(v5.tipo='EBE',IF(v8.nombre='Privada',IF((v1.total_hombres+v1.total_mujeres)=0,v1.total_estudiantes,v1.total_hombres+v1.total_mujeres),0),0)) pr_e"),
                    DB::raw("SUM(IF(v5.nombre='Secundaria',IF(v8.nombre!='Privada',IF((v1.total_hombres+v1.total_mujeres)=0,v1.total_estudiantes,v1.total_hombres+v1.total_mujeres),0),0)) pu_s"),
                    DB::raw("SUM(IF(v5.nombre='Secundaria',IF(v8.nombre='Privada',IF((v1.total_hombres+v1.total_mujeres)=0,v1.total_estudiantes,v1.total_hombres+v1.total_mujeres),0),0)) pr_s"),
                    DB::raw("SUM(IF(v5.nombre='Primaria',IF(v8.nombre!='Privada',IF((v1.total_hombres+v1.total_mujeres)=0,v1.total_estudiantes,v1.total_hombres+v1.total_mujeres),0),0)) pu_p"),
                    DB::raw("SUM(IF(v5.nombre='Primaria',IF(v8.nombre='Privada',IF((v1.total_hombres+v1.total_mujeres)=0,v1.total_estudiantes,v1.total_hombres+v1.total_mujeres),0),0)) pr_p"),
                    DB::raw("SUM(IF(v5.nombre like 'Inicial%' and v5.tipo='EBR',IF(v8.nombre!='Privada',IF((v1.total_hombres+v1.total_mujeres)=0,v1.total_estudiantes,v1.total_hombres+v1.total_mujeres),0),0)) pu_i"),
                    DB::raw("SUM(IF(v5.nombre like 'Inicial%' and v5.tipo='EBR',IF(v8.nombre='Privada',IF((v1.total_hombres+v1.total_mujeres)=0,v1.total_estudiantes,v1.total_hombres+v1.total_mujeres),0),0)) pr_i"),
                    DB::raw("SUM(IF(v8.nombre!='Privada',IF((v1.total_hombres+v1.total_mujeres)=0,v1.total_estudiantes,v1.total_hombres+v1.total_mujeres),0)) pu_t"),
                    DB::raw("SUM(IF(v8.nombre='Privada',IF((v1.total_hombres+v1.total_mujeres)=0,v1.total_estudiantes,v1.total_hombres+v1.total_mujeres),0)) pr_t"),
                )
                ->where('v3.estado', 'PR')->where('v3.fechaActualizacion', $fechaMax)->whereIn('v5.tipo', ['EBR', 'EBE'])
                ->get()->first();
            $body = DB::table('edu_matricula_detalle as v1')
                ->join('edu_matricula as v2', 'v2.id', '=', 'v1.matricula_id')
                ->join('par_importacion as v3', 'v3.id', '=', 'v2.importacion_id')
                ->join('edu_institucioneducativa as v4', 'v4.id', '=', 'v1.institucioneducativa_id')
                ->join('edu_nivelmodalidad as v5', 'v5.id', '=', 'v4.NivelModalidad_id')
                ->join('edu_ugel as v6', 'v6.id', '=', 'v4.Ugel_id')
                ->join('edu_tipogestion as v7', 'v7.id', '=', 'v4.TipoGestion_id')
                ->join('edu_tipogestion as v8', 'v8.id', '=', 'v7.dependencia')
                ->select(
                    DB::raw("v6.nombre ugel"),
                    DB::raw("SUM(IF(v5.tipo='EBE',IF(v8.nombre!='Privada',IF((v1.total_hombres+v1.total_mujeres)=0,v1.total_estudiantes,v1.total_hombres+v1.total_mujeres),0),0)) pu_e"),
                    DB::raw("SUM(IF(v5.tipo='EBE',IF(v8.nombre='Privada',IF((v1.total_hombres+v1.total_mujeres)=0,v1.total_estudiantes,v1.total_hombres+v1.total_mujeres),0),0)) pr_e"),
                    DB::raw("SUM(IF(v5.nombre='Secundaria',IF(v8.nombre!='Privada',IF((v1.total_hombres+v1.total_mujeres)=0,v1.total_estudiantes,v1.total_hombres+v1.total_mujeres),0),0)) pu_s"),
                    DB::raw("SUM(IF(v5.nombre='Secundaria',IF(v8.nombre='Privada',IF((v1.total_hombres+v1.total_mujeres)=0,v1.total_estudiantes,v1.total_hombres+v1.total_mujeres),0),0)) pr_s"),
                    DB::raw("SUM(IF(v5.nombre='Primaria',IF(v8.nombre!='Privada',IF((v1.total_hombres+v1.total_mujeres)=0,v1.total_estudiantes,v1.total_hombres+v1.total_mujeres),0),0)) pu_p"),
                    DB::raw("SUM(IF(v5.nombre='Primaria',IF(v8.nombre='Privada',IF((v1.total_hombres+v1.total_mujeres)=0,v1.total_estudiantes,v1.total_hombres+v1.total_mujeres),0),0)) pr_p"),
                    DB::raw("SUM(IF(v5.nombre like 'Inicial%' and v5.tipo='EBR',IF(v8.nombre!='Privada',IF((v1.total_hombres+v1.total_mujeres)=0,v1.total_estudiantes,v1.total_hombres+v1.total_mujeres),0),0)) pu_i"),
                    DB::raw("SUM(IF(v5.nombre like 'Inicial%' and v5.tipo='EBR',IF(v8.nombre='Privada',IF((v1.total_hombres+v1.total_mujeres)=0,v1.total_estudiantes,v1.total_hombres+v1.total_mujeres),0),0)) pr_i"),
                    DB::raw("SUM(IF(v8.nombre!='Privada',IF((v1.total_hombres+v1.total_mujeres)=0,v1.total_estudiantes,v1.total_hombres+v1.total_mujeres),0)) pu_t"),
                    DB::raw("SUM(IF(v8.nombre='Privada',IF((v1.total_hombres+v1.total_mujeres)=0,v1.total_estudiantes,v1.total_hombres+v1.total_mujeres),0)) pr_t"),
                )
                ->where('v3.estado', 'PR')->where('v3.fechaActualizacion', $fechaMax)->whereIn('v5.tipo', ['EBR', 'EBE'])
                ->groupBy('ugel')
                //->orderBy('provincia', 'asc')->orderBy('distrito', 'asc')
                ->get();

            return ['head' => [], 'body' => $body, 'foot' => $foot, 'fecha' => date('d/m/Y', strtotime($fechaMax))];
        }
        return [];
    }
}
