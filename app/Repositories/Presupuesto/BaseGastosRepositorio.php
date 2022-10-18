<?php

namespace App\Repositories\Presupuesto;

use App\Models\Presupuesto\BaseGastos;
use Illuminate\Support\Facades\DB;

class BaseGastosRepositorio
{
    public static function total_pim($imp)
    {
        $query = BaseGastos::where('importacion_id', $imp)->select(DB::raw('sum(pim) as pim'), DB::raw('100*sum(devengado)/sum(pim) as eje'))->first();
        return $query;
    }

    public static function pim_tipogobierno($imp)
    {
        $query = BaseGastos::where('pres_base_gastos.importacion_id', $imp)
            ->join('pres_pliego as v2', 'v2.id', '=', 'pres_base_gastos.pliego_id')
            ->join('pres_unidadejecutora as v3', 'v3.id', '=', 'v2.unidadejecutora_id')
            ->join('pres_tipo_gobierno as v4', 'v4.id', '=', 'v3.tipogobierno')
            ->select(
                'v4.id',
                'v4.tipogobierno as gobiernos',
                DB::raw('sum(pres_base_gastos.pim) as pim'),
                DB::raw('100*sum(pres_base_gastos.devengado)/sum(pres_base_gastos.pim) as eje')
            )
            ->groupBy('id', 'gobiernos')
            ->orderBy('v4.id', 'asc')
            ->get();
        return $query;
    }

    public static function pim_tipogobierno2($imp)
    {
        $info = BaseGastos::where('pres_base_gastos.importacion_id', $imp)
            ->join('pres_pliego as v2', 'v2.id', '=', 'pres_base_gastos.pliego_id')
            ->join('pres_unidadejecutora as v3', 'v3.id', '=', 'v2.unidadejecutora_id')
            ->join('pres_tipo_gobierno as v4', 'v4.id', '=', 'v3.tipogobierno')
            ->select(
                'v4.id',
                'v4.tipogobierno as name',
                DB::raw('sum(pres_base_gastos.pim) as y'),
            )
            ->groupBy('id', 'name')
            ->orderBy('v4.pos', 'asc')
            ->get();
        $color = ['#7e57c2', '#317eeb', '#ef5350'];
        foreach ($info as $key => $value) {
            $value->color = $color[$key];
        }
        return $info;
    }

    public static function inversiones_pim_tipogobierno($importacion_id)
    {
        $info = BaseGastos::where('pres_base_gastos.importacion_id', $importacion_id)
            ->join('pres_pliego as v2', 'v2.id', '=', 'pres_base_gastos.pliego_id')
            ->join('pres_unidadejecutora as v3', 'v3.id', '=', 'v2.unidadejecutora_id')
            ->join('pres_tipo_gobierno as v4', 'v4.id', '=', 'v3.tipogobierno')
            ->join('pres_producto_proyecto as v5', 'v5.id', '=', 'pres_base_gastos.productoproyecto_id')
            ->select(
                'v4.id',
                'v4.tipogobierno as name',
                DB::raw('sum(pres_base_gastos.pim) as y'),
            )
            ->where('v5.codigo', '2')
            ->groupBy('id', 'name')
            ->orderBy('v4.pos', 'asc')
            ->get();
        $color = ['#7e57c2', '#317eeb', '#ef5350'];
        foreach ($info as $key => $value) {
            $value->color = $color[$key];
        }
        return $info;
    }

    public static function pim_anios_tipogobierno()
    {
        $query = BaseGastos::select(
            'v3.id',
            'v2.anio as ano',
            /* 'v6.tipogobierno as tipo', */
            DB::raw("sum(IF(v6.tipogobierno='GOBIERNO NACIONAL',pres_base_gastos.pim,0)) as pim1"),
            DB::raw("sum(IF(v6.tipogobierno='GOBIERNOS REGIONALES',pres_base_gastos.pim,0)) as pim2"),
            DB::raw("sum(IF(v6.tipogobierno='GOBIERNOS LOCALES',pres_base_gastos.pim,0)) as pim3"),
        )
            ->join('par_anio as v2', 'v2.id', '=', 'pres_base_gastos.anio_id')
            ->join('par_importacion as v3', 'v3.id', '=', 'pres_base_gastos.importacion_id')
            ->join('pres_pliego as v4', 'v4.id', '=', 'pres_base_gastos.pliego_id')
            ->join('pres_unidadejecutora as v5', 'v5.id', '=', 'v4.unidadejecutora_id')
            ->join('pres_tipo_gobierno as v6', 'v6.id', '=', 'v5.tipogobierno')
            ->where('v3.estado', 'PR')
            ->groupBy('id', 'ano'/* , 'tipo' */)
            ->get();
        return $query;
    }

