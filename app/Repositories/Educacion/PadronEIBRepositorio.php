<?php

namespace App\Repositories\Educacion;

use Illuminate\Support\Facades\DB;

class PadronEIBRepositorio
{

    public static function listaImportada($id)
    {
        $query = DB::table(DB::raw("(
            select
                v1.id,
                v2.anio,
                v5.nombre dre,
                v4.nombre ugel,
                'UCAYALI' departamento,
                v8.nombre provincia,
                v7.nombre distrito,
                v6.nombre centro_poblado,
                v3.codModular cod_mod,
                v3.codLocal cod_local,
                v3.nombreInstEduc institucion_educativa,
                v9.codigo cod_nivelmod,
                v9.nombre nivel_modalidad,
                v1.forma_atencion,
                v1.cod_lengua,
                v1.lengua_uno,
                v1.lengua_dos,
                v1.lengua_3,
                v1.ingreso
            from edu_padron_eib v1
            join par_anio v2 on v2.id=v1.anio_id
            join edu_institucioneducativa v3 on v3.id=v1.institucioneducativa_id
            join edu_ugel v4 on v4.id=v3.Ugel_id
            join edu_ugel v5 on v5.id=v4.dependencia
            join par_centropoblado v6 on v6.id=v3.CentroPoblado_id
            join par_ubigeo v7 on v7.id=v6.Ubigeo_id
            join par_ubigeo v8 on v8.id=v7.dependencia
            join edu_nivelmodalidad v9 on v9.id=v3.NivelModalidad_id
            where v1.importacion_id=$id order by v1.id desc
        ) as tb"))->get();
        return $query;
    }
}
