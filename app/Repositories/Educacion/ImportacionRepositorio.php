<?php

namespace App\Repositories\Educacion;

use App\Models\Educacion\Importacion;
use Illuminate\Support\Facades\DB;

class ImportacionRepositorio
{
    // public static function Listar_Importaciones($sistema_id)
    // {
    //     $data = Importacion::select(
    //             'par_importacion.id','par_importacion.comentario','par_importacion.fechaActualizacion',
    //             'par_importacion.estado',
    //             // 'case when Importacion.estado = '.'PE'.'then'.'pendiente'.'else Importacion.estado end as estado',
    //             'adm_usuario.usuario',
    //             'par_fuenteimportacion.nombre',
    //             'par_fuenteimportacion.codigo',
    //             'par_fuenteimportacion.formato'
    //         )
    //         ->join('adm_usuario', 'adm_usuario.id', '=', 'par_importacion.usuarioId_crea')
    //         ->join('par_fuenteimportacion', 'par_fuenteimportacion.id', '=', 'par_importacion.fuenteImportacion_id')
    //         ->where("par_importacion.estado", "=", "PE")
    //         ->where("par_fuenteimportacion.sistema_id", "=", $sistema_id)
    //         ->orderBy('par_importacion.id', 'desc')
    //         ->get();

    //     return $data;
    // }

    public static function Listar_Importaciones($sistema_id)
    {
        $data = DB::table('par_importacion as imp')
            ->join('adm_usuario', 'adm_usuario.id', '=', 'imp.usuarioId_crea')
            ->join('par_fuenteimportacion', 'par_fuenteimportacion.id', '=', 'imp.fuenteImportacion_id')
            ->leftJoin('adm_usuario as aprueba', 'aprueba.id', '=', 'imp.usuarioId_Aprueba')

            ->leftJoin('edu_matricula_anual as matAnu', 'imp.id', '=', 'matAnu.importacion_id')
            ->leftJoin('par_anio as anioMatAnu', 'matAnu.anio_id', '=', 'anioMatAnu.id')

            ->leftJoin('edu_matricula as mat', 'imp.id', '=', 'mat.importacion_id')
            ->leftJoin('par_anio as anioMat', 'mat.anio_id', '=', 'anioMat.id')

            ->leftJoin('edu_censo as censo', 'imp.id', '=', 'censo.importacion_id')
            ->leftJoin('par_anio as anioCenso', 'censo.anio_id', '=', 'anioCenso.id')

            ->leftJoin('edu_tableta as tableta', 'imp.id', '=', 'tableta.importacion_id')
            ->leftJoin('par_anio as anioTableta', 'tableta.anio_id', '=', 'anioTableta.id')

            ->leftJoin('edu_ece as ece', 'imp.id', '=', 'ece.importacion_id')
            ->leftJoin('par_anio as anioEce', 'ece.anio_id', '=', 'anioEce.id')

            ->leftJoin('tra_proempleo as proEmp', 'imp.id', '=', 'proEmp.importacion_id')
            ->leftJoin('par_anio as anioProEmp', 'proEmp.anio_id', '=', 'anioProEmp.id')

            ->leftJoin('tra_anuario_estadistico as anuarioEstadictico', 'imp.id', '=', 'anuarioEstadictico.importacion_id')
            ->leftJoin('par_anio as anioAnuarioEstadictico', 'anuarioEstadictico.anio_id', '=', 'anioAnuarioEstadictico.id')

            ->where("imp.estado", "!=", "EL")
            ->where("par_fuenteimportacion.sistema_id", "=", $sistema_id)
            ->orderBy('imp.estado', 'asc')
            ->orderBy('imp.id', 'desc')
            ->distinct()
            ->get([
                DB::raw('imp.id'),
                DB::raw('imp.comentario'),
                DB::raw('imp.fechaActualizacion'),
                DB::raw('case when imp.estado = "PE" then "PENDIENTE" else "APROBADO" end as estado'),
                DB::raw('adm_usuario.usuario'),
                DB::raw('concat(aprueba.nombre," ", aprueba.apellidos) as aprueba'),
                DB::raw('par_fuenteimportacion.nombre'),
                DB::raw('par_fuenteimportacion.codigo'),
                DB::raw('concat(adm_usuario.nombre," ", adm_usuario.apellidos) as unombre'),
                DB::raw('adm_usuario.apellidos as uapellido'),
                DB::raw('(concat( par_fuenteimportacion.formato ," ",ifnull(anioMatAnu.anio,""),ifnull(anioMat.anio,"") ,
                                        ifnull(anioCenso.anio,"") ,ifnull(anioTableta.anio,"") ,ifnull(anioEce.anio,"") ,

                                        ifnull(
                                        case when mes = 1 then " - ENERO "
                                            when  mes = 2 then " - FEBRERO "
                                            when  mes = 3 then " - MARZO "
                                            when  mes = 4 then " - ABRIL "
                                            when  mes = 5 then " - MAYO "
                                            when  mes = 6 then " - JUNIO "
                                            when  mes = 7 then " - JULIO "
                                            when  mes = 8 then " - AGOSTO "
                                            when  mes = 9 then " - SETIEMBRE "
                                            when  mes = 10 then " - OCTUBRE "
                                            when  mes = 11 then " - NOVIEMBRE "
                                            when  mes = 12 then " - DICIEMBRE " else "" end,""),
                                            ifnull(anioProEmp.anio,"")   ,ifnull(anioAnuarioEstadictico.anio,"")

                                        )) as formato '),

            ]);

