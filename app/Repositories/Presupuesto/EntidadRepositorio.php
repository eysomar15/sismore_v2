<?php

namespace App\Repositories\Presupuesto;

use Illuminate\Support\Facades\DB;

class EntidadRepositorio
{
    public static function getEntidadOficina($oficina)
    {
        $data = DB::table('pres_entidad as v1')
            ->join('pres_entidad as v2', 'v2.id', '=', 'v1.dependencia')
            ->join('pres_unidadejecutora as v3', 'v3.id', '=', 'v2.unidadejecutadora_id')
            ->select(
                'v1.entidad as oficina',
                'v1.abreviado as oficina_abre',
                'v2.entidad as gerente',
                'v2.abreviado as gerente_abre',
                'v3.unidad_ejecutora as entidad',
                'v3.abreviatura as entidad_abre'
            )
            ->where('v1.id', $oficina)
            ->get()->first();
        return $data;
    }
}
