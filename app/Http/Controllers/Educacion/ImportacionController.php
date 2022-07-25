<?php

namespace App\Http\Controllers\Educacion;

use App\Http\Controllers\Controller;
use App\Models\Educacion\Importacion;
use App\Repositories\Educacion\ImportacionRepositorio;
use Illuminate\Support\Facades\DB;

class ImportacionController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function inicio()
    {
        //  $data = ImportacionRepositorio::Listar_Importaciones(session('sistema_id'));

        //  return $data;
        return view('educacion.Importacion.Inicio');
    }

    public function importacionesLista_DataTable()
    {
        // $padronWebLista = Importacion::select('id','comentario','fechaActualizacion','estado')
        //  ->get();

        $data = ImportacionRepositorio::Listar_Importaciones(session('sistema_id'));
       
        return  datatables()::of($data)
            ->addColumn('action', function ($data) {

                if($data->estado=="APROBADO")
                {   
                    switch ($data->codigo) {    
                        default: $acciones = '&nbsp<button type="button" name="hy" class=" btn btn-secondary btn-sm"> <i class="fa fa-check"></i>  </button>';break;
                    }   
                }
                else
                {
                    switch ($data->codigo) {
                        case('COD01'): $acciones = '<a href="PadronWeb/Aprobar/' . $data->id . '"   class="btn btn-info btn-sm"> <i class="fa fa-check"></i> </a>';break;
                        case('COD02'): $acciones = '<a href="CuadroAsigPersonal/Aprobar/' . $data->id . '"   class="btn btn-info btn-sm"> <i class="fa fa-check"></i> </a>';break;
                        case('COD03'): $acciones = '<a href="ECE/Importar/Aprobar/' . $data->id . '"   class="btn btn-info btn-sm"> <i class="fa fa-check"></i> </a>';break;                    
                        case('COD06'): $acciones = '<a href="Censo/Aprobar/' . $data->id . '"   class="btn btn-info btn-sm"> <i class="fa fa-check"></i> </a>';break; 
                        case('COD07'): $acciones = '<a href="Datass/Aprobar/' . $data->id . '"   class="btn btn-info btn-sm"> <i class="fa fa-check"></i> </a>';break; 
                        case('COD08'): $acciones = '<a href="Matricula/Aprobar/' . $data->id . '"   class="btn btn-info btn-sm"> <i class="fa fa-check"></i> </a>';break; 
                        case('COD09'): $acciones = '<a href="Tableta/Aprobar/' . $data->id . '"   class="btn btn-info btn-sm"> <i class="fa fa-check"></i> </a>';break;
                        case('COD10'): $acciones = '<a href="Matricula/AprobarConsolidadoAnual/' . $data->id . '"   class="btn btn-info btn-sm"> <i class="fa fa-check"></i> </a>';break; 
                        case('COD11'): $acciones = '<a href="PEmapacopsa/Aprobar/' . $data->id . '"   class="btn btn-info btn-sm"> <i class="fa fa-check"></i> </a>';break;

                        case('COD18'): $acciones = '<a href="ProEmpleo/Aprobar/' . $data->id . '"   class="btn btn-info btn-sm"> <i class="fa fa-check"></i> </a>';break;
                        case('COD19'||'COD20'): $acciones = '<a href="AnuarioEstadistico/Aprobar/' . $data->id . '"   class="btn btn-info btn-sm"> <i class="fa fa-check"></i> </a>';break;
                       
                        default: $acciones = '<a href="PadronWeb/AprobarNN/' . $data->id . '"   class="btn btn-info btn-sm"> <i class="fa fa-check"></i> </a>';break;
                    }   
                }          
                
                $acciones .= '&nbsp<button type="button" name="delete" id = "' . $data->id . '" class="delete btn btn-danger btn-sm">  <i class="fa fa-trash"></i> </button>';
                return $acciones;
            })
            ->editColumn('fechaActualizacion',function($data){
                return date('d-m-Y',strtotime($data->fechaActualizacion));

            })
            /* ->editColumn('apellidos',function($data){
                return date('d-m-Y',strtotime($data->fechaActualizacion));

            }) */
            ->rawColumns(['action','fechaActualizacion'/* ,'apellidos' */])
            ->make(true);
        // ->toJson();
    }

    public function eliminar($id)
    {

        $entidad = Importacion::find($id);

        $entidad->estado = 'EL';
        $entidad->save();

        return back();
    }

    public function setEliminar($id)
    {
        $entidad = Importacion::find($id);
        $entidad->estado = 'EL';
        $entidad->save();
        return response()->json(array('status' => true));
    }

    public function resumenimportados()
    {
        return view('parametro.Importacion.ResumenImportados');
    }

    public function ListarImportadosDT($fuenteimportacion_id)
    {
        $data = ImportacionRepositorio::Listar_FuenteTodos($fuenteimportacion_id);
        return datatables()
            ->of($data)
            ->editColumn('fechaActualizacion', '{{date("d-m-Y",strtotime($fechaActualizacion))}}')
            ->editColumn('estado', function ($query) {
                return $query->estado == "PR" ? "PROCESADO" : ($query->estado == "PE" ? "PENDIENTE" : "ELIMINADO");
            })
            ->addColumn('accion', function ($oo) {
                return '<button type="button" onclick="geteliminar(' . $oo->id . ')" class="btn btn-danger btn-xs"><i class="fa fa-trash"></i> </button>';
            })
            ->rawColumns(['fechaActualizacion', 'estado', 'accion'])
            ->toJson();
    }
}
