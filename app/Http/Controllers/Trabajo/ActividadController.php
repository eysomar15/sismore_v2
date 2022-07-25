<?php

namespace App\Http\Controllers\Trabajo;
use Illuminate\Http\Request;
use App\Imports\tablaXImport;
use Exception;

use App\Http\Controllers\Controller;


class ActividadController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function Principal ()
    {
        // $anios = Anio::orderBy('anio', 'desc')->get();
       
        return view('Trabajo.Actividades.Principal');
    }

}
