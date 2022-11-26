<?php

namespace App\Repositories\Presupuesto;

use App\Models\Presupuesto\BaseIngresos;
use App\Models\Presupuesto\BaseIngresosDetalle;
use Illuminate\Support\Facades\DB;

class BaseIngresosRepositorio
{
    public static function fechasActualicacion_anos_max()
    {
        $fechasb = DB::table(DB::raw("(
            select
                w1.id
            from pres_base_ingresos as w1
            inner join par_importacion as w2 on w2.id = w1.importacion_id
            inner join (
                select max(x2.fechaActualizacion) as fecha from pres_base_ingresos as x1
                inner join par_importacion as x2 on x2.id = x1.importacion_id
                where x2.estado = 'PR'
                group by anio
                        ) as w3 on w3.fecha=w2.fechaActualizacion
            where w2.estado = 'PR'    ) as tb
            "))->get();
        $fechas = [];
        foreach ($fechasb as $key => $value) {
            $fechas[] = $value->id;
        }
        return $fechas;
    }

    public static function total_pim($imp)
    {
        $query = BaseIngresosDetalle::where('baseingresos_id', $imp)->select(DB::raw('sum(pim) as pim'), DB::raw('100*sum(recaudado)/sum(pim) as eje'))->first();
        return $query;
    }
    /*
    public static function pim_tipogobierno($imp)
    {
        $query = BaseGastosDetalle::select(
            'v5.id',
            'v5.tipogobierno as gobiernos',
            DB::raw('sum(pres_base_gastos_detalle.pim) as pim'),
            DB::raw('100*sum(pres_base_gastos_detalle.devengado)/sum(pres_base_gastos_detalle.pim) as eje')
        )
            ->join('pres_base_gastos as w1', 'w1.id', '=', 'pres_base_gastos_detalle.basegastos_id')
            ->join('par_importacion as w2', 'w2.id', '=', 'w1.importacion_id')
            ->join('pres_unidadejecutora as v2', 'v2.id', '=', 'pres_base_gastos_detalle.unidadejecutora_id')
            ->join('pres_pliego as v3', 'v3.id', '=', 'v2.pliego_id')
            ->join('pres_sector as v4', 'v4.id', '=', 'v3.sector_id')
            ->join('pres_tipo_gobierno as v5', 'v5.id', '=', 'v4.tipogobierno_id')
            ->where('w2.estado', 'PR')
            ->where('pres_base_gastos_detalle.basegastos_id', $imp);
        $query = $query->groupBy('id', 'gobiernos')->get();
        return $query;
    } */

    public static function pim_tipogobierno($baseingresos_id)
    {
        $query = BaseIngresosDetalle::where('pres_base_ingresos_detalle.baseingresos_id', $baseingresos_id)
            ->join('pres_unidadejecutora as v2', 'v2.id', '=', 'pres_base_ingresos_detalle.unidadejecutora_id')
            ->join('pres_pliego as v3', 'v3.id', '=', 'v2.pliego_id')
            ->join('pres_sector as v4', 'v4.id', '=', 'v3.sector_id')
            ->join('pres_tipo_gobierno as v5', 'v5.id', '=', 'v4.tipogobierno_id')
            ->select(
                'v5.id',
                'v5.tipogobierno as name',
                DB::raw('sum(pres_base_ingresos_detalle.pim) as y'),
            )
            ->groupBy('id', 'name')
            ->orderBy('v5.pos', 'asc')
            ->get();
        $color = ['#7e57c2', '#317eeb', '#ef5350'];
        foreach ($query as $key => $value) {
            $value->color = $color[$key];
        }
        return $query;
    }

    public static function pim_anios_tipogobierno()
    {
        $fechas = BaseIngresosRepositorio::fechasActualicacion_anos_max();
        $query = BaseIngresosDetalle::where('w2.estado', 'PR')
            ->join('pres_base_ingresos as w1', 'w1.id', '=', 'pres_base_ingresos_detalle.baseingresos_id')
            ->join('par_importacion as w2', 'w2.id', '=', 'w1.importacion_id')
            ->join('pres_unidadejecutora as v2', 'v2.id', '=', 'pres_base_ingresos_detalle.unidadejecutora_id')
            ->join('pres_pliego as v3', 'v3.id', '=', 'v2.pliego_id')
            ->join('pres_sector as v4', 'v4.id', '=', 'v3.sector_id')
            ->join('pres_tipo_gobierno as v5', 'v5.id', '=', 'v4.tipogobierno_id')
            ->select(
                'w1.id',
                'w1.anio as ano',
                DB::raw("sum(IF(v5.tipogobierno='GOBIERNO NACIONAL',pres_base_ingresos_detalle.pim,0)) as pim1"),
                DB::raw("sum(IF(v5.tipogobierno='GOBIERNOS REGIONALES',pres_base_ingresos_detalle.pim,0)) as pim2"),
                DB::raw("sum(IF(v5.tipogobierno='GOBIERNOS LOCALES',pres_base_ingresos_detalle.pim,0)) as pim3"),
            )
            ->whereIn('w1.id', $fechas)
            ->groupBy('id', 'ano')
            ->get();
        return $query;
    }

    public static function pim_pia_devengado_tipogobierno($baseingresos_id)
    {
        $query = BaseIngresosDetalle::where('pres_base_ingresos_detalle.baseingresos_id', $baseingresos_id)
            ->join('pres_unidadejecutora as v2', 'v2.id', '=', 'pres_base_ingresos_detalle.unidadejecutora_id')
            ->join('pres_pliego as v3', 'v3.id', '=', 'v2.pliego_id')
            ->join('pres_sector as v4', 'v4.id', '=', 'v3.sector_id')
            ->join('pres_tipo_gobierno as v5', 'v5.id', '=', 'v4.tipogobierno_id')
            ->select(
                'v5.id',
                'v5.tipogobierno as name',
                DB::raw('sum(pres_base_ingresos_detalle.pia) as y1'),
                DB::raw('sum(pres_base_ingresos_detalle.pim) as y2'),
                DB::raw('sum(pres_base_ingresos_detalle.recaudado) as y3'),
            )
            ->groupBy('id', 'name')
            ->orderBy('v5.pos', 'asc')
            ->get();
        return $query;
    }
}
