<?php

namespace App\Http\Controllers\Educacion;

use App\Http\Controllers\Controller;
use App\Imports\tablaXImport;
use App\Models\Educacion\ImporIS;
use App\Models\Educacion\Importacion;
use App\Models\Parametro\Anio;
use App\Repositories\Educacion\ImporRERRepositorio;
use App\Repositories\Educacion\ImportacionRepositorio;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\DataTables;

use function PHPUnit\Framework\isNull;

class ImporISController extends Controller
{
    public $fuente = 29;

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function importar()
    {
        $mensaje = "";
        $anios = Anio::orderBy('anio', 'desc')->get();
        return view('educacion.ImporIS.Importar', compact('mensaje', 'anios'));
    }

    function json_output($status = 200, $msg = 'OK!!', $data = null)
    {
        header('Content-Type:application/json');
        echo json_encode([
            'status' => $status,
            'msg' => $msg,
            'data' => $data
        ]);
        die;
    }

    public function guardar(Request $request)
    {
        $fi = 29;
        $existeMismaFecha = ImportacionRepositorio::Importacion_PE($request->fechaActualizacion, $fi);
        if ($existeMismaFecha != null) {
            $mensaje = "Error, Ya existe archivos prendientes de aprobar para la fecha de versión ingresada";
            $this->json_output(400, $mensaje);
        }

        $existeMismaFecha = ImportacionRepositorio::Importacion_PR($request->fechaActualizacion, $fi);
        if ($existeMismaFecha != null) {
            $mensaje = "Error, Ya existe archivos procesados para la fecha de versión ingresada";
            $this->json_output(400, $mensaje);
        }

        $this->validate($request, ['file' => 'required|mimes:xls,xlsx']);
        $archivo = $request->file('file');
        $array = (new tablaXImport)->toArray($archivo);

        if (count($array) != 1) {
            $this->json_output(400, 'Error de Hojas, Solo debe tener una HOJA, el LIBRO EXCEL');
        }

        try {
            foreach ($array as $value) {
                foreach ($value as $celda => $row) {
                    if ($celda > 0) break;
                    $cadena =
                        $row['cod_mod'] .
                        $row['cod_local'] .
                        $row['instituto_superior'] .
                        $row['cod_carrera'] .
                        $row['carrera_especialidad'] .
                        $row['tipo_matricula'] .
                        $row['semestre'] .
                        $row['ciclo'] .
                        $row['turno'] .
                        $row['seccion'] .
                        $row['codigo_estudiante'] .
                        $row['apellido_paterno'] .
                        $row['apellido_materno'] .
                        $row['nombres'] .
                        $row['genero'] .
                        $row['fecha_nacimiento'] .
                        $row['nacionalidad'] .
                        $row['raza_etnia'] .
                        $row['con_discapacidad'];
                }
            }
        } catch (Exception $e) {
            $mensaje = "Formato de archivo no reconocido, porfavor verifique si el formato es el correcto";
            $this->json_output(403, $mensaje);
        }
        try {
            $importacion = Importacion::Create([
                'fuenteImportacion_id' => $fi, // valor predeterminado
                'usuarioId_Crea' => auth()->user()->id,
                'usuarioId_Aprueba' => null,
                'fechaActualizacion' => $request['fechaActualizacion'],
                'comentario' => $request['comentario'],
                'estado' => 'PE'
            ]);

            foreach ($array as $key => $value) {
                foreach ($value as $row) {
                    $padronWeb = ImporIS::Create([
                        'importacion_id' => $importacion->id,
                        'cod_mod' => $row['cod_mod'],
                        'cod_local' => $row['cod_local'],
                        'instituto_superior' => $row['instituto_superior'],
                        'cod_carrera' => $row['cod_carrera'],
                        'carrera_especialidad' => $row['carrera_especialidad'],
                        'tipo_matricula' => $row['tipo_matricula'],
                        'semestre' => $row['semestre'],
                        'ciclo' => $row['ciclo'],
                        'turno' => $row['turno'],
                        'seccion' => $row['seccion'],
                        'codigo_estudiante' => $row['codigo_estudiante'],
                        'apellido_paterno' => $row['apellido_paterno'],
                        'apellido_materno' => $row['apellido_materno'],
                        'nombres' => $row['nombres'],
                        'genero' => $row['genero'],
                        'fecha_nacimiento' => $row['fecha_nacimiento'],
                        'nacionalidad' => $row['nacionalidad'],
                        'raza_etnia' => $row['raza_etnia'],
                        'con_discapacidad' => $row['con_discapacidad'],
                    ]);
                }
            }
        } catch (Exception $e) {
            $importacion->estado = 'EL';
            $importacion->save();

            $mensaje = "Error en la carga de datos, verifique los datos de su archivo y/o comuniquese con el administrador del sistema" . $e->getMessage();
            $this->json_output(400, $mensaje);
        }

        /* try {
            $procesar = DB::select('call edu_pa_procesarImporMatricula(?,?)', [$importacion->id, $importacion->usuarioId_Crea]);
        } catch (Exception $e) {
            $importacion->estado = 'EL';
            $importacion->save();

            $mensaje = "Error al procesar la normalizacion de datos." . $e;
            $tipo = 'danger';
            $this->json_output(400, $mensaje);
        } */

        $mensaje = "Archivo excel subido y Procesado correctamente .";
        $this->json_output(200, $mensaje, '');
    }
    public function ListarDTImportFuenteTodos(Request $rq)
    {
        $draw = intval($rq->draw);
        $start = intval($rq->start);
        $length = intval($rq->length);

        $query = ImportacionRepositorio::Listar_FuenteTodos($this->fuente);
        $data = [];
        foreach ($query as $key => $value) {
            $nom = '';
            if (strlen($value->cnombre) > 0) {
                $xx = explode(' ', $value->cnombre);
                $nom = $xx[0];
            }
            $ape = '';
            if (strlen($value->capellidos) > 0) {
                $xx = explode(' ', $value->capellidos);
                $ape = $xx[0];
            }

            if (date('Y-m-d', strtotime($value->created_at)) == date('Y-m-d') || session('perfil_id') == 3 || session('perfil_id') == 8 || session('perfil_id') == 9 || session('perfil_id') == 10 || session('perfil_id') == 11)
                $boton = '<button type="button" onclick="geteliminar(' . $value->id . ')" class="btn btn-danger btn-xs"><i class="fa fa-trash"></i> </button>';
            else
                $boton = '';
            $boton2 = '<button type="button" onclick="monitor(' . $value->id . ')" class="btn btn-primary btn-xs"><i class="fa fa-eye"></i> </button>';
            $data[] = array(
                $key + 1,
                date("d/m/Y", strtotime($value->fechaActualizacion)),
                $value->fuente,
                $nom . ' ' . $ape,
                date("d/m/Y", strtotime($value->created_at)),
                $value->comentario,
                $value->estado == "PR" ? "PROCESADO" : ($value->estado == "PE" ? "PENDIENTE" : "ELIMINADO"),
                $boton . '&nbsp;' . $boton2,
            );
        }
        $result = array(
            "draw" => $draw,
            "recordsTotal" => $start,
            "recordsFiltered" => $length,
            "data" => $data
        );
        return response()->json($result);
    }

    public function ListaImportada(Request $rq)
    {
        $importacion_id = $rq->get('importacion_id');
        $data = ImporIS::where('importacion_id', $importacion_id)->get();
        //return response()->json($data);
        return DataTables::of($data)->make(true);
    }

    public function eliminar($id)
    {
        $entidad = Importacion::find($id);
        $entidad->estado = 'EL';
        $entidad->save();

        return response()->json(array('status' => true));
    }
}
