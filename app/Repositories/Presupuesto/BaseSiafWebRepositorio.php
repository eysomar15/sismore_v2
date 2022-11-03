<?php

namespace App\Repositories\Presupuesto;

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


}