        return $data;
    }

    public static function ImportacionPor_Id($id)
    {
        $entidad = Importacion::select(
            'par_importacion.id',
            'par_importacion.comentario',
            'par_importacion.fechaActualizacion',
            'par_importacion.estado',
            'adm_usuario.usuario',
            'par_fuenteimportacion.nombre',
            'par_fuenteimportacion.formato',
            'par_importacion.created_at'
        )
            ->join('adm_usuario', 'adm_usuario.id', '=', 'par_importacion.usuarioId_crea')
            ->join('par_fuenteimportacion', 'par_fuenteimportacion.id', '=', 'par_importacion.fuenteImportacion_id')
            ->where("par_importacion.id", "=", $id)
            ->first();

        return $entidad;
    }

    public static function Importacion_mismaFecha($fechaActualizacion, $fuenteImportacion_id, $importacion_id)
    {
        $entidad = Importacion::select('par_importacion.id', 'par_importacion.fuenteImportacion_id', 'par_importacion.estado')
            ->where("par_importacion.fechaActualizacion", "=", $fechaActualizacion)
            ->where("par_importacion.fuenteImportacion_id", "=", $fuenteImportacion_id)
            ->where("par_importacion.estado", "!=", 'EL')
            ->where("par_importacion.id", "!=", $importacion_id)
            ->first();

        return $entidad;
    }

    public static function Importacion_PE($fechaActualizacion, $fuenteImportacion_id)
    {
        $entidad = Importacion::select('par_importacion.id', 'par_importacion.fuenteImportacion_id', 'par_importacion.estado')
            ->where("par_importacion.fechaActualizacion", "=", $fechaActualizacion)
            ->where("par_importacion.fuenteImportacion_id", "=", $fuenteImportacion_id)
            ->where("par_importacion.estado", "=", 'PE')
            ->first();

        return $entidad;
    }

    public static function Importacion_PR($fechaActualizacion, $fuenteImportacion_id)
    {
        $entidad = Importacion::select('par_importacion.id', 'par_importacion.fuenteImportacion_id', 'par_importacion.estado')
            ->where("par_importacion.fechaActualizacion", "=", $fechaActualizacion)
            ->where("par_importacion.fuenteImportacion_id", "=", $fuenteImportacion_id)
            ->where("par_importacion.estado", "=", 'PR')
            ->first();

        return $entidad;
    }
    public static function Listar_dePLaza()
    {
        $query = DB::table('par_importacion as v1')
            ->join('edu_plaza as v2', 'v2.importacion_id', '=', 'v1.id')
            ->where('estado', 'PR')
            ->distinct()
            ->select('v1.*')
            ->orderBy('v1.id', 'desc')
            ->get();
        return $query;
    }
    public static function Listar_deDatass()
    {
        $query = DB::table('par_importacion as v1')
            ->join('viv_datass as v2', 'v2.importacion_id', '=', 'v1.id')
            ->where('estado', 'PR')
            ->distinct()
            ->select('v1.*')
            ->orderBy('v1.id', 'desc')
            ->get();
        return $query;
    }

    public static function Listar_deCentroPobladoDatass()
    {
        $query = DB::table('par_importacion as v1')
            ->join('viv_Centropoblado_datass as v2', 'v2.importacion_id', '=', 'v1.id')
            ->where('estado', 'PR')
            ->distinct()
            ->select('v1.*')
            ->orderBy('v1.id', 'desc')
            ->get();
        return $query;
    }

    public static function Listar_soloYear()
    {
        $query = DB::table('par_importacion as v1')
            ->join('viv_Centropoblado_datass as v2', 'v2.importacion_id', '=', 'v1.id')
            ->where('v1.estado', 'PR')
            ->distinct()
            ->select(DB::raw('YEAR(v1.fechaActualizacion) as anio'))
            ->orderBy('v1.fechaActualizacion', 'desc')
            ->get();
        return $query;
    }

    public static function listar_ImportacionSinAprobarEce($grado, $tipo)
    {
        $query = DB::table('par_importacion as v1')
            ->join('edu_ece as v2', 'v2.importacion_id', '=', 'v1.id')
            ->where('v2.grado_id', $grado)
            ->where('v2.tipo', $tipo)
            ->where('v1.estado', 'PE')
            ->orderBy('v1.id', 'desc')
            ->select('v1.*')
            ->get();
        return $query;
    }

    public static function Listar_deEmapacopsa()
    {
        $query = DB::table('par_importacion as v1')
            ->join('viv_emapacopsa as v2', 'v2.importacion_id', '=', 'v1.id')
            ->where('estado', 'PR')
            ->distinct()
            ->select('v1.*')
            ->orderBy('v1.id', 'desc')
            ->get();
        return $query;
    }

    public static function Listar_FuenteTodos($fuenteImportacion_id)
    {
        $query = DB::table('par_importacion as v1')
            ->join('par_fuenteimportacion as v2', 'v2.id', '=', 'v1.fuenteImportacion_id')
            ->join('adm_usuario as v3', 'v3.id', '=', 'v1.usuarioId_Crea')
            ->join('adm_usuario as v4', 'v4.id', '=', 'v1.usuarioId_Aprueba', 'left')
            ->where('v1.fuenteImportacion_id', $fuenteImportacion_id)
            ->where('v1.estado', '!=', 'EL')
            ->orderBy('v1.fechaActualizacion', 'desc')
            ->select('v1.*', 'v2.nombre as fuente', 'v3.nombre as cnombre', 'v3.apellidos as capellidos', 'v4.nombre as anombre', 'v4.apellidos as aapellidos')
            ->get();
        return $query;
    }

    public static function Listar_FuenteTodos2($fuenteImportacion_id)
    {
        $query = DB::table('par_importacion as v1')
            ->join('par_fuenteimportacion as v2', 'v2.id', '=', 'v1.fuenteImportacion_id')
            ->join('adm_usuario as v3', 'v3.id', '=', 'v1.usuarioId_Crea')
            ->join('adm_usuario as v4', 'v4.id', '=', 'v1.usuarioId_Aprueba', 'left')
            ->whereIn('v1.fuenteImportacion_id', $fuenteImportacion_id)
            ->where('v1.estado', '!=', 'EL')
            ->orderBy('v1.id', 'desc')
            ->select('v1.*', 'v2.nombre as fuente', 'v3.nombre as cnombre', 'v3.apellidos as capellidos', 'v4.nombre as anombre', 'v4.apellidos as aapellidos')
            ->get();
        return $query;
    }

    public static function Listar_FuenteTodos_PEIB($fuenteImportacion_id)
    {
        $query = DB::table('par_importacion as v1')
            ->join('par_fuenteimportacion as v2', 'v2.id', '=', 'v1.fuenteImportacion_id')
            ->join('adm_usuario as v3', 'v3.id', '=', 'v1.usuarioId_Crea')
            ->join('adm_usuario as v4', 'v4.id', '=', 'v1.usuarioId_Aprueba', 'left')
            ->join('edu_padron_eib as v5', 'v5.importacion_id', '=', 'v1.id', 'left')
            ->join('par_anio as v6', 'v6.id', '=', 'v5.anio_id', 'left')
            ->where('v1.fuenteImportacion_id', $fuenteImportacion_id)
            ->orderBy('v1.fechaActualizacion', 'desc')
            ->select('v1.*', 'v2.nombre as fuente', 'v3.nombre as cnombre', 'v3.apellidos as capellidos', 'v4.nombre as anombre', 'v4.apellidos as aapellidos', 'v6.anio')
            ->distinct()
            ->get();
        return $query;
    }
    public static function Max_yearPadronWeb()
    {
        $query = /* (array) */  DB::table('par_importacion as v1')
            ->join('edu_padronweb as v2', 'v2.importacion_id', '=', 'v1.id')
            ->where('v1.estado', "PR")
            ->orderBy('v1.fechaActualizacion', 'desc')
            ->distinct()->select('v1.id', 'v1.fechaActualizacion as fecha', DB::raw('YEAR(v1.fechaActualizacion) as anio'))
            ->take(1)
            ->get();
        return $query;
    }

    public static function Max_porfuente($fuente)
    {
        $query = Importacion::select('id', 'fechaActualizacion as fecha')
            ->where('fuenteimportacion_id', $fuente)
            ->where('estado', 'PR')
            ->orderBy('fecha', 'desc')->get();
        return $query->count() > 0 ? $query->first()->id : 0;
        //return Importacion::select(DB::raw('max(id) as maximo'))->where('fuenteimportacion_id', $fuente)->where('estado', 'PR')->first()->maximo;
    }

    public static function ImpportacionMax_porfuente($fuente)
    {
        $query = Importacion::select('id', 'fechaActualizacion')
            ->where('fuenteimportacion_id', $fuente)
            ->where('estado', 'PR')
            ->orderBy('fechaActualizacion', 'desc')->get();
        return  $query->first()  ;
        //return Importacion::select(DB::raw('max(id) as maximo'))->where('fuenteimportacion_id', $fuente)->where('estado', 'PR')->first()->maximo;
    }

    public static function Max_yearSiagieMatricula()
    {
        $query =  DB::table('par_importacion as v1')
            ->join('edu_matricula as v2', 'v2.importacion_id', '=', 'v1.id')
            ->join('edu_matricula_detalle as v3', 'v3.matricula_id', '=', 'v2.id')
            ->where('v1.estado', "PR")
            ->orderBy('v1.fechaActualizacion', 'desc')
            ->distinct()->select(
                'v1.id as imp',
                'v1.fechaActualizacion as fecha',
                DB::raw('YEAR(v1.fechaActualizacion) as anio'),
                'v2.id as mat',
                'v2.anio_id'
            )
            ->take(1)
            ->get();
        return $query;
    }

    public static function objMaxFuenteFechaActualizacion($fuente)
    {
        $query = Importacion::where(['fuenteimportacion_id' => $fuente, 'estado' => 'PR'])->orderBy('fechaActualizacion', 'desc')->first();
        return $query;
    }
}
