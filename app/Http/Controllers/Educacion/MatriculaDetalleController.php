<?php

namespace App\Http\Controllers\Educacion;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Exception;
use PhpParser\Node\Expr\FuncCall;

class MatriculaDetalleController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
 
}
