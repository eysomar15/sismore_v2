<?php

namespace App\Repositories\Presupuesto;

use App\Models\Presupuesto\BaseIngresos;
use Illuminate\Support\Facades\DB;

class BaseIngresosRepositorio
{
    public static function pim_tipogobierno($importacion_id)
    {
        $query = BaseIngresos::where('pres_base_ingresos.importacion_id', $importacion_id)
            ->join('pres_pliego as v2', 'v2.id', '=', 'pres_base_ingresos.pliego_id')
            ->join('pres_unidadejecutora as v3', 'v3.id', '=', 'v2.unidadejecutora_id')
            ->join('pres_tipo_gobierno as v4', 'v4.id', '=', 'v3.tipogobierno')
            ->select(
                'v4.id',
                'v4.tipogobierno as name',
                DB::raw('sum(pres_base_ingresos.pim) as y'),
            )
            ->groupBy('id', 'name')
            ->orderBy('v4.pos', 'asc')
            ->get();
        $color = ['#7e57c2', '#317eeb', '#ef5350'];
        foreach ($query as $key => $value) {
            $value->color = $color[$key];
        }
        return $query;
    }

    public static function pim_anios_tipogobierno()
    {
        $query = BaseIngresos::select(
            'v3.id',
            'v2.anio as ano',
            DB::raw("sum(IF(v6.tipogobierno='GOBIERNO NACIONAL',pres_base_ingresos.pim,0)) as pim1"),
            DB::raw("sum(IF(v6.tipogobierno='GOBIERNOS REGIONALES',pres_base_ingresos.pim,0)) as pim2"),
            DB::raw("sum(IF(v6.tipogobierno='GOBIERNOS LOCALES',pres_base_ingresos.pim,0)) as pim3"),
        )
            ->join('par_anio as v2', 'v2.id', '=', 'pres_base_ingresos.anio_id')
            ->join('par_importacion as v3', 'v3.id', '=', 'pres_base_ingresos.importacion_id')
            ->join('pres_pliego as v4', 'v4.id', '=', 'pres_base_ingresos.pliego_id')
            ->join('pres_unidadejecutora as v5', 'v5.id', '=', 'v4.unidadejecutora_id')
            ->join('pres_tipo_gobierno as v6', 'v6.id', '=', 'v5.tipogobierno')
            ->where('v3.estado', 'PR')
            ->groupBy('id', 'ano')
            ->get();
        return $query;
    }

    public static function pim_pia_devengado_tipogobierno($importacion_id)
    {
        $query = BaseIngresos::where('pres_base_ingresos.importacion_id', $importacion_id)
            ->join('pres_pliego as v2', 'v2.id', '=', 'pres_base_ingresos.pliego_id')
            ->join('pres_unidadejecutora as v3', 'v3.id', '=', 'v2.unidadejecutora_id')
            ->join('pres_tipo_gobierno as v4', 'v4.id', '=', 'v3.tipogobierno')
            ->select(
                'v4.id',
                'v4.tipogobierno as name',
                DB::raw('sum(pres_base_ingresos.pia) as y1'),
                DB::raw('sum(pres_base_ingresos.pim) as y2'),
                DB::raw('sum(pres_base_ingresos.recaudado) as y3'),
            )
            ->groupBy('id', 'name')
            ->orderBy('v4.pos', 'asc')
            ->get();
        return $query;
    }
}