    public static function inversion_pim_anios_tipogobierno()
    {
        $query = BaseGastos::select(
            'v3.id',
            'v2.anio as ano',
            'v6.tipogobierno as tipo',
            DB::raw("sum(IF(v6.tipogobierno='GOBIERNO NACIONAL',pres_base_gastos.pim,0)) as pim1"),
            DB::raw("sum(IF(v6.tipogobierno='GOBIERNOS REGIONALES',pres_base_gastos.pim,0)) as pim2"),
            DB::raw("sum(IF(v6.tipogobierno='GOBIERNOS LOCALES',pres_base_gastos.pim,0)) as pim3"),
        )
            ->join('par_anio as v2', 'v2.id', '=', 'pres_base_gastos.anio_id')
            ->join('par_importacion as v3', 'v3.id', '=', 'pres_base_gastos.importacion_id')
            ->join('pres_pliego as v4', 'v4.id', '=', 'pres_base_gastos.pliego_id')
            ->join('pres_unidadejecutora as v5', 'v5.id', '=', 'v4.unidadejecutora_id')
            ->join('pres_tipo_gobierno as v6', 'v6.id', '=', 'v5.tipogobierno')
            ->join('pres_producto_proyecto as v7', 'v7.id', '=', 'pres_base_gastos.productoproyecto_id')
            ->where('v3.estado', 'PR')
            ->where('v7.codigo', '2')
            ->groupBy('id', 'ano', 'tipo')
            ->get();
        return $query;
    }
    public static function activades_pim_anios_tipogobierno()
    {
        $query = BaseGastos::select(
            'v3.id',
            'v2.anio as ano',
            /* 'v6.tipogobierno as tipo', */
            DB::raw("sum(IF(v6.tipogobierno='GOBIERNO NACIONAL',pres_base_gastos.pim,0)) as pim1"),
            DB::raw("sum(IF(v6.tipogobierno='GOBIERNOS REGIONALES',pres_base_gastos.pim,0)) as pim2"),
            DB::raw("sum(IF(v6.tipogobierno='GOBIERNOS LOCALES',pres_base_gastos.pim,0)) as pim3"),
        )
            ->join('par_anio as v2', 'v2.id', '=', 'pres_base_gastos.anio_id')
            ->join('par_importacion as v3', 'v3.id', '=', 'pres_base_gastos.importacion_id')
            ->join('pres_pliego as v4', 'v4.id', '=', 'pres_base_gastos.pliego_id')
            ->join('pres_unidadejecutora as v5', 'v5.id', '=', 'v4.unidadejecutora_id')
            ->join('pres_tipo_gobierno as v6', 'v6.id', '=', 'v5.tipogobierno')
            ->join('pres_producto_proyecto as v7', 'v7.id', '=', 'pres_base_gastos.productoproyecto_id')
            ->where('v3.estado', 'PR')
            ->where('v7.codigo', '3')
            ->groupBy('id', 'ano'/* , 'tipo' */)
            ->get();
        return $query;
    }
    public static function pim_pia_devengado_tipogobierno($importacion_id)
    {
        $query = BaseGastos::where('pres_base_gastos.importacion_id', $importacion_id)
            ->join('pres_pliego as v2', 'v2.id', '=', 'pres_base_gastos.pliego_id')
            ->join('pres_unidadejecutora as v3', 'v3.id', '=', 'v2.unidadejecutora_id')
            ->join('pres_tipo_gobierno as v4', 'v4.id', '=', 'v3.tipogobierno')
            ->select(
                'v4.id',
                'v4.tipogobierno as name',
                DB::raw('sum(pres_base_gastos.pia) as y1'),
                DB::raw('sum(pres_base_gastos.pim) as y2'),
                DB::raw('sum(pres_base_gastos.devengado) as y3'),
            )
            ->groupBy('id', 'name')
            ->orderBy('v4.pos', 'asc')
            ->get();
        return $query;
    }

    public static function inversion_pim_pia_devengado_tipogobierno($importacion_id)
    {
        $query = BaseGastos::where('pres_base_gastos.importacion_id', $importacion_id)
            ->join('pres_pliego as v2', 'v2.id', '=', 'pres_base_gastos.pliego_id')
            ->join('pres_unidadejecutora as v3', 'v3.id', '=', 'v2.unidadejecutora_id')
            ->join('pres_tipo_gobierno as v4', 'v4.id', '=', 'v3.tipogobierno')
            ->join('pres_producto_proyecto as v5', 'v5.id', '=', 'pres_base_gastos.productoproyecto_id')
            ->select(
                'v4.id',
                'v4.tipogobierno as name',
                DB::raw('sum(pres_base_gastos.pia) as y1'),
                DB::raw('sum(pres_base_gastos.pim) as y2'),
                DB::raw('sum(pres_base_gastos.devengado) as y3'),
            )
            ->where('v5.codigo', '2')
            ->groupBy('id', 'name')
            ->orderBy('v4.pos', 'asc')
            ->get();
        return $query;
    }

