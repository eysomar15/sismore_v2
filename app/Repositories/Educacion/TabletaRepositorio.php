<?php

namespace App\Repositories\Educacion;

use App\Models\Educacion\Tableta;
use Illuminate\Support\Facades\DB;

class TabletaRepositorio
{

    public static function tableta_mas_actual()
    {
        $data = DB::table('par_importacion as imp')
            ->join('edu_tableta as tab', 'imp.id', '=', 'tab.importacion_id')
            ->join('par_anio as vanio', 'tab.anio_id', '=', 'vanio.id')
            ->where('imp.estado', '=', 'PR')
            ->orderBy('vanio.anio', 'desc')
            ->orderBy('imp.fechaActualizacion', 'desc')
            ->select('tab.id', 'imp.fechaActualizacion')
            ->limit(1)
            ->get();

        return $data;
    }

    public static function tableta_anio()
    {
        $data = DB::table('par_importacion as imp')
            ->join('edu_tableta as tab', 'imp.id', '=', 'tab.importacion_id')
            ->join('par_anio as vanio', 'tab.anio_id', '=', 'vanio.id')
            ->where('imp.estado', '=', 'PR')
            ->orderBy('vanio.anio', 'desc')
            ->select('vanio.id', 'vanio.anio')
            ->distinct()
            ->get();

        return $data;
    }

    public static function fechas_tabletas_anio($anio_id)
    {
        $data = DB::table('par_importacion as imp')
            ->join('edu_tableta as tab', 'imp.id', '=', 'tab.importacion_id')
            ->join('par_anio as vanio', 'tab.anio_id', '=', 'vanio.id')
            ->where('vanio.id', '=', $anio_id)
            ->where('imp.estado', '=', 'PR')
            ->orderBy('imp.fechaActualizacion', 'desc')
            ->select('tab.id as tableta_id', 'imp.fechaActualizacion', 'vanio.id', 'vanio.anio')
            ->get();

        return $data;
    }

    public static function datos_tableta($id)
    {
        $data = Tableta::select('imp.fechaactualizacion')
            ->join('par_importacion as imp', 'edu_tableta.importacion_id', '=', 'imp.id')
            ->where("edu_tableta.id", "=", $id)
            ->get();

        return $data;
    }

    public static function resumen_tabletas_ugel($tableta_id)
    {
        $data = DB::table('edu_tableta as tab')
            ->join('edu_tableta_detalle as tabDet', 'tab.id', '=', 'tabDet.tableta_id')
            ->join('edu_institucioneducativa as inst', 'tabDet.institucioneducativa_id', '=', 'inst.id')
            ->join('edu_ugel as ugel', 'inst.Ugel_id', '=', 'ugel.id')
            ->where('tab.id', '=', $tableta_id)
            ->orderBy('ugel.nombre', 'asc')
            ->groupBy('ugel.nombre')
            ->get([
                DB::raw('ugel.nombre as ugel'),
                DB::raw('sum(ifnull(aDistribuir_estudiantes,0) + ifnull(aDistribuir_docentes,0)) as total_aDistribuir'),
                DB::raw('sum(case when (aDistribuir_estudiantes + aDistribuir_docentes)> 0 then 1 else 0 end) as nroInstituciones_aDistribuir'),

                DB::raw('sum(ifnull(despachadas_estudiantes,0) + ifnull(despachadas_docentes,0)) as total_Despachado'),
                DB::raw('sum(case when (despachadas_estudiantes + despachadas_docentes)> 0 then 1 else 0 end) as nroInstituciones_Despachado'),

                DB::raw('sum(ifnull(recepcionadas_estudiantes,0) + ifnull(recepcionadas_docentes,0)) as total_Recepcionadas'),
                DB::raw('sum(case when (recepcionadas_estudiantes + recepcionadas_docentes)> 0 then 1 else 0 end) as nroInstituciones_Recepcionadas'),

                DB::raw('sum(ifnull(asignadas_estudiantes,0) + ifnull(asignadas_docentes,0)) as total_Asignadas'),
                DB::raw('sum(case when (asignadas_estudiantes + asignadas_docentes)> 0 then 1 else 0 end) as nroInstituciones_Asignadas'),
            ]);

        return $data;
    }

    public static function resumen_tabletas_anio($anio_id)
    {
        $data = DB::table('par_importacion as imp')
            ->join('edu_tableta as tab', 'imp.id', '=', 'tab.importacion_id')
            ->join('edu_tableta_detalle as tabDet', 'tab.id', '=', 'tabDet.tableta_id')
            ->join('edu_institucioneducativa as inst', 'tabDet.institucioneducativa_id', '=', 'inst.id')
            ->join('edu_ugel as ugel', 'inst.Ugel_id', '=', 'ugel.id')
            ->where('tab.anio_id', '=', $anio_id)
            ->where('imp.estado', '=', 'PR')
            ->orderBy('ugel.nombre', 'asc')
            ->groupBy('fechaActualizacion')

            ->get([
                DB::raw('fechaActualizacion'),

                DB::raw('sum(ifnull(aDistribuir_estudiantes,0) + ifnull(aDistribuir_docentes,0)) as total_aDistribuir'),
                DB::raw('sum(ifnull(despachadas_estudiantes,0) + ifnull(despachadas_docentes,0)) as total_Despachado'),
                DB::raw('sum(ifnull(recepcionadas_estudiantes,0) + ifnull(recepcionadas_docentes,0)) as total_Recepcionadas'),
                DB::raw('sum(ifnull(asignadas_estudiantes,0) + ifnull(asignadas_docentes,0)) as total_Asignadas'),
            ]);

        return $data;
    }

    public static function tabletas_ultimaActualizacion()
    {
        $data = DB::table('par_importacion as imp')
            ->join('edu_tableta as tab', 'imp.id', '=', 'tab.importacion_id')
            ->join('edu_tableta_detalle as tabDet', 'tab.id', '=', 'tabDet.tableta_id')
            ->join('edu_institucioneducativa as inst', 'tabDet.institucioneducativa_id', '=', 'inst.id')
            ->join('edu_ugel as ugel', 'inst.Ugel_id', '=', 'ugel.id')
            ->where('imp.estado', '=', 'PR')
            ->orderBy('fechaActualizacion', 'desc')
            ->groupBy('fechaActualizacion')
            ->limit(1)
            ->get([
                DB::raw('fechaActualizacion'),

                DB::raw('sum(ifnull(aDistribuir_estudiantes,0) + ifnull(aDistribuir_docentes,0)) as total_aDistribuir'),
                DB::raw('sum(ifnull(despachadas_estudiantes,0) + ifnull(despachadas_docentes,0)) as total_Despachado'),
                DB::raw('sum(ifnull(recepcionadas_estudiantes,0) + ifnull(recepcionadas_docentes,0)) as total_Recepcionadas'),
                DB::raw('sum(ifnull(asignadas_estudiantes,0) + ifnull(asignadas_docentes,0)) as total_Asignadas'),
            ]);

        return $data;
    }
}
