<?php

namespace App\Repositories\Presupuesto;

use App\Models\Presupuesto\BaseSiafWeb;
use App\Models\Presupuesto\BaseSiafWebDetalle;
use Illuminate\Support\Facades\DB;

class BaseSiafWebRepositorio
{
    public static function pia_pim_certificado_devengado($base)
    {
        $query = BaseSiafWebDetalle::where('basesiafweb_id', $base)
            ->select(
                DB::raw('sum(pia) as pia'),
                DB::raw('sum(pim) as pim'),
                DB::raw('round(sum(certificado),2) as cer'),
                DB::raw('round(sum(devengado),2) as dev'),
                DB::raw('round(100*sum(devengado)/sum(pia),2) as eje_pia'),
                DB::raw('round(100*sum(devengado)/sum(pim),2) as eje_pim'),
                DB::raw('round(100*sum(certificado)/sum(pim),2) as eje_cer'),
                DB::raw('round(100*sum(devengado)/sum(certificado),2) as eje_dev')
            )
            ->first();
        return $query;
    }

    public static function baseids_fecha_max($anio)
    { //year(curdate())
        $query = DB::table(DB::raw("(select v1.id from pres_base_siafweb v1
            join par_importacion v3 on v3.id=v1.importacion_id
            join (select anio,mes,max(dia) as dia from pres_base_siafweb where anio=$anio group by anio,mes) as v2 on v2.anio=v1.anio and v2.mes=v1.mes and v2.dia=v1.dia
            where v1.anio=$anio and v3.estado='PR') as tb"))->get();
        $array = [];
        foreach ($query as $key => $value) {
            $array[] = $value->id;
        }
        return $array;
    }

    public static function suma_pim($reg) //base detallee
    {
        $query = BaseSiafWebDetalle::whereIn('pres_base_siafweb_detalle.basesiafweb_id', $reg)
            ->join('pres_base_siafweb as v2', 'v2.id', '=', 'pres_base_siafweb_detalle.basesiafweb_id')
            ->select(
                'v2.mes as name',
                DB::raw('sum(pres_base_siafweb_detalle.pim) as y'),
            )
            ->groupBy('name')
            ->get();
        return $query;
    }

    public static function suma_certificado($reg) //base detallee
    {
        $query = BaseSiafWebDetalle::whereIn('pres_base_siafweb_detalle.basesiafweb_id', $reg)
            ->join('pres_base_siafweb as v2', 'v2.id', '=', 'pres_base_siafweb_detalle.basesiafweb_id')
            ->select(
                'v2.mes as name',
                DB::raw('sum(pres_base_siafweb_detalle.certificado) as y'),
            )
            ->groupBy('name')
            ->get();
        return $query;
    }

    public static function suma_devengado($reg) //base detallee
    {
        $query = BaseSiafWebDetalle::whereIn('pres_base_siafweb_detalle.basesiafweb_id', $reg)
            ->join('pres_base_siafweb as v2', 'v2.id', '=', 'pres_base_siafweb_detalle.basesiafweb_id')
            ->select(
                'v2.mes as name',
                DB::raw('sum(pres_base_siafweb_detalle.devengado) as y'),
            )
            ->groupBy('name')
            ->get();
        return $query;
    }

    public static function suma_xxxx($reg) //base detallee
    {
        $query = BaseSiafWebDetalle::whereIn('pres_base_siafweb_detalle.basesiafweb_id', $reg)
            ->join('pres_base_siafweb as v2', 'v2.id', '=', 'pres_base_siafweb_detalle.basesiafweb_id')
            ->select(
                'v2.mes as name',
                DB::raw('sum(pres_base_siafweb_detalle.pim) as y1'),
                DB::raw('round(sum(pres_base_siafweb_detalle.certificado),2) as y2'),
                DB::raw('round(sum(pres_base_siafweb_detalle.devengado),2) as y3'),
                DB::raw('round(100*sum(pres_base_siafweb_detalle.certificado)/sum(pres_base_siafweb_detalle.pim),1) as y4'),
                DB::raw('round(100*sum(pres_base_siafweb_detalle.devengado)/sum(pres_base_siafweb_detalle.pim),1) as y5'),
            )
            ->groupBy('name')
            ->get();
        return $query;
    }
}