    public static function pim_ejecutado_noejecutado_tipogobierno()
    {
        $query = BaseGastos::select(
            'v3.id',
            'v2.anio as ano',
            DB::raw("sum(IF(v6.tipogobierno='GOBIERNO NACIONAL',pres_base_gastos.pim,0)) as gnp"),
            DB::raw("ROUND(sum(IF(v6.tipogobierno='GOBIERNO NACIONAL',pres_base_gastos.devengado,0)),2) as gnd"),
            DB::raw("ROUND(sum(IF(v6.tipogobierno='GOBIERNO NACIONAL',pres_base_gastos.pim,0))-sum(IF(v6.tipogobierno='GOBIERNO NACIONAL',pres_base_gastos.devengado,0)),2) as gnne"),

            DB::raw("sum(IF(v6.tipogobierno='GOBIERNOS LOCALES',pres_base_gastos.pim,0)) as glp"),
            DB::raw("ROUND(sum(IF(v6.tipogobierno='GOBIERNOS LOCALES',pres_base_gastos.devengado,0)),2) as gld"),
            DB::raw("ROUND(sum(IF(v6.tipogobierno='GOBIERNOS LOCALES',pres_base_gastos.pim,0))-sum(IF(v6.tipogobierno='GOBIERNOS LOCALES',pres_base_gastos.devengado,0)),2) as glne"),

            DB::raw("sum(IF(v6.tipogobierno='GOBIERNOS REGIONALES',pres_base_gastos.pim,0)) as grp"),
            DB::raw("ROUND(sum(IF(v6.tipogobierno='GOBIERNOS REGIONALES',pres_base_gastos.devengado,0)),2) as grd"),
            DB::raw("ROUND(sum(IF(v6.tipogobierno='GOBIERNOS REGIONALES',pres_base_gastos.pim,0))-sum(IF(v6.tipogobierno='GOBIERNOS REGIONALES',pres_base_gastos.devengado,0)),2) as grne"),

            DB::raw("sum(pres_base_gastos.pim) as ttp"),
            DB::raw("ROUND(sum(pres_base_gastos.devengado),2) as ttd"),
            DB::raw("ROUND(sum(pres_base_gastos.pim)-sum(pres_base_gastos.devengado),2) as ttne"),
        )
            ->join('par_anio as v2', 'v2.id', '=', 'pres_base_gastos.anio_id')
            ->join('par_importacion as v3', 'v3.id', '=', 'pres_base_gastos.importacion_id')
            ->join('pres_pliego as v4', 'v4.id', '=', 'pres_base_gastos.pliego_id')
            ->join('pres_unidadejecutora as v5', 'v5.id', '=', 'v4.unidadejecutora_id')
            ->join('pres_tipo_gobierno as v6', 'v6.id', '=', 'v5.tipogobierno')
            ->where('v3.estado', 'PR')
            ->groupBy('id', 'ano')
            ->get();
        return $query;
    }

    public static function cargarsector($tipogobierno)
    {
        $query = BaseGastos::select('v7.*')
            ->join('par_anio as v2', 'v2.id', '=', 'pres_base_gastos.anio_id')
            ->join('par_importacion as v3', 'v3.id', '=', 'pres_base_gastos.importacion_id')
            ->join('pres_pliego as v4', 'v4.id', '=', 'pres_base_gastos.pliego_id')
            ->join('pres_unidadejecutora as v5', 'v5.id', '=', 'v4.unidadejecutora_id')
            ->join('pres_tipo_gobierno as v6', 'v6.id', '=', 'v5.tipogobierno')
            ->join('pres_sector as v7', 'v7.id', '=', 'pres_base_gastos.sector_id')
            ->where('v3.estado', 'PR')->where('v6.id', $tipogobierno)
            ->distinct()
            ->get();
        return $query;
    }

