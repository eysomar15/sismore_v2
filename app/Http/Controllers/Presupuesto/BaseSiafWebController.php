<?php

namespace App\Http\Controllers\Presupuesto;

use App\Exports\BaseGastosExport;
use App\Http\Controllers\Controller;
use App\Models\Presupuesto\TipoGobierno;
use App\Repositories\Presupuesto\BaseGastosRepositorio;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class BaseSiafWebController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
}
