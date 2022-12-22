<?php

namespace App\Repositories\Presupuesto;

use App\Models\Presupuesto\BaseActividadesProyectos;
use App\Models\Presupuesto\BaseActividadesProyectosDetalle;
use App\Models\Presupuesto\BaseSiafWebDetalle;
use Illuminate\Support\Facades\DB;

class BaseActividadesProyectosRepositorio
{

    public static function listar_regiones($base)
    {
        $query = BaseActividadesProyectosDetalle::where('pres_base_actividadesproyectos_detalle.baseactividadesproyectos_id', $base)
            ->join('pres_gobiernos_regionales as v2', 'v2.id', '=', 'pres_base_actividadesproyectos_detalle.gobiernosregionales_id')
            ->select(
                DB::raw('v2.corto as name'),
                DB::raw('"#317eeb" as color'),
                DB::raw('v2.codigo'),
                DB::raw('round(100*pres_base_actividadesproyectos_detalle.devengado/pres_base_actividadesproyectos_detalle.pim,1) as y'),
            )
            ->orderBy('y', 'desc')
            ->get();
        return $query;
    }

    public static function baseids_fecha_max($anio)
    { //year(curdate())
        $query = DB::table(DB::raw("(select v1.id from pres_base_actividadesproyectos v1
            join par_importacion v3 on v3.id=v1.importacion_id
            join (select anio,mes,max(dia) as dia from pres_base_actividadesproyectos where anio=$anio group by anio,mes) as v2 on v2.anio=v1.anio and v2.mes=v1.mes and v2.dia=v1.dia
            where v1.anio=$anio and v3.estado='PR') as tb"))->get();
        $array = [];
        foreach ($query as $key => $value) {
            $array[] = $value->id;
        }
        return $array;
    }

    public static function listado_ejecucion($reg) //base detallee
    {
        $query = BaseActividadesProyectosDetalle::whereIn('pres_base_actividadesproyectos_detalle.baseactividadesproyectos_id', $reg)
            ->join('pres_base_actividadesproyectos as v2', 'v2.id', '=', 'pres_base_actividadesproyectos_detalle.baseactividadesproyectos_id')
            ->join('pres_gobiernos_regionales as v3', 'v3.id', '=', 'pres_base_actividadesproyectos_detalle.gobiernosregionales_id')
            ->select(
                'v2.mes as mes',
                'v3.departamento as dep',
                DB::raw('round(100*(pres_base_actividadesproyectos_detalle.devengado)/(pres_base_actividadesproyectos_detalle.pim),5) as eje'),
            )
            ->orderBy('mes','asc')
            ->orderBy('eje','desc')
            ->get();
        return $query;
    }
}
