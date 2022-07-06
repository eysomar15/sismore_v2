<?php

namespace App\Http\Controllers\Presupuesto;

use App\Http\Controllers\Controller;


class UnidadEjecutoraController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

}
