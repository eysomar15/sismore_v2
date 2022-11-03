<?php

namespace App\Repositories\Presupuesto;

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
                DB::raw('v2.codigo'),
                DB::raw('round(100*pres_base_actividadesproyectos_detalle.devengado/pres_base_actividadesproyectos_detalle.pim,1) as y'),
            )
            ->orderBy('y','desc')
            ->get();
        return $query;
    }
}
