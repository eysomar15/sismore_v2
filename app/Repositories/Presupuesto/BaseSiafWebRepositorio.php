<?php

namespace App\Repositories\Presupuesto;

use App\Models\Presupuesto\BaseSiafWeb;
use App\Models\Presupuesto\BaseSiafWebDetalle;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Request;

class BaseSiafWebRepositorio
{
    public static function pia_pim_certificado_devengado($base, $tipo)
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
            );
        if ($tipo != 0)
            $query = $query->where('productoproyecto_id', $tipo);
        $query = $query->first();
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

    public static function suma_pim($reg, $tipo) //base detallee
    {
        $query = BaseSiafWebDetalle::whereIn('pres_base_siafweb_detalle.basesiafweb_id', $reg)
            ->join('pres_base_siafweb as v2', 'v2.id', '=', 'pres_base_siafweb_detalle.basesiafweb_id')
            ->select(
                'v2.mes as name',
                DB::raw('sum(pres_base_siafweb_detalle.pim) as y'),
            )
            ->groupBy('name');
        if ($tipo != 0)
            $query = $query->where('pres_base_siafweb_detalle.productoproyecto_id', $tipo);
        $query = $query->get();
        return $query;
    }

    public static function suma_certificado($reg, $tipo) //base detallee
    {
        $query = BaseSiafWebDetalle::whereIn('pres_base_siafweb_detalle.basesiafweb_id', $reg)
            ->join('pres_base_siafweb as v2', 'v2.id', '=', 'pres_base_siafweb_detalle.basesiafweb_id')
            ->select(
                'v2.mes as name',
                //DB::raw('round(sum(pres_base_siafweb_detalle.certificado),2) as y'),
                DB::raw('sum(pres_base_siafweb_detalle.certificado) as y'),
            )
            ->groupBy('name');
        if ($tipo != 0)
            $query = $query->where('pres_base_siafweb_detalle.productoproyecto_id', $tipo);
        $query = $query->get();
        return $query;
    }

    public static function suma_devengado($reg, $tipo) //base detallee
    {
        $query = BaseSiafWebDetalle::whereIn('pres_base_siafweb_detalle.basesiafweb_id', $reg)
            ->join('pres_base_siafweb as v2', 'v2.id', '=', 'pres_base_siafweb_detalle.basesiafweb_id')
            ->select(
                'v2.mes as name',
                DB::raw('sum(pres_base_siafweb_detalle.devengado) as y'),
            )
            ->groupBy('name');
        if ($tipo != 0)
            $query = $query->where('pres_base_siafweb_detalle.productoproyecto_id', $tipo);
        $query = $query->get();
        return $query;
    }

    public static function suma_xxxx($reg, $tipo) //base detallee
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
            ->groupBy('name');
        if ($tipo != 0)
            $query = $query->where('pres_base_siafweb_detalle.productoproyecto_id', $tipo);
        $query = $query

            ->get();
        return $query;
    }

    public static function listar_unidadejecutora_anio_acticulo_funcion_categoria($anio, $articulo, $funcion, $categoria) //base detallee
    {
        $basesiafweb_id = BaseSiafWeb::select('pres_base_siafweb.*')
            ->join('par_importacion as v2', 'v2.id', '=', 'pres_base_siafweb.importacion_id')
            ->where('pres_base_siafweb.anio', $anio)->where('v2.estado', 'PR')
            ->orderBy('anio', 'desc')->orderBy('mes', 'desc')->orderBy('dia', 'desc')->first()->id;

        $query = BaseSiafWebDetalle::where('w1.anio', $anio)->where('w2.estado', 'PR')->where('w1.id', $basesiafweb_id)
            ->join('pres_base_siafweb as w1', 'w1.id', '=', 'pres_base_siafweb_detalle.basesiafweb_id')
            ->join('par_importacion as w2', 'w2.id', '=', 'w1.importacion_id')
            ->join('pres_unidadejecutora as v2', 'v2.id', '=', 'pres_base_siafweb_detalle.unidadejecutora_id')
            ->join('pres_categoriagasto as v3', 'v3.id', '=', 'pres_base_siafweb_detalle.categoriagasto_id')
            ->join('pres_producto_proyecto as v4', 'v4.id', '=', 'pres_base_siafweb_detalle.productoproyecto_id')
            ->join('pres_grupofuncional as v5', 'v5.id', '=', 'pres_base_siafweb_detalle.grupofuncional_id')
            ->join('pres_divisionfuncional as v5a', 'v5a.id', '=', 'v5.divisionfuncional_id')
            ->join('pres_funcion as v5b', 'v5b.id', '=', 'v5a.funcion_id')
            ->select(
                'v2.codigo_ue as codigo',
                'v2.nombre_ejecutora as ue',
                DB::raw('sum(pres_base_siafweb_detalle.pia) as pia'),
                DB::raw('sum(pres_base_siafweb_detalle.pim) as pim'),
                DB::raw('sum(pres_base_siafweb_detalle.certificado) as cert'),
                DB::raw('sum(pres_base_siafweb_detalle.devengado) as dev'),
                DB::raw('100*sum(pres_base_siafweb_detalle.devengado)/sum(pres_base_siafweb_detalle.pim) as eje'),
                DB::raw('sum(pres_base_siafweb_detalle.pim-pres_base_siafweb_detalle.certificado) as saldo1'),
                DB::raw('sum(pres_base_siafweb_detalle.pim-pres_base_siafweb_detalle.devengado) as saldo2')
            );
        if ($articulo != 0)
            $query = $query->where('v4.id', $articulo);
        if ($funcion != 0)
            $query = $query->where('v5b.id', $funcion);
        if ($categoria != 0)
            $query = $query->where('v3.id', $categoria);
        $query = $query->groupBy('codigo', 'ue')->get();
        return $query;
    }

    public static function listar_fuentefinanciamiento_anio_acticulo_ue_categoria($anio, $articulo, $ue, $categoria) //base detallee
    {
        $basesiafweb_id = BaseSiafWeb::select('pres_base_siafweb.*')
            ->join('par_importacion as v2', 'v2.id', '=', 'pres_base_siafweb.importacion_id')
            ->where('pres_base_siafweb.anio', $anio)->where('v2.estado', 'PR')
            ->orderBy('anio', 'desc')->orderBy('mes', 'desc')->orderBy('dia', 'desc')->first()->id;

        $query = BaseSiafWebDetalle::where('w1.anio', $anio)->where('w2.estado', 'PR')->where('w1.id', $basesiafweb_id)
            ->join('pres_base_siafweb as w1', 'w1.id', '=', 'pres_base_siafweb_detalle.basesiafweb_id')
            ->join('par_importacion as w2', 'w2.id', '=', 'w1.importacion_id')
            ->join('pres_unidadejecutora as v2', 'v2.id', '=', 'pres_base_siafweb_detalle.unidadejecutora_id')
            ->join('pres_categoriagasto as v3', 'v3.id', '=', 'pres_base_siafweb_detalle.categoriagasto_id')
            ->join('pres_producto_proyecto as v4', 'v4.id', '=', 'pres_base_siafweb_detalle.productoproyecto_id')
            ->join('pres_grupofuncional as v5', 'v5.id', '=', 'pres_base_siafweb_detalle.grupofuncional_id')
            ->join('pres_divisionfuncional as v5a', 'v5a.id', '=', 'v5.divisionfuncional_id')
            ->join('pres_funcion as v5b', 'v5b.id', '=', 'v5a.funcion_id')
            ->join('pres_rubro as v6', 'v6.id', '=', 'pres_base_siafweb_detalle.rubro_id')
            ->join('pres_fuentefinanciamiento as v6a', 'v6a.id', '=', 'v6.fuentefinanciamiento_id')
            ->select(
                'v6a.codigo as codigo',
                'v6a.nombre as fuente',
                DB::raw('sum(pres_base_siafweb_detalle.pia) as pia'),
                DB::raw('sum(pres_base_siafweb_detalle.pim) as pim'),
                DB::raw('sum(pres_base_siafweb_detalle.certificado) as cert'),
                DB::raw('sum(pres_base_siafweb_detalle.devengado) as dev'),
                DB::raw('100*sum(pres_base_siafweb_detalle.devengado)/sum(pres_base_siafweb_detalle.pim) as eje'),
                DB::raw('sum(pres_base_siafweb_detalle.pim-pres_base_siafweb_detalle.certificado) as saldo1'),
                DB::raw('sum(pres_base_siafweb_detalle.pim-pres_base_siafweb_detalle.devengado) as saldo2')
            );
        if ($articulo != 0)
            $query = $query->where('v4.id', $articulo);
        if ($ue != 0)
            $query = $query->where('V2.id', $ue);
        if ($categoria != 0)
            $query = $query->where('v3.id', $categoria);
        $query = $query->groupBy('codigo', 'fuente')->get();
        return $query;
    }

    public static function listar_generica_anio_acticulo_ue_categoria($anio, $articulo, $ue, $categoria) //base detallee
    {
        $basesiafweb_id = BaseSiafWeb::select('pres_base_siafweb.*')
            ->join('par_importacion as v2', 'v2.id', '=', 'pres_base_siafweb.importacion_id')
            ->where('pres_base_siafweb.anio', $anio)->where('v2.estado', 'PR')
            ->orderBy('anio', 'desc')->orderBy('mes', 'desc')->orderBy('dia', 'desc')->first()->id;

        $query = BaseSiafWebDetalle::where('w1.anio', $anio)->where('w2.estado', 'PR')->where('w1.id', $basesiafweb_id)
            ->join('pres_base_siafweb as w1', 'w1.id', '=', 'pres_base_siafweb_detalle.basesiafweb_id')
            ->join('par_importacion as w2', 'w2.id', '=', 'w1.importacion_id')
            ->join('pres_unidadejecutora as v2', 'v2.id', '=', 'pres_base_siafweb_detalle.unidadejecutora_id')
            ->join('pres_categoriagasto as v3', 'v3.id', '=', 'pres_base_siafweb_detalle.categoriagasto_id')
            ->join('pres_producto_proyecto as v4', 'v4.id', '=', 'pres_base_siafweb_detalle.productoproyecto_id')
            ->join('pres_grupofuncional as v5', 'v5.id', '=', 'pres_base_siafweb_detalle.grupofuncional_id')
            ->join('pres_divisionfuncional as v5a', 'v5a.id', '=', 'v5.divisionfuncional_id')
            ->join('pres_funcion as v5b', 'v5b.id', '=', 'v5a.funcion_id')
            ->join('pres_especificadetalle_gastos as v6', 'v6.id', '=', 'pres_base_siafweb_detalle.especificadetalle_id')
            ->join('pres_especifica_gastos as v6a', 'v6a.id', '=', 'v6.especifica_id')
            ->join('pres_subgenericadetalle_gastos as v6b', 'v6b.id', '=', 'v6a.subgenericadetalle_id')
            ->join('pres_subgenerica_gastos as v6c', 'v6c.id', '=', 'v6b.subgenerica_id')
            ->join('pres_generica_gastos as v6d', 'v6d.id', '=', 'v6c.generica_id')
            ->select(
                'v6d.codigo as codigo',
                'v6d.nombre as generica',
                DB::raw('sum(pres_base_siafweb_detalle.pia) as pia'),
                DB::raw('sum(pres_base_siafweb_detalle.pim) as pim'),
                DB::raw('sum(pres_base_siafweb_detalle.certificado) as cert'),
                DB::raw('sum(pres_base_siafweb_detalle.devengado) as dev'),
                DB::raw('100*sum(pres_base_siafweb_detalle.devengado)/sum(pres_base_siafweb_detalle.pim) as eje'),
                DB::raw('sum(pres_base_siafweb_detalle.pim-pres_base_siafweb_detalle.certificado) as saldo1'),
                DB::raw('sum(pres_base_siafweb_detalle.pim-pres_base_siafweb_detalle.devengado) as saldo2')
            );
        if ($articulo != 0)
            $query = $query->where('v4.id', $articulo);
        if ($ue != 0)
            $query = $query->where('V2.id', $ue);
        if ($categoria != 0)
            $query = $query->where('v3.id', $categoria);
        $query = $query->groupBy('codigo', 'generica')->get();
        return $query;
    }

    public static function listar_funcion_anio_acticulo_ue_categoria($anio, $articulo, $ue, $categoria) //base detallee
    {
        $basesiafweb_id = BaseSiafWeb::select('pres_base_siafweb.*')
            ->join('par_importacion as v2', 'v2.id', '=', 'pres_base_siafweb.importacion_id')
            ->where('pres_base_siafweb.anio', $anio)->where('v2.estado', 'PR')
            ->orderBy('anio', 'desc')->orderBy('mes', 'desc')->orderBy('dia', 'desc')->first()->id;

        $query = BaseSiafWebDetalle::where('w1.anio', $anio)->where('w2.estado', 'PR')->where('w1.id', $basesiafweb_id)
            ->join('pres_base_siafweb as w1', 'w1.id', '=', 'pres_base_siafweb_detalle.basesiafweb_id')
            ->join('par_importacion as w2', 'w2.id', '=', 'w1.importacion_id')
            ->join('pres_unidadejecutora as v2', 'v2.id', '=', 'pres_base_siafweb_detalle.unidadejecutora_id')
            ->join('pres_categoriagasto as v3', 'v3.id', '=', 'pres_base_siafweb_detalle.categoriagasto_id')
            ->join('pres_producto_proyecto as v4', 'v4.id', '=', 'pres_base_siafweb_detalle.productoproyecto_id')
            ->join('pres_grupofuncional as v5', 'v5.id', '=', 'pres_base_siafweb_detalle.grupofuncional_id')
            ->join('pres_divisionfuncional as v5a', 'v5a.id', '=', 'v5.divisionfuncional_id')
            ->join('pres_funcion as v5b', 'v5b.id', '=', 'v5a.funcion_id')
            ->select(
                'v5b.codigo as codigo',
                'v5b.nombre as funcion',
                DB::raw('sum(pres_base_siafweb_detalle.pia) as pia'),
                DB::raw('sum(pres_base_siafweb_detalle.pim) as pim'),
                DB::raw('sum(pres_base_siafweb_detalle.certificado) as cert'),
                DB::raw('sum(pres_base_siafweb_detalle.devengado) as dev'),
                DB::raw('100*sum(pres_base_siafweb_detalle.devengado)/sum(pres_base_siafweb_detalle.pim) as eje'),
                DB::raw('sum(pres_base_siafweb_detalle.pim-pres_base_siafweb_detalle.certificado) as saldo1'),
                DB::raw('sum(pres_base_siafweb_detalle.pim-pres_base_siafweb_detalle.devengado) as saldo2')
            );
        if ($articulo != 0)
            $query = $query->where('v4.id', $articulo);
        if ($ue != 0)
            $query = $query->where('V2.id', $ue);
        if ($categoria != 0)
            $query = $query->where('v3.id', $categoria);
        $query = $query->groupBy('codigo', 'funcion')->get();
        return $query;
    }
}
