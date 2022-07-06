<?php

namespace App\Repositories\Vivienda;

use App\Models\Vivienda\Datass;

class DatassRepositorio
{
    public static function Listar_Por_Importacion_id($importacion_id)
    {         
        $Lista = Datass::select('id','departamento','provincia','distrito','ubigeo_cp','centro_poblado',
                              'total_viviendas','viviendas_habitadas','total_poblacion','predomina_primera_lengua',
                              'tiene_energia_electrica','tiene_internet','tiene_establecimiento_salud','pronoei','primaria',
                              'secundaria','sistema_agua','sistema_disposicion_excretas','prestador_codigo','prestador_de_servicio_agua',
                              'tipo_organizacion_comunal','cuota_familiar','servicio_agua_continuo','sistema_cloracion',
                              'realiza_cloracion_agua','tipo_sistema_agua'
                      )
        ->where("importacion_id", "=", $importacion_id)
        ->get();

        return $Lista;
    }   
}