    public static function cargarue($tipogobierno, $sector)
    {
        $query = BaseGastos::select('v5.id', 'v5.unidad_ejecutora')
            ->join('par_anio as v2', 'v2.id', '=', 'pres_base_gastos.anio_id')
            ->join('par_importacion as v3', 'v3.id', '=', 'pres_base_gastos.importacion_id')
            ->join('pres_pliego as v4', 'v4.id', '=', 'pres_base_gastos.pliego_id')
            ->join('pres_unidadejecutora as v5', 'v5.id', '=', 'v4.unidadejecutora_id')
            ->join('pres_tipo_gobierno as v6', 'v6.id', '=', 'v5.tipogobierno')
            ->join('pres_sector as v7', 'v7.id', '=', 'pres_base_gastos.sector_id')
            ->where('v3.estado', 'PR')->where('v6.id', $tipogobierno)->where('v7.id', $sector)
            ->distinct()->orderBy('unidad_ejecutora', 'asc')
            ->get();
        return $query;
    }

    public static function pim_anio_categoriagasto($gob, $sec, $ue)
    {
        $query = BaseGastos::select(
            'v3.id',
            'v2.anio as ano',
            DB::raw("sum(IF(v8.id=1,pres_base_gastos.pim,0)) as pim1"),
            DB::raw("sum(IF(v8.id=2,pres_base_gastos.pim,0)) as pim2"),
            DB::raw("sum(IF(v8.id=3,pres_base_gastos.pim,0)) as pim3"),
        )
            ->join('par_anio as v2', 'v2.id', '=', 'pres_base_gastos.anio_id')
            ->join('par_importacion as v3', 'v3.id', '=', 'pres_base_gastos.importacion_id')
            ->join('pres_pliego as v4', 'v4.id', '=', 'pres_base_gastos.pliego_id')
            ->join('pres_unidadejecutora as v5', 'v5.id', '=', 'v4.unidadejecutora_id')
            ->join('pres_tipo_gobierno as v6', 'v6.id', '=', 'v5.tipogobierno')
            ->join('pres_sector as v7', 'v7.id', '=', 'pres_base_gastos.sector_id')
            ->join('pres_categoriagasto as v8', 'v8.id', '=', 'pres_base_gastos.categoriagasto_id')
            ->where('v3.estado', 'PR');
        if ($gob != 0) $query = $query->where('v6.id', $gob);
        if ($sec != 0) $query = $query->where('v7.id', $sec);
        if ($ue != 0) $query = $query->where('v5.id', $ue);
        $query = $query->groupBy('id', 'ano')->get();
        return $query;
    }

    public static function pim_anio_categoriapresupuestal($gob, $sec, $ue)
    {
        $query = BaseGastos::select(
            'v3.id',
            'v2.anio as ano',
            DB::raw("sum(IF(v8.id=38,pres_base_gastos.pim,0)) as pim1"),
            DB::raw("sum(IF(v8.id=39,pres_base_gastos.pim,0)) as pim2"),
            DB::raw("sum(IF(v8.id!=38 and v8.id!=39,pres_base_gastos.pim,0)) as pim3"),
        )
            ->join('par_anio as v2', 'v2.id', '=', 'pres_base_gastos.anio_id')
            ->join('par_importacion as v3', 'v3.id', '=', 'pres_base_gastos.importacion_id')
            ->join('pres_pliego as v4', 'v4.id', '=', 'pres_base_gastos.pliego_id')
            ->join('pres_unidadejecutora as v5', 'v5.id', '=', 'v4.unidadejecutora_id')
            ->join('pres_tipo_gobierno as v6', 'v6.id', '=', 'v5.tipogobierno')
            ->join('pres_sector as v7', 'v7.id', '=', 'pres_base_gastos.sector_id')
            ->join('pres_categoriapresupuestal as v8', 'v8.id', '=', 'pres_base_gastos.categoriapresupuestal_id')
            ->where('v3.estado', 'PR');
        if ($gob != 0) $query = $query->where('v6.id', $gob);
        if ($sec != 0) $query = $query->where('v7.id', $sec);
        if ($ue != 0) $query = $query->where('v5.id', $ue);
        $query = $query->groupBy('id', 'ano')->get();
        return $query;
    }

