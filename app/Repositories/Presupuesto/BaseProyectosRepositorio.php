<?php

namespace App\Repositories\Presupuesto;

use App\Models\Presupuesto\BaseProyectosDetalle;
use Illuminate\Support\Facades\DB;

class BaseProyectosRepositorio
{

    public static function listar_regiones($base)
    {
        $query = BaseProyectosDetalle::where('pres_base_proyectos_detalle.baseproyectos_id', $base)
            ->join('pres_gobiernos_regionales as v2', 'v2.id', '=', 'pres_base_proyectos_detalle.gobiernosregionales_id')
            ->select(
                DB::raw('v2.corto as name'),
                DB::raw('"#317eeb" as color'),
                DB::raw('v2.codigo'),
                DB::raw('round(100*pres_base_proyectos_detalle.devengado/pres_base_proyectos_detalle.pim,1) as y'),
            )
            ->orderBy('y', 'desc')
            ->get();
        return $query;
    }
}
