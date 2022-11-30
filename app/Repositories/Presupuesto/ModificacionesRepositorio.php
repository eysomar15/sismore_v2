<?php

namespace App\Repositories\Presupuesto;

use App\Models\Presupuesto\BaseActividadesProyectos;
use App\Models\Presupuesto\BaseActividadesProyectosDetalle;
use App\Models\Presupuesto\BaseGastos;
use App\Models\Presupuesto\BaseGastosDetalle;
use App\Models\Presupuesto\BaseModificacion;
use App\Models\Presupuesto\BaseModificacionDetalle;
use App\Models\Presupuesto\BaseProyectosDetalle;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class ModificacionesRepositorio
{
    public static function anios()
    {
        $anios = BaseModificacion::select(DB::raw('distinct pres_base_modificacion.anio'))
            ->join('par_importacion as v2', 'v2.id', '=', 'pres_base_modificacion.importacion_id')
            ->orderBy('anio', 'desc')->get();
        return $anios;
    }
    public static function meses($ano)
    {
        $nommes = ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Setiembre', 'Octubre', 'Noviembre', 'Diciembre'];
        $mes = BaseModificacion::select(DB::raw('distinct pres_base_modificacion.mes'))
            ->join('par_importacion as v2', 'v2.id', '=', 'pres_base_modificacion.importacion_id')
            ->where('pres_base_modificacion.anio', $ano)
            ->orderBy('pres_base_modificacion.mes', 'desc')->get();
        foreach ($mes as $key => $value) {
            $value->nombre = $nommes[$value->mes - 1];
        }
        return $mes;
    }

    public static function listar_modificaciones($opt1, $opt2, $opt3, $opt4, $opt5, $opt6)
    {
        $query = BaseModificacionDetalle::select(
            'm4.unidad_ejecutora',
            'pres_base_modificacion_detalle.documento',
            'pres_base_modificacion_detalle.fecha_aprobacion',
            'pres_base_modificacion_detalle.justificacion',
            'm3.nombre as fuente_financiamiento',
            'm1.categoria_presupuestal',
            //DB::raw('IF(pres_base_modificacion_detalle.productos_id is null,p2.nombre,p1.nombre) as producto_proyecto'),
            DB::raw('p2.nombre as producto_proyecto'),
            'pres_base_modificacion_detalle.anulacion',
            'pres_base_modificacion_detalle.credito'
        )
            ->join('pres_base_modificacion as w1', 'w1.id', '=', 'pres_base_modificacion_detalle.basemodificacion_id')
            ->join('par_importacion as w2', 'w2.id', '=', 'w1.importacion_id')
            ->join('pres_tipomodificacion as v2', 'v2.id', '=', 'pres_base_modificacion_detalle.tipomodificacion_id')
            //->join('pres_producto_proyecto as v3', 'v3.id', '=', 'pres_base_modificacion_detalle.productoproyecto_id')
            ->join('pres_especificadetalle_gastos as v4', 'v4.id', '=', 'pres_base_modificacion_detalle.especialidaddetalle_id')
            ->join('pres_especifica_gastos as v5', 'v5.id', '=', 'v4.especifica_id')
            ->join('pres_subgenericadetalle_gastos as v6', 'v6.id', '=', 'v5.subgenericadetalle_id')
            ->join('pres_subgenerica_gastos as v7', 'v7.id', '=', 'v6.subgenerica_id')
            ->join('pres_generica_gastos as v8', 'v8.id', '=', 'v7.generica_id')
            ->join('pres_categoriapresupuestal as m1', 'm1.id', '=', 'pres_base_modificacion_detalle.categoriapresupuestal_id')
            ->join('pres_rubro as m2', 'm2.id', '=', 'pres_base_modificacion_detalle.rubro_id')
            ->join('pres_fuentefinanciamiento as m3', 'm3.id', '=', 'm2.fuentefinanciamiento_id')
            ->join('pres_unidadejecutora as m4', 'm4.id', '=', 'pres_base_modificacion_detalle.unidadejecutora_id')
            ->join('pres_productos as p1', 'p1.id', '=', 'pres_base_modificacion_detalle.productos_id', 'left')
            ->join('pres_proyectos as p2', 'p2.id', '=', 'pres_base_modificacion_detalle.proyectos_id', 'left')
            ->where('w2.estado', 'PR')
            ->where('w1.anio', $opt1)
            ->get();
        return $query;
    }


    /* public static function tipos_gobiernosregionales($ano, $mes, $tipo)
    {
        if ($tipo == 1) {
            $fechamax = BaseActividadesProyectosDetalle::select(DB::raw("max(v3.fechaActualizacion) as fecha"))
                ->join('pres_base_actividadesproyectos as v2', 'v2.id', '=', 'pres_base_actividadesproyectos_detalle.baseactividadesproyectos_id')
                ->join('par_importacion as v3', 'v3.id', '=', 'v2.importacion_id')
                ->where('v3.estado', 'PR')->where('v2.anio', $ano)->where('v2.mes', $mes)
                ->first()->fecha;

            $query = BaseActividadesProyectosDetalle::select(
                'pres_base_actividadesproyectos_detalle.id',
                'v4.gobiernoregional as corto',
                'pres_base_actividadesproyectos_detalle.pia',
                'pres_base_actividadesproyectos_detalle.pim',
                'pres_base_actividadesproyectos_detalle.certificacion',
                'pres_base_actividadesproyectos_detalle.compromiso_anual',
                'pres_base_actividadesproyectos_detalle.devengado',
                DB::raw("round(100*pres_base_actividadesproyectos_detalle.devengado/pres_base_actividadesproyectos_detalle.pim,5) as eje"),
                DB::raw('pres_base_actividadesproyectos_detalle.pim-pres_base_actividadesproyectos_detalle.certificacion as saldo1'),
                DB::raw('pres_base_actividadesproyectos_detalle.pim-pres_base_actividadesproyectos_detalle.devengado as saldo2')
            )
                ->join('pres_base_actividadesproyectos as v2', 'v2.id', '=', 'pres_base_actividadesproyectos_detalle.baseactividadesproyectos_id')
                ->join('par_importacion as v3', 'v3.id', '=', 'v2.importacion_id')
                ->join('pres_gobiernos_regionales as v4', 'v4.id', '=', 'pres_base_actividadesproyectos_detalle.gobiernosregionales_id')
                ->where('v3.estado', 'PR')->where('v3.fechaActualizacion', $fechamax);
            $query = $query->orderBy('eje', 'desc')->get();
            return $query;
        } else if ($tipo == 2) {
            $fechamax = BaseProyectosDetalle::select(DB::raw("max(v3.fechaActualizacion) as fecha"))
                ->join('pres_base_proyectos as v2', 'v2.id', '=', 'pres_base_proyectos_detalle.baseproyectos_id')
                ->join('par_importacion as v3', 'v3.id', '=', 'v2.importacion_id')
                ->where('v3.estado', 'PR')->where('v2.anio', $ano)->where('v2.mes', $mes)
                ->first()->fecha;

            $query = BaseProyectosDetalle::select(
                'pres_base_proyectos_detalle.id',
                'v4.gobiernoregional as corto',
                'pres_base_proyectos_detalle.pia',
                'pres_base_proyectos_detalle.pim',
                'pres_base_proyectos_detalle.certificacion',
                'pres_base_proyectos_detalle.compromiso_anual',
                'pres_base_proyectos_detalle.devengado',
                DB::raw("round(100*pres_base_proyectos_detalle.devengado/pres_base_proyectos_detalle.pim,5) as eje"),
                DB::raw('pres_base_proyectos_detalle.pim-pres_base_proyectos_detalle.certificacion as saldo1'),
                DB::raw('pres_base_proyectos_detalle.pim-pres_base_proyectos_detalle.devengado as saldo2')
            )
                ->join('pres_base_proyectos as v2', 'v2.id', '=', 'pres_base_proyectos_detalle.baseproyectos_id')
                ->join('par_importacion as v3', 'v3.id', '=', 'v2.importacion_id')
                ->join('pres_gobiernos_regionales as v4', 'v4.id', '=', 'pres_base_proyectos_detalle.gobiernosregionales_id')
                ->where('v3.estado', 'PR')->where('v3.fechaActualizacion', $fechamax);
            $query = $query->orderBy('eje', 'desc')->get();
            return $query;
        } else {
            $fechamax = BaseActividadesProyectosDetalle::select(DB::raw("max(v3.fechaActualizacion) as fecha"))
                ->join('pres_base_actividadesproyectos as v2', 'v2.id', '=', 'pres_base_actividadesproyectos_detalle.baseactividadesproyectos_id')
                ->join('par_importacion as v3', 'v3.id', '=', 'v2.importacion_id')
                ->where('v3.estado', 'PR')->where('v2.anio', $ano)->where('v2.mes', $mes)
                ->first()->fecha;
            $query = DB::table(DB::raw("(
                    select
                        tb2.corto as corto,
                        tb2.pia1-tb2.pia2 as pia,
                        tb2.pim1-tb2.pim2 as pim,
                        tb2.certificacion1-tb2.certificacion2 as certificacion,
                        tb2.compromiso_anual1-tb2.compromiso_anual2 as compromiso_anual,
                        tb2.devengado1-tb2.devengado2 as devengado
                    from (
                        select
                            tb1.corto as corto,
                            sum(tb1.pia1) as pia1,sum(tb1.pim1) as pim1,sum(tb1.certificacion1) as certificacion1,sum(tb1.compromiso_anual1) as compromiso_anual1,sum(tb1.devengado1) as devengado1,
                            sum(tb1.pia2) as pia2,sum(tb1.pim2) as pim2,sum(tb1.certificacion2) as certificacion2,sum(tb1.compromiso_anual2) as compromiso_anual2,sum(tb1.devengado2) as devengado2
                        from (
                            select
                                v4.gobiernoregional as corto,
                                v1.pia as pia1,v1.pim as pim1,v1.certificacion as certificacion1,v1.compromiso_anual as compromiso_anual1,v1.devengado as devengado1,
                                     0 as pia2,  0 as pim2,           0 as certificacion2,          0 as compromiso_anual2,    0 as devengado2
                            from pres_base_actividadesproyectos_detalle as v1
                            inner join pres_base_actividadesproyectos as v2 on v2.id = v1.baseactividadesproyectos_id
                            inner join par_importacion as v3 on v3.id = v2.importacion_id
                            inner join pres_gobiernos_regionales as v4 on v4.id = v1.gobiernosregionales_id
                            where v3.estado = 'PR' and v3.fechaActualizacion = '$fechamax'
                            union
                            select
                                v4.gobiernoregional as corto,
                                0 as pia1,  0 as pim1,        0 as certificacion1,   0 as compromiso_anual1,    0 as devengado1,
                                v1.pia as pia2,v1.pim as pim2,v1.certificacion as certificacion2,v1.compromiso_anual as compromiso_anual2,v1.devengado as devengado2
                                from pres_base_proyectos_detalle as v1
                                inner join pres_base_proyectos as v2 on v2.id = v1.baseproyectos_id
                                inner join par_importacion as v3 on v3.id = v2.importacion_id
                                inner join pres_gobiernos_regionales as v4 on v4.id = v1.gobiernosregionales_id
                                where v3.estado = 'PR' and v3.fechaActualizacion = '$fechamax'
                        ) as tb1  group by tb1.corto
                    ) as tb2
            ) as bb"))
                ->select(
                    '*',
                    DB::raw('round(100*devengado/pim,5) as eje'),
                    DB::raw('pim-certificacion as saldo1'),
                    DB::raw('pim-devengado as saldo2')
                )
                ->orderBy('eje', 'desc')->get();
            return $query;
        }
        //return NULL;
    } */
}