    public static function pim_anio_fuentefimanciamiento($gob, $sec, $ue)
    {
        $query = BaseGastos::select(
            'v10.codigo as cod',
            'v10.nombre as ff',
            DB::raw("sum(IF(v2.anio=2014,pres_base_gastos.pim,0)) as pim_2014"),
            DB::raw("sum(IF(v2.anio=2015,pres_base_gastos.pim,0)) as pim_2015"),
            DB::raw("sum(IF(v2.anio=2016,pres_base_gastos.pim,0)) as pim_2016"),
            DB::raw("sum(IF(v2.anio=2017,pres_base_gastos.pim,0)) as pim_2017"),
            DB::raw("sum(IF(v2.anio=2018,pres_base_gastos.pim,0)) as pim_2018"),
            DB::raw("sum(IF(v2.anio=2019,pres_base_gastos.pim,0)) as pim_2019"),
            DB::raw("sum(IF(v2.anio=2020,pres_base_gastos.pim,0)) as pim_2020"),
            DB::raw("sum(IF(v2.anio=2021,pres_base_gastos.pim,0)) as pim_2021"),
            DB::raw("sum(IF(v2.anio=2022,pres_base_gastos.pim,0)) as pim_2022"),
        )
            ->join('par_anio as v2', 'v2.id', '=', 'pres_base_gastos.anio_id')
            ->join('par_importacion as v3', 'v3.id', '=', 'pres_base_gastos.importacion_id')
            ->join('pres_pliego as v4', 'v4.id', '=', 'pres_base_gastos.pliego_id') //
            ->join('pres_unidadejecutora as v5', 'v5.id', '=', 'v4.unidadejecutora_id') //
            ->join('pres_tipo_gobierno as v6', 'v6.id', '=', 'v5.tipogobierno') //
            ->join('pres_sector as v7', 'v7.id', '=', 'pres_base_gastos.sector_id') //
            ->join('pres_recursos_gastos as v8', 'v8.id', '=', 'pres_base_gastos.recursosgastos_id')
            ->join('pres_rubro as v9', 'v9.id', '=', 'v8.rubro_id')
            ->join('pres_fuentefinanciamiento as v10', 'v10.id', '=', 'v9.fuentefinanciamiento_id')
            ->where('v3.estado', 'PR');
        if ($gob != 0) $query = $query->where('v6.id', $gob);
        if ($sec != 0) $query = $query->where('v7.id', $sec);
        if ($ue != 0) $query = $query->where('v5.id', $ue);
        $query = $query->groupBy('cod', 'ff')->get();
        return $query;
    }

    public static function pim_anio_generica($gob, $sec, $ue)
    {
        $query = BaseGastos::select(
            'v12.codigo as cod',
            'v12.nombre as ff',
            DB::raw("sum(IF(v2.anio=2014,pres_base_gastos.pim,0)) as pim_2014"),
            DB::raw("sum(IF(v2.anio=2015,pres_base_gastos.pim,0)) as pim_2015"),
            DB::raw("sum(IF(v2.anio=2016,pres_base_gastos.pim,0)) as pim_2016"),
            DB::raw("sum(IF(v2.anio=2017,pres_base_gastos.pim,0)) as pim_2017"),
            DB::raw("sum(IF(v2.anio=2018,pres_base_gastos.pim,0)) as pim_2018"),
            DB::raw("sum(IF(v2.anio=2019,pres_base_gastos.pim,0)) as pim_2019"),
            DB::raw("sum(IF(v2.anio=2020,pres_base_gastos.pim,0)) as pim_2020"),
            DB::raw("sum(IF(v2.anio=2021,pres_base_gastos.pim,0)) as pim_2021"),
            DB::raw("sum(IF(v2.anio=2022,pres_base_gastos.pim,0)) as pim_2022"),
        )
            ->join('par_anio as v2', 'v2.id', '=', 'pres_base_gastos.anio_id')
            ->join('par_importacion as v3', 'v3.id', '=', 'pres_base_gastos.importacion_id')
            ->join('pres_pliego as v4', 'v4.id', '=', 'pres_base_gastos.pliego_id') //
            ->join('pres_unidadejecutora as v5', 'v5.id', '=', 'v4.unidadejecutora_id') //
            ->join('pres_tipo_gobierno as v6', 'v6.id', '=', 'v5.tipogobierno') //
            ->join('pres_sector as v7', 'v7.id', '=', 'pres_base_gastos.sector_id') //
            ->join('pres_especificadetalle_gastos as v8', 'v8.id', '=', 'pres_base_gastos.especificadetalle_id')
            ->join('pres_especifica_gastos as v9', 'v9.id', '=', 'v8.especifica_id')
            ->join('pres_subgenericadetalle_gastos as v10', 'v10.id', '=', 'v9.subgenericadetalle_id')
            ->join('pres_subgenerica_gastos as v11', 'v11.id', '=', 'v10.subgenerica_id')
            ->join('pres_generica_gastos as v12', 'v12.id', '=', 'v11.generica_id')
            ->where('v3.estado', 'PR');
        if ($gob != 0) $query = $query->where('v6.id', $gob);
        if ($sec != 0) $query = $query->where('v7.id', $sec);
        if ($ue != 0) $query = $query->where('v5.id', $ue);
        $query = $query->groupBy('cod', 'ff')->get();
        return $query;
    }

    public static function xxx()
    {
    }
}
