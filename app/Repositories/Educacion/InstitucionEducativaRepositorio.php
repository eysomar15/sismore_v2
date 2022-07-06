<?php

namespace App\Repositories\Educacion;

use App\Models\Educacion\InstitucionEducativa;

class InstitucionEducativaRepositorio
{  

    public static function InstitucionEducativa_porCodModular($codModular)
    {         
        $data = InstitucionEducativa::select('id')                
                ->where("codModular", "=", $codModular)
                ->where("anexo", "=", 0)
                ->get();

        return $data;
    } 

    
}