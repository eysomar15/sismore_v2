<?php

namespace App\Http\Controllers\Trabajo;


use App\Http\Controllers\Controller;
use App\Models\Parametro\Anio;


class IndicadorTrabajoController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function importar()
    {
        return view('trabajo.Indicadores.principal');
    }

    
}
